<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class OfflineExchangeCron extends Core
{
    public function __construct()
    {
    	parent::__construct();
        

//        for ($i = 0; $i < 5; $i++)
            $this->send_contracts();

//        for ($i = 0; $i < 5; $i++)
//            $this->send_payments();
            
    }

    
    /**
     * OfflineExchangeCron::send_contracts()
     * Отправляем выданные займы
     * @return void
     */
    private function send_contracts()
    {
        $contract_filter_params = array(
            'type' => 'offline',
            'sent_status' => 0, 
            'status' => array(2, 3, 4), 
            'limit' => 1, 
        );
        if ($contracts = $this->contracts->get_contracts($contract_filter_params))
        {
            foreach ($contracts as $contract)
            {
                $contract->user = $this->users->get_user((int)$contract->user_id);
                $contract->order = $this->orders->get_order((int)$contract->order_id);
                $contract->pay_operation = $this->operations->get_issuance_operation($contract->id);
                $contract->organization = $this->offline->get_organization($contract->order->organization_id);
                $contract->point = $this->offline->get_point($contract->order->offline_point_id);
            }
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contracts);echo '</pre><hr />';

            
            $result = $this->soap1c->send_offline_contracts($contracts);
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($result, $result->return, $result->return == 'ОК');echo '</pre><hr />';
            if (isset($result->return) && $result->return == 'ОК')
            {
                foreach ($contracts as $contract)
                {
                    $this->contracts->update_contract($contract->id, array(
                        'sent_date' => date('Y-m-d H:i:s'),
                        'sent_status' => 2
                    ));
                }
            }

        }
    }
    
    /**
     * ExchangeCron::send_comments()
     * Отправка комментариев в 1с (отправляем комментарии только по тем заявкам где есть выданные кредиты)
     * 
     * @return void
     */
    private function send_comments()
    {
        if ($comments = $this->comments->get_comments(array('not_sent'=>1)))
        {
            $send_comments = array();
            foreach ($comments as $comment)
            {
                if (!empty($comment->contactperson_id))
                {
                    $comment->contactperson = $this->contactpersons->get_contactperson((int)$comment->contactperson_id);
                }
                
                $comment_contract = $this->contracts->get_order_contract($comment->order_id);
                if (empty($comment_contract))
                {
                    if ($comment->status == 1)
                        $this->comments->update_comment($comment->id, array('status' => 3));
                    else
                        $this->comments->update_comment($comment->id, array('status' => 1));
                }
                else
                {
                    // 2 => 'Выдан', 3 => 'Закрыт', 4 => 'Просрочен',
                    if (in_array($comment_contract->status, array(2, 3, 4))) 
                    {
                        $comment->contract = $comment_contract;
                        $send_comments[] = $comment;                        
                    }
                    // 5 => 'Истек срок подписания', 6 => 'Не удалось выдать займ',
                    elseif (in_array($comment_contract->status, array(5, 6)))
                    {
                        $this->comments->update_comment($comment->id, array('status' => 3));
                    }
                }
                
            }
            
            if (!empty($send_comments))
            {
                $result = $this->soap1c->send_comments($send_comments);
                if (isset($result->return) && $result->return == 'OK')
                {
                    foreach ($send_comments as $comment)
                    {
                        $this->comments->update_comment($comment->id, array(
                            'sent' => date('Y-m-d H:i:s'),
                            'status' => 2
                        ));
                    }
                }
            }
        }
    }

    /**
     * ExchangeCron::send_payments()
     * Отправляем оплаты
     * @return void
     */
    private function send_payments()
    {
        $params = [
            'limit' => 5, 
            'type'=>array('PAY'), 
            'sent_status' => 0, 
            'sort'=>'id_desc'
        ];
        if ($operations = $this->operations->get_operations($params))
        {
            $filtered_operations = [];
            foreach ($operations as $operation)
            {
                $operation->contract = $this->contracts->get_contract($operation->contract_id);

                if ($operation->contract->sent_status != 2) {
                    continue;
                }

                $operation->transaction = $this->transactions->get_transaction($operation->transaction_id);
                if ($operation->transaction->insurance_id)
                    $operation->transaction->insurance = $this->insurances->get_insurance($operation->transaction->insurance_id);

                $filtered_operations[] = $operation;
            }
            
            $result = $this->soap1c->send_payments($filtered_operations);
            if (isset($result->return) && $result->return == 'OK')
            {
                foreach ($filtered_operations as $operation)
                {
                    $this->operations->update_operation($operation->id, array(
                        'sent_date' => date('Y-m-d H:i:s'),
                        'sent_status' => 2
                    ));
                }
            }
            else
            {
                foreach ($filtered_operations as $operation)
                {
                    $this->operations->update_operation($operation->id, array(
//                        'sent_date' => date('Y-m-d H:i:s'),
//                        'sent_status' => 6
                    ));
                }
                
            }

echo __FILE__.' '.__LINE__.'<br /><pre>';echo date('H:i:s').PHP_EOL;var_dump($result);echo '</pre><hr />';            
        }

}
new OfflineExchangeCron();