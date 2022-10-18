<?php

chdir('..');

require 'autoload.php';

class CardsService extends Core
{
    private $response = array();
    
    private $password = 'AX6878EK';
    
    public function __construct()
    {
    	$this->run();
    }
    
    private function run()
    {
        $password = $this->request->get('password');
        if ($password != $this->password)
            $this->output_error('Укажите пароль обмена');

        
        $order_id = $this->request->get('order_id');
        $operation_id = $this->request->get('operation_id');
        
        if (empty($order_id))
            $this->output_error('Укажите order_id');
        if (empty($operation_id))
            $this->output_error('Укажите operation_id');
        
        if ($uid = $this->request->get('uid'))
        {
            if ($user_id = $this->users->get_uid_user_id($uid))
            {
                $this->response['cards'] = $this->cards->get_cards(array('user_id'=>$user_id));
                $this->response['success'] = 1;
            }
            else
            {
                $this->response['error'] = 1;
                $this->response['message'] = 'Клиент не найден';                
            }
        }
        elseif ($number = $this->request->get('number'))
        {
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($number);echo '</pre><hr />';
            if ($contract = $this->contracts->get_number_contract($number))
            {
                $this->response['cards'] = array(
                    $this->cards->get_card($contract->card_id)
                );
                $this->response['success'] = 1;
            }
            else
            {
                $this->response['error'] = 1;
                $this->response['message'] = 'Договор не найден';                
            }
            
        }
        else
        {
            $this->response['error'] = 1;
            $this->response['message'] = 'Не указан UID клиента';
        }
        
        $this->output();
    }
    
    private function output_error($message)
    {
        $this->response['error'] = 1;
        $this->response['message'] = $message;
        $this->output();            
        
    }
    
    private function output()
    {
        header('Content-type:application/json');
        echo json_encode($this->response);
        
        exit;
    }
}
new CardsService();