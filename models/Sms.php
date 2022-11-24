<?php

class Sms extends Core
{
    private $login;
    private $password;
    private $originator;
    private $connect_id;
    private $yuk_login;
    private $yuk_password;
    private $yuk_originator;
    private $yuk_connect_id;
    private $premier_login;
    private $premier_password;
    private $premier_originator;
    private $premier_connect_id;
    private $toros_login;
    private $toros_password;
    private $toros_originator;
    private $toros_connect_id;
    
	private $template_types = array(
        'collection' => 'Коллекшен',
        'order' => 'Выдача',
        'smssales' => 'Продажа по смс'
    );
    
    public function __construct()
    {
    	parent::__construct();
        
        $this->login = $this->settings->apikeys['sms']['login'];
        $this->password = $this->settings->apikeys['sms']['password'];
        $this->originator = $this->settings->apikeys['sms']['originator'];
        $this->connect_id = $this->settings->apikeys['sms']['connect_id'];

        $this->yuk_login = 'jurcompany1_sms';
        $this->yuk_password = 'XeusN4VE';
        $this->yuk_originator = 'jurcompany1';
        $this->yuk_connect_id = '2681';

        $this->premier_login = 'premier_sms';
        $this->premier_password = 'zkJuoeKg';
        $this->premier_originator = 'premier001';
        $this->premier_connect_id = '2740';

        $this->toros_login = 'Toros';
        $this->toros_password = '49ysPbK3';
        $this->toros_originator = 'toros';
        $this->toros_connect_id = '2866';
    }
    
    public function get_originator($yuk)
    {
        if ($yuk == 2)
            return  $this->premier_originator;
        elseif (empty($yuk))
             return $this->originator;
        else
        	return $this->yuk_originator;
    }
    
    
    public function clear_phone($phone)
    {
        $remove_symbols = array(
            '(', 
            ')', 
            '-', 
            ' ', 
            '+'
        );
        return str_replace($remove_symbols, '', $phone);
    }

    public function send($phone, $message)
    {
        $phone = $this->clear_phone($phone);

        $api_code = 'CEC47EEB-DA21-5CDB-9431-7E53B513FAA5';

        $smsru = new SMSRU($api_code);

        $data = new stdClass();
        $data->to = $phone;
        $data->text = $message;

        $sms = $smsru->send_one($data);

        if ($sms->status == "OK") { // Запрос выполнен успешно
            $resp = "Сообщение отправлено успешно";
        } else {
            $resp = "Текст ошибки: $sms->status_text".' Телефон: '.$phone.' Сообщение: '.$message;
        }

        return $resp;
    }
    
    public function send_smska($phone, $message_id, $amount)
    {
        $phone = $this->clear_phone($phone);
        $phone = substr($phone, -10);
        $url = 'http://code.smska.biz/api/?pid='.$message_id.'&msisdn='.$phone.'&first_name='.$amount;

        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('auth:62a9d1c44b7cf0f26b117fd7'));

        $resp = curl_exec($ch);
        
        $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        
        curl_close($ch);

        $log = date('Y-m-d H:i:s').';'.$phone.';'.$http_code.PHP_EOL;
        file_put_contents($this->config->root_dir.'logs/'.$message_id.'.csv', $log, FILE_APPEND);
        
