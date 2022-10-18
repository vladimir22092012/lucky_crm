<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class SmsQueueForSalesByContracts extends Core
{
    
    public function __construct()
    {
    	parent::__construct();
        
        $this->run();
    }
    
    private function run()
    {
        $smsCollection = $this->SalesByContracts->get_queue_for_sending_sms(9);

        //var_dump($smsCollection);
        //exit;

        foreach ($smsCollection as $sms) {
                    
            if ($sms->number_of == 0) {

                if (isset($sms->firstname)) {
                    $firstname = $sms->firstname;
                    $amount = $sms->amount;
                    
                    $template = $this->sms->get_template(6);
            
                    //$message =  preg_replace('/{\\$firstname}/', $firstname, $template->template, -1, $count);//из шаблонов

                    //$message = preg_replace('/{\\$amount}/', $amount, $message, -1, $count);//из шаблонов

                    $message = $sms->message;
                    if ($sms->id < 500) {
                        $result = $this->sms->send($sms->phone, $message);
                    }
                }
                
                $this->SalesByContracts->update_sms_sale($sms->id, [
                    'number_of' => ($sms->number_of + 1)
                ]);
            }
        }
    }
    
}
new SmsQueueForSalesByContracts();