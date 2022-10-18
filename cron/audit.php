<?php
error_reporting(-1);
ini_set('display_errors', 'On');


//chdir('/home/v/vse4etkoy2/nalic_eva-p_ru/public_html/');
chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class AuditCron extends Core
{
    public function __construct()
    {
    	parent::__construct();
        
        file_put_contents($this->config->root_dir.'cron/log.txt', date('d-m-Y H:i:s').' AUDIT RUN'.PHP_EOL, FILE_APPEND);
    }
    
    
    public function run()
    {
        $datetime = date('Y-m-d H:i:s', time() - 300);
        
        $overtime_scorings = $this->scorings->get_overtime_scorings($datetime);
        if (!empty($overtime_scorings))
        {
            foreach ($overtime_scorings as $overtime_scoring)
            {
                if (in_array($overtime_scoring->type, array('fms', 'fns', 'fssp')) && $overtime_scoring->repeat_count < 2)
                {
                    $this->scorings->update_scoring($overtime_scoring->id, array(
                        'status' => 'repeat',
                        'body' => 'Истекло время ожидания',
                        'string_result' => 'Повторный запрос',
                        'repeat_count' => $overtime_scoring->repeat_count + 1,
                    ));
                    
                }
                else
                {
                    $this->scorings->update_scoring($overtime_scoring->id, array(
                        'status' => 'error',
                        'string_result' => 'Истекло время ожидания'
                    ));
                }
            }
        }
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($overtime_scorings);echo '</pre><hr />';

        $i = 30;
        while ($i > 0)
        {
            if ($scoring = $this->scorings->get_repeat_scoring())
            {
                $this->scorings->update_scoring($scoring->id, array(
                    'status' => 'process',
                    'start_date' => date('Y-m-d H:i:s')
                ));
                
                $classname = $scoring->type."_scoring";
                
                $scoring_result = $this->{$classname}->run_scoring($scoring->id);

                $this->handling_result($scoring, $scoring_result);
            }
            $i--;
        }

        $i = 30;
        while ($i > 0)
        {
            if ($scoring = $this->scorings->get_new_scoring())
            {
                $this->scorings->update_scoring($scoring->id, array(
                    'status' => 'process',
                    'start_date' => date('Y-m-d H:i:s')
                ));
                
                $classname = $scoring->type."_scoring";
                
                $scoring_result = $this->{$classname}->run_scoring($scoring->id);
            
                $this->handling_result($scoring, $scoring_result);
            }
            $i--;
        }
        
    }

    private function handling_result($scoring, $result)
    {
        $scoring_type = $this->scorings->get_type($scoring->type);
        if ($result['status'] == 'completed' && $result['success'] == 0)
        {
            if ($scoring_type->negative_action == 'stop' || $scoring_type->negative_action == 'reject')
            {
                // останавливаем незаконченные скоринги
                
                if ($order_scorings = $this->scorings->get_scorings(array('order_id'=>$scoring->order_id)))
                {
                    foreach ($order_scorings as $os)
                    {
                        if (in_array($os->status, ['new', 'process', 'repeat']))
                        {
                            $this->scorings->update_scoring($os->id, array('status'=>'stopped'));
                        }
                    }
                }
            }

            if ($scoring_type->negative_action == 'reject')
            {
                if (!empty($scoring_type->reason_id))
                {
                    $order = $this->orders->get_order($scoring->order_id);
                    $reason = $this->reasons->get_reason($scoring_type->reason_id);
                    
                    // ставим отказ по заявке 
                    $this->orders->update_order($scoring->order_id, array(
                        'autoretry' => 0,
                        'status' => 3,
                        'reason_id' => $reason->id,
                        'reject_reason' => $reason->client_name,
                        'reject_date' => date('Y-m-d H:i:s'),
                        'manager_id' => 100, // System
                    ));

                    
                    if ($reason->type == 'mko')
                    {
                        // списываем за причину
                        $this->best2pay->reject_reason($order);
                    }

                    // отправляем постбеки в партнерки
                    $this->leadfinances->send_lead_to_leadfinances($order); //отправка лида по апи в leadfinances
                    $this->smssales->send_smssales($order, $reason->id);//отправка спама(продажа лидов по смс)
            
            
                    if (!empty($order->utm_source) && $order->utm_source == 'leadcraft' && !empty($order->id_1c) && !empty($order->click_hash)) {
                        try {
                            $this->leadgens->send_cancelled_postback($order->click_hash, $order->id_1c, $order->order_id);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
            
                    if (!empty($order->utm_source) && $order->utm_source == 'bankiru' && !empty($order->id_1c) && !empty($order->click_hash)) {
                        try {
                            $this->leadgens->send_cancelled_postback_bankiru($order->order_id, $order);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
            
                    if (!empty($order->utm_source) && $order->utm_source == 'click2money' && !empty($order->id_1c) && !empty($order->click_hash)) {
                        try {
                            $this->leadgens->send_cancelled_postback_click2money($order->order_id, $order);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
            

                }
            }
        }
        elseif ($result['status'] == 'completed')
        {
            // Автоматический запуск скоринга НБКИ при прохождении других проверок
            $order = $this->orders->get_order($scoring->order_id);
            if ($order->client_status == 'nk' || $order->client_status == 'rep')
            {
                if ($order_scorings = $this->scorings->get_scorings(array('order_id'=>$scoring->order_id)))
                {
                    $all_completed = 1;
                    foreach ($order_scorings as $order_scoring)
                    {
                        if ($order_scoring->type == 'nbki')
                            $all_completed = 0;
                        if ($order_scoring->status != 'completed' || $order_scoring->success != 1)
                            $all_completed = 0;
                    }
                    
                    if (!empty($all_completed))
                    {
                        $this->scorings->add_scoring(array(
                            'order_id' => $scoring->order_id,
                            'user_id' => $scoring->user_id,
                            'type' => 'nbki',
                            'status' => 'new',
                            'created' => date('Y-m-d H:i:s'),
                        ));
                    }
                }
            }
        }
    }
}

$cron = new AuditCron();
$cron->run();
