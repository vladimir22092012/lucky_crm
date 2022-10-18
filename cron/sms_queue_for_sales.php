<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class SmsQueueForSalesCron extends Core
{
    
    public function __construct()
    {
    	parent::__construct();
        
        $this->run();
    }
    
    private function run()
    {
        $smsCollection = $this->smssales->get_queue_for_sending_sms(9);

        //var_dump($smsCollection);
        //exit;

        foreach ($smsCollection as $sms) {
            if ($sms->number_of == 1) {
                if (isset($sms->firstname)) {
                    $name = $sms->firstname;
                    $amount = $sms->amount;
                    
                    /*
                    // отправляем через smska.biz
                    // 699102 - Согласовано {FIRST_NAME}р у наших партнеров edmfo.ru 
                    $result = $this->sms->send_smska($sms->phone, 699102, $amount);
                    */
                    $template = $this->sms->get_template(6);

                    $message =  preg_replace('/{\\$firstname}/', $name, $template->template, -1, $count);//из шаблонов
                    $message = preg_replace('/{\\$amount}/', $amount, $message, -1, $count);//из шаблонов

                    $order = $this->orders->get_order($sms->order_id);
                    //$contract = $this->contracts->get_contract($order->contract_id);

                    $message = $this->Sms->render_by_models($message, $order);

                    $result = $this->sms->send($sms->phone, $message, 0, 'FINFIVE');
                    //$this->smssales->send_smssales($sms->phone, $message);
                }
                
                $this->smssales->update_smssales($sms->id, [
                    'number_of' => ($sms->number_of + 1)
                ]);
            }elseif ($sms->number_of == 2) {
                /*
                if (isset($sms->firstname)) {
                    $name = $sms->firstname;
                    $amount = $sms->amount;

                    $template = $this->sms->get_template(8);
            
                    $message =  preg_replace('/{\\$firstname}/', $name, $template->template, -1, $count);//из шаблонов
                    $message = preg_replace('/{\\$amount}/', $amount, $message, -1, $count);//из шаблонов

                    $order = $this->orders->get_order($sms->order_id);
                    //$contract = $this->contracts->get_contract($order->contract_id);

                    $text = $this->Sms->render_by_models($template->template, $order);

                    //$result = $this->sms->send($sms->phone, $message);
                    //$this->smssales->send_smssales($sms->phone, $message);
                }
                
                $this->smssales->update_smssales($sms->id, [
                    'number_of' => ($sms->number_of + 1)
                ]);
                */
            }
        }
    }
    
}
new SmsQueueForSalesCron();