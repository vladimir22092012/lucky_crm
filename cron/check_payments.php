<?php
error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('max_execution_time', 600);

/*
Проверка транзакций без операций
*/

chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class CheckPaymentsCron extends Core
{
    public function __construct()
    {
    	parent::__construct();
        
        $this->check_payments();
        $this->check_cards();
    }
    
    private function check_payments()
    {
        $from_time = date('Y-m-d H:00:00', time() - 24*3600);
        $to_time = date('Y-m-d H:00:00', time() - 2*3600);
        
//        $from_time = '2022-06-10 06:00:00';
//        $to_time = '2022-06-11 06:00:00';
        
        $query = $this->db->placehold("
            SELECT *
            FROM __transactions AS t
            WHERE (
                (t.operation IS NULL OR t.operation = 0)
                OR callback_response = ''
            )
            AND t.sector != 7184
            AND t.sector != 8303
            AND t.created >= ?
            AND t.created <= ?
            ORDER BY id DESC
        ", $from_time, $to_time);
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($query);echo '</pre><hr />';        
        $this->db->query($query);
        if ($transactions = $this->db->results())
        {
            echo 'COUNT: '.count($transactions).'<br />';
            foreach ($transactions as $t)
            {
                if (!empty($t->register_id))
                {
                    $this->payment_action($t->register_id);
//                    $url = $this->config->front_url.'/best2pay_callback/payment?id='.$t->register_id;
//                    $url = str_replace('https://', 'http://', $url);
//                    file_get_contents($url);
//                    usleep(100000);
//            echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($t);echo '</pre><hr />';
                }
            }
        }
    }
    
    private function payment_action($register_id)
    {
        if (!empty($register_id)) {
            if ($transaction = $this->transactions->get_register_id_transaction($register_id)) 
            {
                if ($transaction_operation = $this->operations->get_transaction_operation($transaction->id)) 
                {
                    echo 'Оплата уже принята<br />';
                } 
                else 
                {
                    $register_info = $this->best2pay->get_register_info($transaction->sector, $register_id);
                    $xml = simplexml_load_string($register_info);

                    foreach ($xml->operations as $xml_operation)
                        if ($xml_operation->operation->state == 'APPROVED')
                            $operation = (string)$xml_operation->operation->id;


                    if (!empty($operation)) 
                    {
                        $operation_info = $this->best2pay->get_operation_info($transaction->sector, $register_id, $operation);
                        $xml = simplexml_load_string($operation_info);
                        $operation_reference = (string)$xml->reference;
                        $reason_code = (string)$xml->reason_code;
                        $payment_amount = strval($xml->amount) / 100;
                        $operation_date = date('Y-m-d H:i:s', strtotime(str_replace('.', '-', (string)$xml->date)));
                        //echo __FILE__.' '.__LINE__.'<br /><pre>';echo(htmlspecialchars($operation_info));echo '</pre><hr />';

                        if ($reason_code == 1) 
                        {


                            if (!($contract = $this->contracts->get_contract($transaction->reference)))
                                $contract = $this->contracts->get_number_contract($transaction->reference);

                            $rest_amount = $payment_amount;

                            $contract_order = $this->orders->get_order((int)$contract->order_id);

                            $regaddress_full = empty($contract_order->Regindex) ? '' : $contract_order->Regindex . ', ';
                            $regaddress_full .= trim($contract_order->Regregion . ' ' . $contract_order->Regregion_shorttype);
                            $regaddress_full .= empty($contract_order->Regcity) ? '' : trim(', ' . $contract_order->Regcity . ' ' . $contract_order->Regcity_shorttype);
                            $regaddress_full .= empty($contract_order->Regdistrict) ? '' : trim(', ' . $contract_order->Regdistrict . ' ' . $contract_order->Regdistrict_shorttype);
                            $regaddress_full .= empty($contract_order->Reglocality) ? '' : trim(', ' . $contract_order->Reglocality . ' ' . $contract_order->Reglocality_shorttype);
                            $regaddress_full .= empty($contract_order->Reghousing) ? '' : ', д.' . $contract_order->Reghousing;
                            $regaddress_full .= empty($contract_order->Regbuilding) ? '' : ', стр.' . $contract_order->Regbuilding;
                            $regaddress_full .= empty($contract_order->Regroom) ? '' : ', к.' . $contract_order->Regroom;

                            $document_params = array(
                                'lastname' => $contract_order->lastname,
                                'firstname' => $contract_order->firstname,
                                'patronymic' => $contract_order->patronymic,
                                'birth' => $contract_order->birth,
                                'phone' => $contract_order->phone_mobile,
                                'regaddress_full' => $regaddress_full,
                                'passport_series' => substr(str_replace(array(' ', '-'), '', $contract_order->passport_serial), 0, 4),
                                'passport_number' => substr(str_replace(array(' ', '-'), '', $contract_order->passport_serial), 4, 6),
                                'asp' => $transaction->sms,
                                'created' => date('Y-m-d H:i:s'),
                                'base_percent' => $contract->base_percent,
                                'amount' => $contract->amount,
                                'number' => $contract->number,

                            );

                            if (!empty($transaction->prolongation)) {
                                $new_return_date = date('Y-m-d H:i:s', time() + 86400 * $this->settings->prolongation_period);

                                $document_params['return_date'] = $new_return_date;
                                $document_params['return_date_day'] = date('d', strtotime($new_return_date));
                                $document_params['return_date_month'] = date('m', strtotime($new_return_date));
                                $document_params['return_date_year'] = date('Y', strtotime($new_return_date));

                                if (empty($contract->sold) && !empty($contract->prolongation) && $contract->prolongation < 5 && $contract->type == 'base') // если это не первая пролонгация то делаем страховку
                                {
                                    $operation_id = $this->operations->add_operation(array(
                                        'contract_id' => $contract->id,
                                        'user_id' => $contract->user_id,
                                        'order_id' => $contract->order_id,
                                        'transaction_id' => $transaction->id,
                                        'type' => 'INSURANCE',
                                        'amount' => $this->settings->prolongation_amount,
                                        'created' => date('Y-m-d H:i:s'),
                                        'sent_status' => 0,
                                    ));

                                    $close_contracts = $this->contracts->get_contracts(array('user_id' => $contract->user_id, 'status' => 3));
//                                    $protection = empty($close_contracts) ? 0 : 1;
                                    $protection = 0;

                                    $insurance_id = $this->insurances->add_insurance(array(
                                        'number' => '',
                                        'amount' => $this->settings->prolongation_amount,
                                        'user_id' => $contract->user_id,
                                        'create_date' => date('Y-m-d H:i:s'),
                                        'start_date' => date('Y-m-d 00:00:00', time() + (1 * 86400)),
                                        'end_date' => date('Y-m-d 23:59:59', time() + (14 * 86400)),
                                        'operation_id' => (int)$operation_id,
                                        'protection' => $protection,
                                    ));
                                    $this->transactions->update_transaction($transaction->id, array('insurance_id' => $insurance_id));

                                    $rest_amount = $rest_amount - $this->settings->prolongation_amount;

                                    //Отправляем чек по страховке
                                    $return = $this->cloudkassir->send_insurance($operation_id);
                                    $resp = json_decode($return);

                                    $this->receipts->add_receipt(array(
                                        'user_id' => $contract->user_id,
                                        'order_id' => $contract->order_id,
                                        'contract_id' => $contract->id,
                                        'insurance_id' => $insurance_id,
                                        'receipt_url' => (string)$resp->Model->ReceiptLocalUrl,
                                        'response' => serialize($return),
                                        'created' => date('Y-m-d H:i:s'),
                                    ));

                                }
                                // продлеваем контракт
                                $this->contracts->update_contract($contract->id, array(
                                    'return_date' => $new_return_date,
                                    'prolongation' => $contract->prolongation + 1,
                                    'collection_status' => 0,
                                    'status' => 2,
                                ));

                                //Создаем пролонгацию и записываем в нее айди страховки
                                $this->prolongations->add_prolongation(array(
                                    'contract_id' => $contract->id,
                                    'user_id' => $contract->user_id,
                                    'insurance_id' => empty($insurance_id) ? '' : $insurance_id,
                                    'created' => date('Y-m-d H:i:s'),
                                    'accept_code' => $transaction->sms,
                                    'transaction_id' => $transaction->id,
                                ));


                            }

                            // списываем ответсвенность
                            $contract_loan_charge_summ = (float)$contract->loan_charge_summ;
                            if ($contract->loan_charge_summ > 0) {
                                if ($rest_amount >= $contract->loan_charge_summ) {
                                    $contract_loan_charge_summ = 0;
                                    $rest_amount = $rest_amount - $contract->loan_charge_summ;
                                    $transaction_loan_charge_summ = $contract->loan_charge_summ;
                                } else {
                                    $contract_loan_charge_summ = $contract->loan_charge_summ - $rest_amount;
                                    $transaction_loan_charge_summ = $rest_amount;
                                    $rest_amount = 0;
                                }
                            }

                            // списываем проценты
                            $contract_loan_percents_summ = (float)$contract->loan_percents_summ;
                            if ($contract->loan_percents_summ > 0) {
                                if ($rest_amount >= $contract->loan_percents_summ) {
                                    $contract_loan_percents_summ = 0;
                                    $rest_amount = $rest_amount - $contract->loan_percents_summ;
                                    $transaction_loan_percents_summ = $contract->loan_percents_summ;
                                } else {
                                    $contract_loan_percents_summ = $contract->loan_percents_summ - $rest_amount;
                                    $transaction_loan_percents_summ = $rest_amount;
                                    $rest_amount = 0;
                                }
                            }

                            // списываем основной долг
                            $contract_loan_body_summ = (float)$contract->loan_body_summ;
                            if ($contract->loan_body_summ > 0) {
                                if ($rest_amount >= $contract->loan_body_summ) {
                                    $contract_loan_body_summ = 0;
                                    $rest_amount = $rest_amount - $contract->loan_body_summ;
                                    $transaction_loan_body_summ = $contract->loan_body_summ;
                                } else {
                                    $contract_loan_body_summ = $contract->loan_body_summ - $rest_amount;
                                    $transaction_loan_body_summ = $rest_amount;
                                    $rest_amount = 0;
                                }
                            }

                            $contract_loan_peni_summ = (float)$contract->loan_peni_summ;
                            if ($contract->loan_peni_summ > 0) {
                                if ($rest_amount >= $contract->loan_peni_summ) {
                                    $contract_loan_peni_summ = 0;
                                    $rest_amount = $rest_amount - $contract->loan_peni_summ;
                                    $transaction_loan_peni_summ = $contract->loan_peni_summ;
                                } else {
                                    $contract_loan_peni_summ = $contract->loan_peni_summ - $rest_amount;
                                    $transaction_loan_peni_summ = $rest_amount;
                                    $rest_amount = 0;
                                }
                            }

                            if (!empty($contract->collection_status)) {

                                $now_date = date('Y-m-d');
                                $return_date = date('Y-m-d', strtotime($contract->return_date));

                                $now_date = new DateTime($now_date);
                                $return_date = new DateTime($return_date);

                                $delay_period = date_diff($now_date, $return_date)->days;


                                $collection_order = array(
                                    'transaction_id' => $transaction->id,
                                    'manager_id' => $contract->collection_manager_id,
                                    'contract_id' => $contract->id,
                                    'created' => date('Y-m-d H:i:s'),
                                    'body_summ' => $transaction_loan_body_summ,
                                    'percents_summ' => empty($transaction_loan_percents_summ) ? 0 : $transaction_loan_percents_summ,
                                    'charge_summ' => empty($transaction_loan_charge_summ) ? 0 : $transaction_loan_charge_summ,
                                    'peni_summ' => empty($transaction_loan_peni_summ) ? 0 : $transaction_loan_peni_summ,
                                    'commision_summ' => $transaction->commision_summ,
                                    'closed' => 0,
                                    'prolongation' => 0,
                                    'collection_status' => $contract->collection_status,
                                    'delay_period' => $delay_period
                                );
                            }

                            $this->contracts->update_contract($contract->id, array(
                                'loan_percents_summ' => $contract_loan_percents_summ,
                                'loan_charge_summ' => $contract_loan_charge_summ,
                                'loan_peni_summ' => $contract_loan_peni_summ,
                                'loan_body_summ' => $contract_loan_body_summ,
                            ));

                            $this->transactions->update_transaction($transaction->id, array(
                                'loan_percents_summ' => empty($transaction_loan_percents_summ) ? 0 : $transaction_loan_percents_summ,
                                'loan_charge_summ' => empty($transaction_loan_charge_summ) ? 0 : $transaction_loan_charge_summ,
                                'loan_peni_summ' => empty($transaction_loan_peni_summ) ? 0 : $transaction_loan_peni_summ,
                                'loan_body_summ' => empty($transaction_loan_body_summ) ? 0 : $transaction_loan_body_summ,
                            ));

                            if (!empty($transaction->prolongation)) {
                                if (!empty($collection_order))
                                    $collection_order['prolongation'] = 1;

                                $return_amount = round($contract_loan_body_summ + $contract_loan_body_summ * $contract->base_percent * 14 / 100, 2);
                                $return_amount_percents = round($contract_loan_body_summ * $contract->base_percent * 14 / 100, 2);

                                $document_params['return_amount'] = $return_amount;
                                $document_params['return_amount_percents'] = $return_amount_percents;

                                $document_params['amount'] = $contract_loan_body_summ;

                                if (empty($contract->sold))
                                {
                                    // дополнительное соглашение
                                    $this->documents->create_document(array(
                                        'user_id' => $contract->user_id,
                                        'order_id' => $contract->order_id,
                                        'contract_id' => $contract->id,
                                        'type' => 'DOP_SOGLASHENIE_PROLONGATSIYA',
                                        'params' => $document_params,
                                    ));
                                }
                                
                                if (empty($contract->sold) && !empty($contract->prolongation) && $contract->prolongation < 5 && $contract->type == 'base') // если это не первая пролонгация то делаем страховку
                                {
                                    //TODO: Сделать страховку
                                    $document_params['insurance_summ'] = 165;
                                    $document_params['insurance'] = $this->insurances->get_insurance($insurance_id);
                                    $this->documents->create_document(array(
                                        'user_id' => $contract->user_id,
                                        'order_id' => $contract->order_id,
                                        'contract_id' => $contract->id,
                                        'type' => 'POLIS_STRAHOVANIYA',
                                        'params' => $document_params,
                                    ));
                                    $this->documents->create_document(array(
                                        'user_id' => $contract->user_id,
                                        'order_id' => $contract->order_id,
                                        'contract_id' => $contract->id,
                                        'type' => 'DOP_USLUGI_PROLONGATSIYA',
                                        'params' => $document_params,
                                    ));
                                }
                            }

                            // закрываем кредит
                            $contract_loan_peni_summ = round($contract_loan_peni_summ, 2);
                            $contract_loan_percents_summ = round($contract_loan_percents_summ, 2);
                            $contract_loan_charge_summ = round($contract_loan_charge_summ, 2);
                            $contract_loan_body_summ = round($contract_loan_body_summ, 2);
                            if ($contract_loan_body_summ <= 0 && $contract_loan_percents_summ <= 0 && $contract_loan_charge_summ <= 0 && $contract_loan_peni_summ <= 0) {
                                $this->contracts->update_contract($contract->id, array(
                                    'status' => 3,
                                    'collection_status' => 0,
                                    'close_date' => date('Y-m-d H:i:s'),
                                ));

                                $this->orders->update_order($contract->order_id, array(
                                    'status' => 7
                                ));

                                if (!empty($collection_order))
                                    $collection_order['closed'] = 1;


                            }

                            if (!empty($collection_order)) {
                                $this->collections->add_collection($collection_order);
                            }


                            $this->operations->add_operation(array(
                                'contract_id' => $contract->id,
                                'user_id' => $contract->user_id,
                                'order_id' => $contract->order_id,
                                'type' => 'PAY',
                                'amount' => $payment_amount,
                                'created' => $operation_date,
                                'transaction_id' => $transaction->id,
                                'loan_body_summ' => $contract_loan_body_summ,
                                'loan_percents_summ' => $contract_loan_percents_summ,
                                'loan_charge_summ' => $contract_loan_charge_summ,
                                'loan_peni_summ' => $contract_loan_peni_summ,
                            ));


                            echo 'Оплата прошла успешно '.$transaction->id.'<br />';
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contract, $transaction);echo '</pre><hr />';
                        } 
                        else 
                        {
                            $reason_code_description = $this->best2pay->get_reason_code_description($code);
                            $this->design->assign('reason_code_description', $reason_code_description);

                            echo 'Не удалось оплатить '.$transaction->id.'<br />';
                        }
                        $this->transactions->update_transaction($transaction->id, array(
                            'operation' => $operation,
                            'callback_response' => $operation_info,
                            'reason_code' => $reason_code
                        ));


                    } 
                    else 
                    {
                        $callback_response = $this->best2pay->get_register_info($transaction->sector, $register_id);
                        $this->transactions->update_transaction($transaction->id, array(
                            'operation' => 0,
                            'callback_response' => $callback_response
                        ));
                        //echo __FILE__.' '.__LINE__.'<br /><pre>';echo(htmlspecialchars($callback_response));echo '</pre><hr />';
                        echo 'Не удалось оплатить '.$transaction->id.'<br />';

                    }
                }
            } 
            else 
            {
                echo 'Ошибка: Транзакция не найдена<br />';
            }


        } else {
            echo  'Ошибка запроса<br />';
        }


//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($_GET);echo '</pre><hr />';

    }    
    
    private function check_cards()
    {
        $from_time = date('Y-m-d H:00:00', time() - 24*3600);
        $to_time = date('Y-m-d H:00:00', time() - 1*3600);
        
//        $from_time = '2022-06-18 22:00:00';
//        $to_time = '2022-06-18 23:00:00';
        
        $query = $this->db->placehold("
            SELECT *
            FROM __transactions AS t
            WHERE (
                (t.operation IS NULL OR t.operation = 0)
                OR callback_response = ''
            )
            AND (
                t.sector = 7184
                OR t.sector = 8303
            )
            AND t.created >= ?
            AND t.created <= ?
            ORDER BY id DESC
            
            
        ", $from_time, $to_time);
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($query);echo '</pre><hr />';        
        $this->db->query($query);
        if ($transactions = $this->db->results())
        {
            echo 'COUNT: '.count($transactions).'<br />';
            foreach ($transactions as $t)
            {
                if (!empty($t->register_id))
                {
                    $this->card_action($t->register_id);
//                    $url = $this->config->front_url.'/best2pay_callback/payment?id='.$t->register_id;
//                    $url = str_replace('https://', 'http://', $url);
//                    file_get_contents($url);
//                    usleep(100000);
//            echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($t);echo '</pre><hr />';
                }
            }
        }
    }
        
    private function card_action($register_id)
    {
        $operation = $this->request->get('operation', 'integer');

        if (!empty($register_id)) {
            if ($transaction = $this->transactions->get_register_id_transaction($register_id)) {

echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($transaction);echo '</pre><hr />';

                $register_info = $this->best2pay->get_register_info($transaction->sector, $register_id);
                $xml = simplexml_load_string($register_info);

                foreach ($xml->operations as $xml_operation)
                    if ($xml_operation->operation->state == 'APPROVED')
                        $operation = (string)$xml_operation->operation->id;

                if (!empty($operation)) {
                    $operation_info = $this->best2pay->get_operation_info($transaction->sector, $register_id, $operation);
                    $xml = simplexml_load_string($operation_info);
                    $operation_reference = (string)$xml->reference;
                    $reason_code = (string)$xml->reason_code;


echo __FILE__.' '.__LINE__.'<br /><pre>';echo(htmlspecialchars($operation_info));echo '</pre><hr />';

                    if ($reason_code == 1) {

                        $card = array(
                            'user_id' => (string)$xml->reference,
                            'name' => (string)$xml->name,
                            'sector' => $transaction->sector,
                            'pan' => (string)$xml->pan,
                            'expdate' => (string)$xml->expdate,
                            'approval_code' => (string)$xml->approval_code,
                            'token' => (string)$xml->token,
                            'operation_date' => str_replace('.', '-', (string)$xml->date),
                            'created' => date('Y-m-d H:i:s'),
                            'operation' => $xml->order_id,
                            'register_id' => $transaction->register_id,
                            'transaction_id' => $transaction->id,
                            'bin_issuer' => (string)$xml->bin_issuer,
                        );
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($card);echo '</pre><hr />';
                        $cardId = $this->cards->add_card($card);
                        $this->design->assign('cardId', $cardId);
                        try{
                            $user_id = (int)$xml->reference;
                            $this->Cloudkassir->send_add_card($user_id);

                        }catch (Exception $e)
                        {

                        }

                        $meta_title = 'Карта успешно привязана';
                        $this->design->assign('success', 'Карта успешно привязана.');

                    } else {
                        $reason_code_description = $this->best2pay->get_reason_code_description($code);
                        $this->design->assign('reason_code_description', $reason_code_description);

                        $meta_title = 'Не удалось привязать карту';
                        $this->design->assign('error', 'При привязке карты произошла ошибка.');
                    }
                    $this->transactions->update_transaction($transaction->id, array(
                        'operation' => $operation,
                        'callback_response' => $operation_info,
                        'reason_code' => $reason_code
                    ));


                } else {
                    $callback_response = $this->best2pay->get_register_info($transaction->sector, $register_id, $operation);
                    $this->transactions->update_transaction($transaction->id, array(
                        'operation' => 0,
                        'callback_response' => $callback_response
                    ));
//echo __FILE__.' '.__LINE__.'<br /><pre>';echo(htmlspecialchars($callback_response));echo '</pre><hr />';
                    $meta_title = 'Не удалось привязать карту';
                    $this->design->assign('error', 'При привязке карты произошла ошибка. Код ошибки: ' . $error);

                }
            } else {
                $meta_title = 'Ошибка: Транзакция не найдена';
                $this->design->assign('error', 'Ошибка: Транзакция не найдена');
            }


        } else {
            $meta_title = 'Ошибка запроса';
            $this->design->assign('error', 'Ошибка запроса');
        }

//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($_GET);echo '</pre><hr />';

    }
    
}
new CheckPaymentsCron();