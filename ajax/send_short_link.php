<?php
error_reporting(-1);
ini_set('display_errors', 'On');

session_start();

chdir('..');
require 'autoload.php';

class SendPaymentLinkAjax extends Core
{
    private $response = array();
    
    public function run()
    {
        $short_link = $this->request->post('short_link');
        $phone = $this->request->post('phone');
        $userId = $this->request->post('userId');

        if (empty($phone)) {
            $this->response['data'] = 'Ошибка. Нет номера';
            $this->output();
            return;
        } elseif (strlen($phone) != 11) {
            $this->response['data'] = 'Ошибка. Неверный формат номера';
            $this->output();
            return;
        }

        $action = $this->request->get('action', 'string');    

        switch($action || true):
            
            case 'send':
                
                $this->send_action($phone, $short_link, $userId);
                
            break;
            
        endswitch;

        $this->output();
    }

    private function send_action($phone, $short_link, $userId)
    {
        $link = parse_url('https://'.$short_link, PHP_URL_HOST);
        $msg = "Ваша ссылка для оплаты задолженности : {$link}";

        $sms = $this->sms->send($phone, $msg);

        $insert =
            [
                'code' => '0',
                'message'  => $msg,
                'phone'    => $phone,
                'response' => $sms,
                'user_id'  => $userId
            ];

        SmsMessagesORM::insert($insert);

        $this->response['data'] = 'Успешно отправлено';
    }
    
    
    private function output()
    {
        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");		
        
        echo json_encode($this->response);
    }
}

$sms_code = new SendPaymentLinkAjax();
$sms_code->run();