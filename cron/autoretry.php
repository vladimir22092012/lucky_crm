<?php
error_reporting(-1);
ini_set('display_errors', 'On');

/*

#Автоматический отказ, если:
1. Срок пользования прошлого займа = до 2 дней включительно, отказ по причине "Антиразгон 0-2".
2. Срок пользования прошлого займа = до 5 дней включиельно, отказ по причине "Разгон", исключение - *ПРАВИЛО ПРИБЫЛИ!
3. ФССП от 50k - по причине "ФССП задолженность"
4. Ст. 46 МЕНЕЕ  1 года - отказ по причине "ФССП задолженность" (за исключением ст. за ЖКХ, штрафы ГИБДД)

В итоге: Если ст. 46 более 1 года ИЛИ менее 1 года, но по ЖКХ и штрафам ГИБДД - работаем.

*Правило прибыли: клиент не подпадает под причину отказа "Разгон" в следующих условиях:
оплата процентов от 7 000 - максимальная сумма возможного займа - не менее минимально принятой суммы для НК (согласовано рекомендациям на основании данных НБКИ - https://skr.sh/sEFL7VVyYro)
оплата процентов от 10 000 - максимальная сумма возможного займа - 8 000;
оплата процентов от 15 000 - максимальная сумма возможного займа - 10 000.



#На автоматическое одобрение идут клиенты, выполняющие все условия:
1. Не было изменений анкетных данных по сравнению с прошлой заявкой.
2. Карта зачисления займа осталась прежней.
3. С момента последнего автоматического решения прошло не более 180 дней, 
    т.е. 1 раз в полгода клиенты должны проверяться руками. Важно добавить.
4. Пройдена проверка ФМС.
5. Пройдена проверка ИНН.
6. В соответствии с прошлой суммой займа и сроком рассчитанный лимит более 15000р.
7. Прошлый займ не был на суде.
При невыполнении хотя бы одного из условий - перевод на ручную обработку.

#Установление лимита кредитования: 
выбирается наименьшее между запрошенной суммой клиентов и рассчитанной суммой МКК.

Лимиты зависят от прошлой выданной суммы, срока пользования:
1. 6-14 дней + 2000р от последнего займа, но не менее минимально принятой суммы для НК 
(согласовано рекомендациям на основании данных НБКИ - https://skr.sh/sEFL7VVyYro).
2. 15 дней +4000р. от последнего займа

Бонусное увеличение +6000р. к сумме последнего займа начиная с 3-го займа, 
при условии, что этими займами пользовался от 14 дней.


*/

chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class AutoretryCron extends Core
{
    public function __construct()
    {
    	parent::__construct();
        
        if ($this->request->get('test'))
            $this->test();
        else
            $this->run();
    }
    
    private function run()
    {
    	if ($orders = $this->orders->get_orders(array('autoretry' => 1)))
        {
            foreach ($orders as $order)
            {
                // проверяем завершены ли уже скоринги, если нет переходим к следующей
                $scorings = $this->scorings->get_scorings(array('order_id' => $order->order_id, 'type' => array('fssp2', 'fms')));
                $completed_scorings = 1;
                foreach ($scorings as $scoring)
                    if (in_array($scoring->status, array('new', 'process')))
                        $completed_scorings = 0;

                if ($completed_scorings)
                {
                    if ($this->check_autoreject($order))
                    {
                        if ($this->check_anketa($order))
                        {
                            if ($this->check_scorings($order))
                            {
                                if ($this->check_sud($order))
                                {
                                    $limit = $this->get_limit($order);
                                    // 6. В соответствии с прошлой суммой займа и сроком рассчитанный лимит более 15000р.
                                    $new_order_amount = min($order->amount, $limit, 15000);
                                    if ($limit >= 15000)
                                    {
                                        $this->close_autoretry($order, 'Одобрение: Рассчитанный лимит: '.$limit.' руб', $new_order_amount);
                                        
                                        //TODO переводим заявку в одобренные
                                        $this->approve_order($order, $new_order_amount);
                                    }
                                    else
                                    {
                                        $this->close_autoretry($order, 'Ручная обработка: Рассчитанный лимит: '.$limit.' руб', $new_order_amount);
                                    }
                                }
                            }
                        }
                        
                        
                        
                    }
                }
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($order);echo '</pre><hr />';                
            }
        }
    }
    

    /**
     * AutoretryCron::get_limit()
     * 
        Лимиты зависят от прошлой выданной суммы, срока пользования:
        1. 6-14 дней + 2000р от последнего займа, но не менее минимально принятой суммы для НК 
        (согласовано рекомендациям на основании данных НБКИ - https://skr.sh/sEFL7VVyYro).
        2. 15 дней +4000р. от последнего займа
        
        Бонусное увеличение +6000р. к сумме последнего займа начиная с 3-го займа, 
        при условии, что этими займами пользовался от 14 дней.

     * @param mixed $order
     * @return void
     */
    public function get_limit($order)
    {
        $limit_amount = 0;
        
        if ($last_contract = $this->contracts->get_last_close_contract($order->user_id))
    	{
            $limit_amount += $last_contract->amount;
            
            $date_open_contract = new DateTime(date('Y-m-d', strtotime($last_contract->inssuance_date)));
            $date_close_contract = new DateTime(date('Y-m-d', strtotime($last_contract->close_date)));
            $diff = $date_close_contract->diff($date_open_contract);
            
            if ($diff->days > 5 && $diff->days < 15)
                $limit_amount += 2000;
            elseif ($diff->days > 14)
                $limit_amount += 4000;
            
            if ($diff->days > 13)
            {
                if ($prev_last_contract = $this->contracts->get_last_close_contract($order->user_id, 1))
                {
                    $date_open_prev_contract = new DateTime(date('Y-m-d', strtotime($last_contract->inssuance_date)));
                    $date_close_prev_contract = new DateTime(date('Y-m-d', strtotime($last_contract->close_date)));
                    $prev_diff = $date_close_prev_contract->diff($date_open_prev_contract);
                    if ($prev_diff->days > 13)
                        $limit_amount += 6000;
                }
            }
    	}
        
        return $limit_amount;
    }
    
    
    /**
     * AutoretryCron::check_sud()
     * 
     * 7. Прошлый займ не был на суде.
     * 
     * @return boolean
     */
    public function check_sud($order)
    {
        if ($user_contracts = $this->contracts->get_contracts(array('user_id'=>$order->user_id)))
        {
            foreach ($user_contracts as $uc)
                if (!empty($uc->sud) || !empty($uc->sud_1c))
                    return $this->close_autoretry($order, 'Ручная обработка: У клиента есть судебные займы '.$uc->number);
        }
        
    	return true;
    }    

    /**
     * AutoretryCron::check_scorings()
     * 
        4. Пройдена проверка ФМС.
        5. Пройдена проверка ИНН.

     * @param object $order
     * @return boolean
     */
    public function check_scorings($order)
    {
        $fms_scoring = $this->scorings->get_type_scoring($order->order_id, 'fms');
        if (empty($fms_scoring->success))
            return $this->close_autoretry($order, 'Ручная обработка: Проверка ФМС не пройдена');    	
        
        if (empty($order->inn))
            return $this->close_autoretry($order, 'Ручная обработка: Проверка ИНН не пройдена');    	
        
        return true;
    }
    
    /**
     * AutoretryCron::check_anketa()

        1. Не было изменений анкетных данных по сравнению с прошлой заявкой.
        2. Карта зачисления займа осталась прежней.
        3. С момента последнего автоматического решения прошло не более 180 дней, 
        т.е. 1 раз в полгода клиенты должны проверяться руками. Важно добавить.

     * @param object $order
     * @return bolean
     */
    private function check_anketa($order)
    {
        if ($order->client_status == 'crm')
        {
            if ($last_contract = $this->contracts->get_last_close_contract($order->user_id))
        	{
                $last_order = $this->orders->get_order($last_contract->order_id);
                
                if ($last_order->card_id != $order->card_id)
                    return $this->close_autoretry($order, 'Ручная обработка: Изменены данные или карта');
                
                $date_last_contract = new DateTime(date('Y-m-d', strtotime($last_contract->inssuance_date)));
                $date_order = new DateTime(date('Y-m-d', strtotime($order->date)));
                $diff = $date_order->diff($date_last_contract);
                
                if ($diff->m > 5)
                    return $this->close_autoretry($order, 'Ручная обработка: С момента последнего договора прошло более 6 месяцев');
        	}
            
            return true;
        }
        else
        {
            return $this->close_autoretry($order, '');
        }                
    }
    


    /**
     * AutoretryCron::check_autoreject()
     * 
     * Проверяет автоотказ по заявке
     * 
     * @param object $order
     * @return boolean
     */
    private function check_autoreject($order)
    {
        if ($this->check_autoreject_organic($order))
            if ($this->check_autoreject_fssp($order))
                if ($this->check_autoreject_antirazgon($order))
                    return true;
            
        return false;
    }
    
    /**
     * AutoretryCron::check_autoreject_fssp()
     * 
     * 3. ФССП от 50k - по причине "ФССП задолженность"
       4. Ст. 46 МЕНЕЕ  1 года - отказ по причине "ФССП задолженность" (за исключением ст. за ЖКХ, штрафы ГИБДД)        
       В итоге: Если ст. 46 более 1 года ИЛИ менее 1 года, но по ЖКХ и штрафам ГИБДД - работаем.
     * @param mixed $order
     * @return
     */
    private function check_autoreject_fssp($order)
    {
        // Причинa отказа: ФССП задолженность 
        if ($fssp_scoring = $this->scorings->get_type_scoring($order->order_id, 'fssp2'))
        {
            $reason = $this->reasons->get_reason(5);
            $fssp_scoring_body = unserialize($fssp_scoring->body);
            if (isset($fssp_scoring_body['sum']) && $fssp_scoring_body['sum'] > 50000)
            {
                return $this->reject($order, $reason, 'Отказ: Долг по ФССП - '.$fssp_scoring_body['sum'].' руб');
            }
            
            //TODO: Ст. 46 МЕНЕЕ  1 года
            
        }
        return true;
    }
    
    /**
     * AutoretryCron::check_autoreject_antirazgon()
     * 
     * 1. Срок пользования прошлого займа = до 2 дней включительно, отказ по причине "Антиразгон 0-2".
     * 
     * 2. Срок пользования прошлого займа = до 5 дней включиельно, отказ по причине "Разгон", 
     * исключение - *ПРАВИЛО ПРИБЫЛИ!
     * *Правило прибыли: клиент не подпадает под причину отказа "Разгон" в следующих условиях:
        оплата процентов от 7 000 - максимальная сумма возможного займа - не менее минимально принятой суммы для НК 
        (согласовано рекомендациям на основании данных НБКИ - https://skr.sh/sEFL7VVyYro)
        оплата процентов от 10 000 - максимальная сумма возможного займа - 8 000;
        оплата процентов от 15 000 - максимальная сумма возможного займа - 10 000.
     * @param mixed $order
     * @return void
     */
    private function check_autoreject_antirazgon($order)
    {
        if ($order->client_status == 'crm')
        {
            
            if ($last_contract = $this->contracts->get_last_close_contract($order->user_id))
            {
                $date_open_contract = new DateTime(date('Y-m-d', strtotime($last_contract->inssuance_date)));
                $date_close_contract = new DateTime(date('Y-m-d', strtotime($last_contract->close_date)));
                $diff = $date_close_contract->diff($date_open_contract);
                
                if ($diff->days <= 2)
                {
                    // Причинa отказа: Антиразгон 0-2
                    $reason = $this->reasons->get_reason(11);

                    $unix_maratory_end = strtotime(date('Y-m-d', strtotime($last_contract->close_date) + $reason->maratory * 86400));
                    $unix_today = strtotime(date('Y-m-d'));
                    if ($unix_today > $unix_maratory_end)
                    {
                        // время бана прошло
                        return true;
                    }
                    else
                    {
                        // время бана не прошло
                        return $this->reject($order, $reason, 'Отказ: Срок пользования займом 0-2 дней');
                    }
                }
                elseif ($diff->days <= 5)
                {
                    // Причинa отказа: Разгон
                    $reason = $this->reasons->get_reason(10);

                    $unix_maratory_end = strtotime(date('Y-m-d', strtotime($last_contract->close_date) + $reason->maratory * 86400));
                    $unix_today = strtotime(date('Y-m-d'));

                    if ($unix_today > $unix_maratory_end)
                    {
                        // время бана прошло
                        return true;
                    }
                    else
                    {
                        // время бана не прошло
                        $total_paids = 0;
                        if ($pay_transactions = $this->transactions->get_transactions(array('operation_type'=>'PAY', 'user_id'=>$order->user_id)))
                            foreach ($pay_transactions as $pt)
                                $total_paids += $pt->loan_percents_summ + $pt->loan_charge_summ;
    
                        if ($total_paids > 15000)
                        {
                            return $this->close_autoretry($order, 'Ручная обработка: Разгон. Срок пользования займом 3-5 дней. Макс. сумма выдачи 10000 руб', 10000);
                        }
                        elseif ($total_paids > 10000)
                        {
                            return $this->close_autoretry($order, 'Ручная обработка: Разгон. Срок пользования займом 3-5 дней. Макс. сумма выдачи 8000 руб', 8000);
                        }
                        elseif ($total_paids > 7000)
                        {
                            $max_amount = $this->settings->scoring_settings[12]['params']['recommended_amount_11_29'];
                            return $this->close_autoretry($order, 'Ручная обработка: Разгон. Срок пользования займом 3-5 дней. Макс. сумма выдачи '.$max_amount.' руб', $max_amount);
                        }
                        else
                        {
                            return $this->reject($order, $reason, 'Отказ: Разгон. Срок пользования займом 3-5 дней');
                        }
                    }
                }
            }
        }
    	
        return true;
    }    
    
    private function check_autoreject_organic($order)
    {
        if ($order->utm_source == 'organic')
        {
            if ($order->client_status == 'nk' || $order->client_status == 'rep')
            {                
                // Причинa отказа: Сторонний трафик 
                $reason = $this->reasons->get_reason(32);                
                return $this->reject($order, $reason, 'Автоотказ organic');
            }
        }
        
        return true;
    }
    
    /**
     * AutoretryCron::close_autoretry()
     * 
     * Останавливает авторешение
     * 
     * @param mixed $order
     * @param mixed $autoretry_result
     * @param integer $max_amount
     * @return
     */
    private function close_autoretry($order, $autoretry_result, $max_amount = 0)
    {
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($order);echo '</pre><hr />';
        $this->orders->update_order($order->order_id, array(
            'autoretry' => 0,
            'autoretry_result' => $autoretry_result,
            'autoretry_summ' => $max_amount
        ));                        

echo '<br />Закрываем автоповтор: '.$autoretry_result.'<br />';        
        return false;
    }
    
    /**
     * AutoretryCron::reject()
     * 
     * Ставит отказ по заявке
     * 
     * @param object $order
     * @param object $reason
     * @param string $autoretry_result
     * @return void
     */
    private function reject($order, $reason, $autoretry_result)
    {
        $this->orders->update_order($order->order_id, array(
            'autoretry' => 0,
            'autoretry_result' => $autoretry_result,
            'status' => 3,
            'reason_id' => $reason->id,
            'reject_reason' => $reason->client_name,
            'reject_date' => date('Y-m-d H:i:s'),
            'manager_id' => 100, // System
        ));

        if (!empty($order->id_1c))
        {
            $resp = $this->soap1c->block_order_1c($order->id_1c, 0);
            $this->soap1c->send_order_status($order->id_1c, 'Отказано');
        }

        // снимаем за причину отказа
        if ($reason->type == 'mko' && $order->status != 3)
            $this->best2pay->reject_reason($order);

        $this->leadfinances->send_lead_to_leadfinances($order); //отправка лида по апи в leadfinances
        $this->smssales->send_smssales($order, $reason->id);//отправка спама(продажа лидов по смс)
        
echo '<br />Ставим отказ "'.$autoretry_result.'" по причине '.$reason->admin_name.'<br />';
        
        return false;
    }
    

    /**
     * AutoretryCron::approve_order()
     * Одобряем заявку
     * @param mixed $order
     * @param mixed $approve_amount
     * @return
     */
    private function approve_order($order, $approve_amount)
    {
        /*
        if ($order->status != 0)
        {
            $this->orders->update_order($order->order_id, array('autoretry'=>0));
            return array('error' => 'Неверный статус заявки, возможно Заявка уже одобрена или получен отказ');
        }
        
        $new_period = min(14, $order->period);
        
        $update = array(
            'status' => 2,
            'manager_id' => 100,
            'approve_date' => date('Y-m-d H:i:s'),
            'amount' => $approve_amount,
            'uid' => exec($this->config->root_dir . 'generic/uidgen'),
            'period' => $new_period,
        );
        $old_values = array(
            'status' => $order->status,
            'manager_id' => $order->manager_id,
            'amount' => $order->amount,
            'period' => $order->period,
        );

        $this->orders->update_order($order->order_id, $update);

        $this->changelogs->add_changelog(array(
            'manager_id' => 100,
            'created' => date('Y-m-d H:i:s'),
            'type' => 'order_status',
            'old_values' => serialize($old_values),
            'new_values' => serialize($update),
            'order_id' => $order->order_id,
            'user_id' => $order->user_id,
        ));

        $accept_code = rand(1000, 9999);

        $new_contract = array(
            'order_id' => $order->order_id,
            'user_id' => $order->user_id,
            'card_id' => $order->card_id,
            'type' => 'base',
            'amount' => $approve_amount,
            'period' => $new_period,
            'create_date' => date('Y-m-d H:i:s'),
            'status' => 0,
            'base_percent' => $this->settings->loan_default_percent,
            'charge_percent' => $this->settings->loan_charge_percent,
            'peni_percent' => $this->settings->loan_peni,
            'service_reason' => $order->service_reason,
            'service_insurance' => $order->service_insurance,
            'accept_code' => $accept_code,
        );
        $contract_id = $this->contracts->add_contract($new_contract);
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($new_contract, $contract_id);echo '</pre><hr />';
        $this->orders->update_order($order->order_id, array('contract_id' => $contract_id));

        // отправялем смс
        $msg = 'Активируй займ ' . ($approve_amount * 1) . ' в личном кабинете, код ' . $accept_code . ' finfive.ru/lk';
        $this->sms->send($order->phone_mobile, $msg);
        
        $this->notify->email('sale@nalichnoeplus.com', 'Подтверждение выдачи', $msg);
    
        */
    }






    public function test()
    {
        $order_id = '251349';
        $order = $this->orders->get_order($order_id);
        
        $check_close_contract = $this->get_limit($order);
        
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($check_close_contract);echo '</pre><hr />';    
    }
    
}
new AutoretryCron();