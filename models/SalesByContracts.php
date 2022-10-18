<?php

class SalesByContracts extends Core
{
    public function remind_by_contract_id($contract_id) {
        //if (in_array($contract->status, [3, 5, 7, 9])) {
        //    
        //}

        $contract = $this->contracts->get_contract($contract_id);

        

        $order = $this->orders->get_order($contract->order_id);

        
        $client_time = $this->helpers->get_regional_time($order->Regregion);

        $client_time_warning = $this->users->get_time_warning($client_time);

        if (empty($client_time_warning))
        {
            $firstname = $order->firstname;
            $amount = $order->amount;
            
            $template = $this->sms->get_template(6);
    
            $message =  preg_replace('/{\\$firstname}/', $firstname, $template->template, -1, $count);//из шаблонов
            $message = preg_replace('/{\\$amount}/', $amount, $message, -1, $count);//из шаблонов
    
            //$result = $this->sms->send($order->phone_mobile, $message);
            //var_dump($result);

        //var_dump($firstname);
        //var_dump($order->phone_mobile);
            $this->save_sms_sale([
                'phone' => $order->phone_mobile,
                'message' => $message,
                'number_of' => 0,
                'firstname' => $order->firstname,
                'Regindex' => $order->Regindex,
                'Regregion' => $order->Regregion,
                'amount' => $order->amount,
                'contract_id' => $contract_id,
                'contract_status' => $contract->collection_status,
                'client_time' => $client_time,
                'result' => ''
            ]);
        }
        else
        {
            // неподходящее время
        }
    }

    public function save_sms_sale($item)
    {
        $item = (array)$item;

        //var_dump($item['phone']);
        if (empty($item['created_at'])) {
            $item['created_at'] = date('Y-m-d H:i:s');
            $item['updated_at'] = date('Y-m-d H:i:s');
        }

        $query = $this->db->placehold("
            INSERT INTO __sms_sales_by_contract SET ?%
        ", $item);
        //var_dump($query);
        $this->db->query($query);
        $id = $this->db->insert_id();

        return $id;
    }

    public function update_sms_sale($id, $item)
    {
        $item['updated_at'] = date('Y-m-d H:i:s');

        $query = $this->db->placehold("
            UPDATE __sms_sales_by_contract SET ?% WHERE id = ?
        ", (array)$item, (int)$id);
        $this->db->query($query);

        return $id;
    }

    public function get_queue_for_sending_sms($limit = 9){
        //SELECT * FROM `s_sms_sales_by_contract` WHERE number_of = 0 AND created_at < NOW() - INTERVAL 50 MINUTE LIMIT 9 
        $query = $this->db->placehold("
            SELECT * FROM `__sms_sales_by_contract` WHERE number_of = 0 AND created_at > NOW() - INTERVAL 50 MINUTE  LIMIT ?
        ", (int)$limit);
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }
}