        return $http_code;
    }
    
    
    public function get_code($phone)
    {
    	$query = $this->db->placehold("
            SELECT code
            FROM __sms_messages
            WHERE phone = ?
            ORDER BY id DESC
            LIMIT 1
        ", $this->clear_phone($phone));
        $this->db->query($query);
        
        $code = $this->db->result('code');
        
        return $code;
    }
    
	public function get_message($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __sms_messages
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_messages($filter = array())
	{
		$id_filter = '';
        $keyword_filter = '';
        $phone_filter = '';
        $limit = 1000;
		$page = 1;
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
        
        if (!empty($filter['phone']))
            $phone_filter = $this->db->placehold("AND phone = ?", $this->clear_phone($filter['phone']));
		
		if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
        
		if(isset($filter['limit']))
			$limit = max(1, intval($filter['limit']));

		if(isset($filter['page']))
			$page = max(1, intval($filter['page']));
            
        $sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);

        $query = $this->db->placehold("
            SELECT * 
            FROM __sms_messages
            WHERE 1
                $id_filter
                $phone_filter
				$keyword_filter
            ORDER BY id DESC 
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
    
	public function count_messages($filter = array())
	{
        $id_filter = '';
        $phone_filter = '';
        $keyword_filter = '';
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
		
        if (!empty($filter['phone']))
            $phone_filter = $this->db->placehold("AND phone = ?", $this->clear_phone($filter['phone']));
		
        if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
                
		$query = $this->db->placehold("
            SELECT COUNT(id) AS count
            FROM __sms_messages
            WHERE 1
                $id_filter
                $phone_filter
                $keyword_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }
    
    public function add_message($message)
    {
		$message = (array)$message;
        
        if (isset($message['phone']))
            $message['phone'] = $this->clear_phone($message['phone']);
        
        $query = $this->db->placehold("
            INSERT INTO __sms_messages SET ?%
        ", $message);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_message($id, $message)
    {
		$message = (array)$message;
        
        if (isset($message['phone']))
            $message['phone'] = $this->clear_phone($message['phone']);
        
		$query = $this->db->placehold("
            UPDATE __sms_messages SET ?% WHERE id = ?
        ", $message, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_message($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __sms_messages WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }
    


    public function get_template_types()
    {
        return $this->template_types;
    }
    
    public function get_template($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __sms_templates
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_templates($filter = array())
	{
		$id_filter = '';
		$type_filter = '';
        $keyword_filter = '';
        $limit = 1000;
		$page = 1;
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
        
        if (!empty($filter['type']))
            $type_filter = $this->db->placehold("AND type = ?", (string)$filter['type']);
        
		if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
        
		if(isset($filter['limit']))
			$limit = max(1, intval($filter['limit']));

		if(isset($filter['page']))
			$page = max(1, intval($filter['page']));
            
        $sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);

        $query = $this->db->placehold("
            SELECT * 
            FROM __sms_templates
            WHERE 1
                $id_filter
                $type_filter
				$keyword_filter
            ORDER BY id DESC 
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
    
	public function count_templates($filter = array())
	{
        $id_filter = '';
        $type_filter = '';
        $keyword_filter = '';
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
		
        if (!empty($filter['type']))
            $type_filter = $this->db->placehold("AND type = ?", (string)$filter['type']);
        
        if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
                
		$query = $this->db->placehold("
            SELECT COUNT(id) AS count
            FROM __sms_templates
            WHERE 1
                $id_filter
                $type_filter
                $keyword_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }
    
    public function add_template($sms_template)
    {
		$query = $this->db->placehold("
            INSERT INTO __sms_templates SET ?%
        ", (array)$sms_template);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_template($id, $sms_template)
    {
		$query = $this->db->placehold("
            UPDATE __sms_templates SET ?% WHERE id = ?
        ", (array)$sms_template, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_template($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __sms_templates WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }

    public function render($template, $data) {
        return strtr($template, [
            '{сумма}' => isset($data['сумма']) ? $data['сумма'] : '',
            '{номер}' => isset($data['номер']) ? $data['номер'] : '',
            '{имя}' => isset($data['имя']) ? $data['имя'] : '',
            '{accept_code}' => isset($data['accept_code']) ? $data['accept_code'] : '',
    
            '{$firstname}' => isset($data['firstname']) ? $data['firstname'] : '',
        
            '{$amount}' => isset($data['amount']) ? $data['amount'] : '',
            '{$credit}' => isset($data['credit']) ? $data['credit'] : '',
    
            '{$payment}' => isset($data['payment']) ? $data['payment'] : '',
            '{$percent}' => isset($data['percent']) ? $data['percent'] : '',
            '{$payday}' => isset($data['payday']) ? $data['payday'] : '',
            '{$contract}' => isset($data['contract']) ? $data['contract'] : '',
            '{$loanid}' => isset($data['loanid']) ? $data['loanid'] : '',
        
            '{$crd1000}' => isset($data['crd+']) ? $data['crd+'] + 1000 : '',
            '{$crd2000}' => isset($data['crd+']) ? $data['crd+'] + 2000 : '',
            '{$crd3000}' => isset($data['crd+']) ? $data['crd+'] + 3000 : '',
            '{$crd4000}' => isset($data['crd+']) ? $data['crd+'] + 4000 : '',
            '{$crd5000}' => isset($data['crd+']) ? $data['crd+'] + 5000 : '',
            '{$crd6000}' => isset($data['crd+']) ? $data['crd+'] + 6000 : '',
            '{$crd7000}' => isset($data['crd+']) ? $data['crd+'] + 7000 : '',
            '{$crd8000}' => isset($data['crd+']) ? $data['crd+'] + 8000 : '',
            '{$crd9000}' => isset($data['crd+']) ? $data['crd+'] + 9000 : '',
            '{$crd10000}' => isset($data['crd+']) ? $data['crd+'] + 10000 : '',
        ]);
    }
    
    public function render_by_models($template, $order, $contract = null, $crd = null) {
        $data = [
            'сумма' => $order->amount,
            'amount' => $order->amount,
            'имя' => $order->firstname,
            'loanid' => $order->order_id,
            'firstname' => $order->firstname,
    
            'credit' => $order->amount,
            'crd+' =>  empty($crd) ? $order->amount : $crd,
        ];

        if (!empty($contract)) {
            $contract_data = [
                'accept_code' => $contract->accept_code,
            

                'payment' => $contract->loan_body_summ + $contract->loan_percents_summ + $contract->loan_charge_summ + $contract->loan_peni_summ,
                'percent' => $contract->loan_percents_summ,
                'payday' =>  date("d-m-Y", strtotime($contract->return_date)),
                'номер' => $contract->number,
                'contract' => $contract->number,
            ];
            
            $data = $data + $contract_data;
        }
    
        return $this->render($template, $data);
    }
}