<?php

class Operations extends Core
{
	public function get_issuance_operation($contract_id) 
    {
		$query = $this->db->placehold("
            SELECT * 
            FROM __operations
            WHERE contract_id = ?
            AND type = 'ISSUANCE'
        ", (int)$contract_id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;        
    }
    
    public function get_onec_operation($number_onec)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __operations
            WHERE number_onec = ?
        ", (string)$number_onec);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_transaction_operation($transaction_id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __operations
            WHERE transaction_id = ?
        ", (string)$transaction_id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_operation($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __operations
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_operations($filter = array())
	{
		$id_filter = '';
        $contract_id_filter = '';
        $order_id_filter = '';
        $manager_id_filter = '';
        $type_filter = '';
        $sent_status_filter = '';
        $date_from_filter = '';
        $date_to_filter = '';
        $keyword_filter = '';
        $sort = "id ASC";
        $limit = 1000;
		$page = 1;
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
        
        if (!empty($filter['type']))
            $type_filter = $this->db->placehold("AND type IN (?@)", array_map('strval', (array)$filter['type']));
        
        if (isset($filter['sent_status']))
            $sent_status_filter = $this->db->placehold("AND sent_status = ?", (int)$filter['sent_status']);
        
        if (!empty($filter['contract_id']))
            $contract_id_filter = $this->db->placehold("AND contract_id IN (?@)", array_map('intval', (array)$filter['contract_id']));
		
        if (!empty($filter['order_id']))
            $order_id_filter = $this->db->placehold("AND order_id IN (?@)", array_map('intval', (array)$filter['order_id']));
		
        if (!empty($filter['manager_id']))
            $manager_id_filter = $this->db->placehold("AND manager_id IN (?@)", array_map('intval', (array)$filter['manager_id']));
        
        if (!empty($filter['date_from']))
            $date_from_filter = $this->db->placehold("AND DATE(created) >= ?", $filter['date_from']);
        
        if (!empty($filter['date_to']))
            $date_to_filter = $this->db->placehold("AND DATE(created) <= ?", $filter['date_to']);
        
		if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
        
        if (isset($filter['sort']))
        {
            switch($filter['sort']):
                
                case 'id_desc':
                    $sort = 'id DESC';
                break;
                
            endswitch;
        }
        
		if(isset($filter['limit']))
			$limit = max(1, intval($filter['limit']));

		if(isset($filter['page']))
			$page = max(1, intval($filter['page']));
            
        $sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);

        $query = $this->db->placehold("
            SELECT * 
            FROM __operations
            WHERE 1
                $id_filter
                $contract_id_filter 
                $order_id_filter
                $manager_id_filter
  	            $keyword_filter
                $type_filter
                $sent_status_filter
                $date_from_filter
                $date_to_filter
            ORDER BY $sort
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
    
	public function count_operations($filter = array())
	{
        $id_filter = '';
        $contract_id_filter = '';
        $order_id_filter = '';
        $manager_id_filter = '';
        $type_filter = '';
        $sent_status_filter = '';
        $date_from_filter = '';
        $date_to_filter = '';
        $keyword_filter = '';
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
		
        if (!empty($filter['contract_id']))
            $contract_id_filter = $this->db->placehold("AND contract_id IN (?@)", array_map('intval', (array)$filter['contract_id']));
		
        if (!empty($filter['order_id']))
            $order_id_filter = $this->db->placehold("AND order_id IN (?@)", array_map('intval', (array)$filter['order_id']));
		
        if (!empty($filter['manager_id']))
            $manager_id_filter = $this->db->placehold("AND manager_id IN (?@)", array_map('intval', (array)$filter['manager_id']));
        
        if (!empty($filter['type']))
            $type_filter = $this->db->placehold("AND type IN (?@)", array_map('strval', (array)$filter['type']));
        
        if (isset($filter['sent_status']))
            $sent_status_filter = $this->db->placehold("AND sent_status = ?", (int)$filter['sent_status']);
        
        if (!empty($filter['date_from']))
            $date_from_filter = $this->db->placehold("AND DATE(created) >= ?", $filter['date_from']);
        
        if (!empty($filter['date_to']))
            $date_to_filter = $this->db->placehold("AND DATE(created) <= ?", $filter['date_to']);
        
        if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
                
		$query = $this->db->placehold("
            SELECT COUNT(id) AS count
            FROM __operations
            WHERE 1
                $id_filter
                $contract_id_filter 
                $order_id_filter
                $manager_id_filter
                $type_filter
                $sent_status_filter
                $date_from_filter
                $date_to_filter
                $keyword_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }
    
    public function add_operation($operation)
    {
		$query = $this->db->placehold("
            INSERT INTO __operations SET ?%
        ", (array)$operation);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_operation($id, $operation)
    {
		$query = $this->db->placehold("
            UPDATE __operations SET ?% WHERE id = ?
        ", (array)$operation, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_operation($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __operations WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }

    public function get_sum_count_prolongation ($filter = array())
    {
        $date_from_filter = '';
        $date_to_filter = '';
        $operation_type_filter = '';

        if (!empty($filter['date_from']))
            $date_from_filter = $this->db->placehold("AND DATE(op.created) >= ?", $filter['date_from']);

        if (!empty($filter['date_to']))
            $date_to_filter = $this->db->placehold("AND DATE(op.created) <= ?", $filter['date_to']);

        if (!empty($filter['type_operation']))
            $operation_type_filter = $this->db->placehold("AND op.type = ?", $filter['type_operation']);

        $query = $this->db->placehold("
        select op.id, tr.sector, op.amount
        from __operations as op
        join __transactions as tr on tr.id = op.transaction_id 
        where tr.prolongation = 1
        $date_from_filter
        $date_to_filter
        $operation_type_filter
        ");

        $this->db->query($query);

        $result = $this->db->results();

        return $result;
    }

    public function get_final_sum_by_organizations($filter = array())
    {
        $date_from_filter = '';
        $date_to_filter = '';

        if (!empty($filter['date_from']))
            $date_from_filter = $this->db->placehold("AND DATE(op.created) >= ?", $filter['date_from']);

        if (!empty($filter['date_to']))
            $date_to_filter = $this->db->placehold("AND DATE(op.created) <= ?", $filter['date_to']);


        $query = $this->db->placehold("
        select op.amount, tr.sector
        from __operations as op
        join __transactions as tr on tr.id = op.transaction_id
        where 1
        $date_from_filter
        $date_to_filter
        ");

        $this->db->query($query);

        $result = $this->db->results();

        return $result;
    }

    public function operations_contracts_insurance($filter = array())
    {
        $date_from_filter = '';
        $date_to_filter = '';

        if (!empty($filter['date_from']))
            $date_from_filter = $this->db->placehold("AND DATE(op.created) >= ?", $filter['date_from']);

        if (!empty($filter['date_to']))
            $date_to_filter = $this->db->placehold("AND DATE(op.created) <= ?", $filter['date_to']);

        $query = $this->db->placehold("
        select
        op.created,
        op.contract_id,
        op.type,
        op.id,
        cr.uid,
        us.id as user_id,
        us.lastname,
        us.firstname,
        us.patronymic,
        us.birth,
        us.phone_mobile,
        us.gender,
        us.passport_serial,
        us.Regindex,
        us.Regcity,
        us.Reglocality,
        us.Regstreet_shorttype,
        us.Regstreet,
        us.Reghousing,
        us.Regroom,
        ins.number,
        ins.start_date,
        ins.end_date,
        op.amount as amount_insurance,
        cr.amount as amount_contract
        from s_operations as op
        join s_contracts as cr on cr.id = op.contract_id
        join s_users as us on op.user_id = us.id
        left join s_insurances as ins on ins.operation_id = op.id
        where 1
        and op.type in ('INSURANCE', 'BUD_V_KURSE', 'REJECT_REASON', 'INSURANCE_CLOSED')
        $date_from_filter
        $date_to_filter
        ");

        $this->db->query($query);

        $result = $this->db->results();

        return $result;
    }
}