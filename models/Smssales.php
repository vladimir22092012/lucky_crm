<?php

class Smssales extends Core
{
    public function get_queue_for_sending_sms($limit = 9){
        $query = $this->db->placehold("
            SELECT * FROM __sms_sales WHERE number_of < 2 AND created_at > '2022-01-18 00:00:00' AND updated_at < NOW() - INTERVAL 30 MINUTE LIMIT ?
        ", (int)$limit);
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function send_smssales($order, $reason_id){
        /*
        33 Клиент НАЛИЧНОЕ
        15 Антиразгон Авто
            Локдаун, 
        10 Разгон
            Открытый займ 

        $order->reason_id
        */

        //if (!in_array($reason_id, [33, 15, 10])) {
        //    $this->logging_(__METHOD__, 'not in reason', (array)[$order->order_id, $reason_id], [], 'logs/sms_not_in_reason.txt');
        //    return false;
        //}

        $sms = $this->get_smssales($order->order_id);

        if (!empty($sms)) {
            return false;
        }

        $firstname = $order->firstname;
        $amount = $order->amount;
        
        /*
        // отправляем через smska.biz
        // 699105 - Заявка на {FIRST_NAME}р рассмотрена, проверьте статус finfive.ru/go/partners
        $result = $this->sms->send_smska($order->phone_mobile, 699105, $amount);
        $message = 'Заявка на '.$amount.'р рассмотрена, проверьте статус finfive.ru/go/partners';
        */
        $template = $this->sms->get_template(7);

        $message =  preg_replace('/{\\$firstname}/', $firstname, $template->template, -1, $count);//из шаблонов
        $message = preg_replace('/{\\$amount}/', $amount, $message, -1, $count);//из шаблонов

        $order = $this->orders->get_order($order->order_id);
        //$contract = $this->contracts->get_contract($order->contract_id);

        $message = $this->Sms->render_by_models($message, $order);

        $result = $this->sms->send($order->phone_mobile, $message, 0, 'FINFIVE');
        $this->save_smssales([
            'phone' => $order->phone_mobile,
            'message' => $message,
            'number_of' => 1,
            'firstname' => $order->firstname,
            'amount' => $order->amount,
            'reason_id' => $reason_id,
            'order_id' => $order->order_id,
            'manager_id' => $order->manager_id
        ]);
    }

    public function save_smssales($item)
    {
        $item = (array)$item;

        if (empty($item['created_at'])) {
            $item['created_at'] = date('Y-m-d H:i:s');
            $item['updated_at'] = date('Y-m-d H:i:s');
        }

        $query = $this->db->placehold("
            INSERT INTO __sms_sales SET ?%
        ", $item);
        $this->db->query($query);
        $id = $this->db->insert_id();

        return $id;
    }

    public function get_smssales($order_id)
    {
        $query = $this->db->placehold("
            SELECT * FROM `s_sms_sales` WHERE order_id = ? LIMIT 1
        ", $order_id);
        $this->db->query($query);

        $results = $this->db->result();

        return $results;
    }

    public function update_smssales($id, $item)
    {
        $item['updated_at'] = date('Y-m-d H:i:s');

        $query = $this->db->placehold("
            UPDATE __sms_sales SET ?% WHERE id = ?
        ", (array)$item, (int)$id);
        $this->db->query($query);

        return $id;
    }

    private function logging_($local_method, $service, $request, $response, $filename)
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
