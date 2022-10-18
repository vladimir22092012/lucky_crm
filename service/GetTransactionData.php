<?php

chdir('..');

require 'autoload.php';

class GetTransactionData extends Core
{
    private $response = array();
    
    private $password = 'AX6878EK';
    
    public function __construct()
    {
    	$this->run();
    }
    
    private function run()
    {
    	$operation_id = $this->request->get('operation_id');
        $register_id = $this->request->get('order_id');
        
        if (empty($operation_id))
        {
            $this->response['error'] = 1;
            $this->response['message'] = 'Укажите идентификатор операции';
            
            $this->output();
        }

        if (empty($register_id))
        {
            $this->response['error'] = 1;
            $this->response['message'] = 'Укажите order_id';
            
            $this->output();
        }
        
        //var_dump($operation_id, $register_id, $password);

        $password = $this->request->get('password');
        if ($password != $this->password)
        {
            $this->response['error'] = 1;
            $this->response['message'] = 'Укажите пароль обмена';
            
            $this->output();            
        }

        $transaction = $this->transactions->get_operation_transaction($register_id, $operation_id);

        if (!$transaction) {
            $this->show_error('Транзакция не найдена');
        }
        
        $orders = $this->orders->get_orders(['user_id' => $transaction->user_id]);

        if (count($orders) >= 1) {
            $order = $this->orders->get_order($orders[0]->order_id);
            if ($resp = $this->soap1c->send_order($order))
            {
                $this->orders->update_order($order->order_id, array('id_1c' => $resp->aid));
                $this->users->update_user($order->user_id, array('UID' => $resp->UID));
            } else {
                $this->response['error'] = 1;
                $this->response['message'] = 'Ошибка при отправлении ордера в 1с';
    
                $this->output();
            }

            $query = $this->db->placehold("
                SELECT * 
                FROM __cards
                WHERE transaction_id = ?
            ", (int)$transaction->id);

            $this->db->query($query);
            $card = $this->db->result();

            if ($card)
            {
                $this->cards->update_card($card->id, array('sent_status'=>0));
            }
            else
            {
                $this->show_error('Карта не найдена');
            }
        } elseif (count($orders) > 1) {
            $query = $this->db->placehold("
                SELECT * 
                FROM __cards
                WHERE transaction_id = ?
            ", (int)$transaction->id);

            $this->db->query($query);
            $card = $this->db->result();
            
            if ($card)
            {
                $this->cards->update_card($card->id, array('sent_status'=>0));
            }
            else
            {
                $this->show_error('Карта не найдена');
            }
        } else {
            $this->response['error'] = 1;
            $this->response['message'] = 'User not have order';

            $this->output();
        }

        /*
            $order = $this->orders->get_order($order_id);
            if ($resp = $this->soap1c->send_order($order))
            {
                $this->orders->update_order($order_id, array('id_1c' => $resp->aid));
                $this->users->update_user($order->user_id, array('UID' => $resp->UID));
            }
        */

        //var_dump($contract);
        //var_dump($contract->order_id);

        $this->response['success'] = 1;

        $this->response['message'] = 'Заявка отправлена повторно. Данные обновлены. Карта будет отправлена повторно';
        $this->response['reference'] = $transaction->reference;
        $this->response['user_id'] = $transaction->user_id;

        $this->output();
    }
    
    private function output()
    {
        header('Content-type:application/json');
        echo json_encode($this->response);
        
        $this->logging_(__METHOD__, 'GetTransactionData', (array)[
            'password' => $this->request->get('password'),
            'operation_id' => $this->request->get('operation_id'),
            'order_id' => $this->request->get('order_id'),
        ], $this->response, 'logs/GetTransactionData.txt');
        exit;
    }

    private function send_operation($operation)
    {
        $operation->contract = $this->contracts->get_contract($operation->contract_id);
        $operation->transaction = $this->transactions->get_transaction($operation->transaction_id);
        if ($operation->transaction->insurance_id)
            $operation->transaction->insurance = $this->insurances->get_insurance($operation->transaction->insurance_id);

        if ($operation->type == 'REJECT_REASON')
        {
            $result = $this->soap1c->send_reject_reason($operation);
            if (!((isset($result->return) && $result->return == 'OK') || $result == 'OK'))
            {
                $order = $this->orders->get_order($operation->order_id);
                $this->soap1c->send_order($order);
                $result = $this->soap1c->send_reject_reason($operation);
            }
        }
        else
        {
            $result = $this->soap1c->send_payments(array($operation));
        }
        
        if ((isset($result->return) && $result->return == 'OK') || $result == 'OK')
        {
            $this->operations->update_operation($operation->id, array(
                'sent_date' => date('Y-m-d H:i:s'),
                'sent_status' => 2
            ));
            
            $this->response['success'] = 1;
            $this->output();
        }
        else
        {
            $this->show_error('Ошибка при отправке');
        }
        
    
    }

    private function show_error($message)
    {
        $this->response['error'] = 1;
        $this->response['message'] = $message;
        
        $this->output();            
    }

    public function logging_($local_method, $service, $request, $response, $filename)
    {
        $log_filename = $this->log_dir.$filename;

        if (date('d', filemtime($log_filename)) != date('d'))
        {
            $archive_filename = $this->log_dir.'archive/'.date('ymd', filemtime($log_filename)).'.'.$filename;
            rename($log_filename, $archive_filename);
            file_put_contents($log_filename, "\xEF\xBB\xBF");            
        }

        if (isset($request['TextJson']))        
            $request['TextJson'] = json_decode($request['TextJson']);
        if (isset($request['ArrayContracts']))        
            $request['ArrayContracts'] = json_decode($request['ArrayContracts']);
        if (isset($request['ArrayOplata']))        
            $request['ArrayOplata'] = json_decode($request['ArrayOplata']);

        $str = PHP_EOL.'==================================================================='.PHP_EOL;
        $str .= date('d.m.Y H:i:s').PHP_EOL;
        $str .= $service.PHP_EOL;
        $str .= var_export($request, true).PHP_EOL;
        $str .= var_export($response, true).PHP_EOL;
        $str .= 'END'.PHP_EOL;

        //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($str);echo '</pre><hr />';

        file_put_contents($this->log_dir.$filename, $str, FILE_APPEND);
    }
}

new GetTransactionData();