<?php

class Sudblock extends Core
{
    public function send_contract($sudblock_contract_id)
    {
        $sudblock_contract = $this->get_contract($sudblock_contract_id);
    	
        $manager = $this->managers->get_manager($sudblock_contract->manager_id);
        $tribunal = $this->tribunals->get_tribunal($sudblock_contract->tribunal_id);
        
        $request = array(
            'УИД_CRM' => $sudblock_contract->uid,
            'Дата' => date('Ymd000000', strtotime($sudblock_contract->sud_docs_added_date)),
            'НомерЗайма' => $sudblock_contract->first_number,
            'СуммаГосПошлины' => $sudblock_contract->sud_poshlina,
            'СуммаОД' => $sudblock_contract->sud_od,
            'СуммаПроцентов' => $sudblock_contract->sud_percents,
            'Менеджер' => $manager->name_1c,
            'УИДСуда' => $tribunal->uid,
            'ДниПросрочки' => $sudblock_contract->expired_days,
            'ОтправилВСуд' => $manager->name_1c,
        );
        
        $resp = $this->soap1c->send_sud_contract(json_encode($request));
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($request, $resp);echo '</pre><hr />';        
        
    }
    
    public function calc_contract($sudblock_contract_id)
    {
        $sudblock_contract = $this->get_contract($sudblock_contract_id);
        
        if ($contract = $this->contracts->get_contract($sudblock_contract->contract_id))
        {
            $od = $contract->loan_body_summ;
            
            $allready_paid = 0;
            if ($paids = $this->operations->get_operations(array('contract_id'=>$contract->id, 'type'=>'PAY')))
            {
                foreach ($paids as $paid)
                {
                    $allready_paid += $paid->amount;
                }
            }

            $interval = date_diff(date_create($contract->inssuance_date), date_create(date('Y-m-d')));
            $loan_real_period = $interval->days;
            
            $expired_interval = date_diff(date_create($contract->return_date), date_create(date('Y-m-d')));
            $expired_days = $expired_interval->days;
            
            
            $max_total = 2.5 * $contract->amount;
            $max_percents = $max_total - $allready_paid - $od;
            $real_percents = $contract->amount * $loan_real_period * $contract->base_percent / 100;
            $percents = min($max_percents, $real_percents);
            
/*
до 20 000 рублей - 4 процента цены иска, но не менее 400 рублей; 
от 20 001 рубля до 100 000 рублей - 800 рублей плюс 3 процента суммы, превышающей 20 000 рублей; 
от 100 001 рубля до 200 000 рублей - 3 200 рублей плюс 2 процента суммы, превышающей 100 000 рублей; 
от 200 001 рубля до 1 000 000 рублей - 5 200 рублей плюс 1 процент суммы, превышающей 200 000 рублей; 
свыше 1 000 000 рублей - 13 200 рублей плюс 0,5 процента суммы, превышающей 1 000 000 рублей, но не более 60 000 рублей;

при подаче заявления о вынесении судебного приказа - 50 процентов размера государственной пошлины
*/
            if (($od + $percents) < 20000)
                $poshlina = max(200, ($od + $percents) * 0.02);
            else
                $poshlina = 400 + (($od + $percents) - 20000) * 0.015;
            
            $update = array(
                'sud_od' => $od,
                'sud_percents' => $percents,
                'sud_poshlina' => $poshlina,
                'allready_paid' => $allready_paid,
                'expired_days' => $expired_days,
            );
            $this->update_contract($sudblock_contract->id, $update);
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($update);echo '</pre><hr />';            
        }
        
    	
    }
    
    
	public function create_contract($old_contract, $manager_id = 0)
    {
        $sud_manager_id = 122;
        $sud_status = 12;
        
        $this->contracts->update_contract($old_contract->id, array(
            'sud' => $sud,
            'collection_manager_id' => $sud_manager_id,
            'collection_status' => $sud_status,
        ));

        $user = $this->users->get_user($old_contract->user_id);
        $sudblock_contract = array(
            'number' => $old_contract->number,
            'first_number' => $old_contract->number,
            'loan_date' => $old_contract->inssuance_date,
            'user_id' => $old_contract->user_id,
            'contract_id' => $old_contract->id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'patronymic' => $user->patronymic,
            'created' => date('Y-m-d H:i:s'),
            'status' => 1,
            'loan_summ' => $old_contract->loan_body_summ,
            'total_summ' => $old_contract->loan_body_summ + $old_contract->loan_percents_summ + $old_contract->loan_charge_summ + $old_contract->loan_peni_summ,
            'region' => trim($user->Regregion.' '.$user->Regregion_shorttype),
            'provider' => 'Наличное плюс',
        );
        if ($tribunal = $this->tribunals->find_tribunal($user->Regregion))
        {
            $sudblock_contract['tribunal'] = $tribunal->sud;
            $sudblock_contract['tribunal_id'] = $tribunal->id;
        }
        $sudblock_contract['uid'] = exec($this->config->root_dir.'generic/uidgen');
        
        $sudblock_contract_id = $this->add_contract($sudblock_contract);
        
        $this->collections->add_moving(array(
            'initiator_id' => $manager_id,
            'manager_id' => $sud_manager_id,
            'contract_id' => $old_contract->id,
            'from_date' => date('Y-m-d H:i:s'),
            'summ_body' => $old_contract->loan_body_summ,
            'summ_percents' => $old_contract->loan_percents_summ + $old_contract->loan_peni_summ + $old_contract->loan_charge_summ,
            'collection_status' => $sud_status,
        ));

        return $sudblock_contract_id;
    }
    
    public function get_contract($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __sudblock_contracts
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        if ($result = $this->db->result())
            if (!empty($result->cession_info))
            	$result->cession_info = unserialize($result->cession_info);
    
        return $result;
    }

    public function get_contract_by_user_id($user_id)
    {
        $query = $this->db->placehold("
            SELECT * 
            FROM __sudblock_contracts
            WHERE user_id = ?
        ", (int)$user_id);
        $this->db->query($query);
        if ($result = $this->db->result())
            if (!empty($result->cession_info))
                $result->cession_info = unserialize($result->cession_info);

        return $result;
    }
    
	public function get_contracts($filter = array())
	{
		$id_filter = '';
        $manager_id_filter = '';
        $status_filter = '';
        $keyword_filter = '';
        $search_filter = '';
        $limit = 1000;
		$page = 1;
        $sort = 'id ASC';
        $sort_workout = '';
        $user_filter = '';
        
        if (!empty($filter['sort_workout']))
            $sort_workout = "workout ASC, ";

        if (!empty($filter['user_id']))
            $user_filter = $this->db->placehold("AND user_id = ?", $filter['user_id']);
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
        
        if (!empty($filter['manager_id']))
            $manager_id_filter = $this->db->placehold("AND manager_id IN (?@)", array_map('intval', (array)$filter['manager_id']));
		
        if (!empty($filter['status']))
            $status_filter = $this->db->placehold("AND status IN (?@)", array_map('intval', (array)$filter['status']));
		
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

        if (!empty($filter['sort']))
        {
            switch ($filter['sort']):
                
                case 'manager_id_desc':
                    $sort = 'manager_id DESC';
                break;
                
                case 'manager_id_asc':
                    $sort = 'manager_id ASC';
                break;
                
                case 'status_asc':
                    $sort = 'status ASC';
                break;
                
                case 'status_desc':
                    $sort = 'status DESC';                
                break;
                
                case 'number_asc':
                    $sort = 'number ASC';
                break;
                
                case 'number_desc':
                    $sort = 'number DESC';                
                break;
                
                case 'first_number_asc':
                    $sort = 'first_number ASC';
                break;
                
                case 'first_number_desc':
                    $sort = 'first_number DESC';                
                break;
                
                case 'fio_asc':
                    $sort = 'lastname ASC';
                break;
                
                case 'fio_desc':
                    $sort = 'lastname DESC';                
                break;
                
                case 'provider_asc':
                    $sort = 'provider ASC';
                break;
                
                case 'provider_desc':
                    $sort = 'provider DESC';                
                break;
                
                case 'created_asc':
                    $sort = 'created ASC';
                break;
                
                case 'created_desc':
                    $sort = 'created DESC';                
                break;
                
                case 'last_date_asc':
                    $sort = ' ASC';
                break;
                
                case 'last_date_desc':
                    $sort = ' DESC';                
                break;
                
                case 'body_asc':
                    $sort = 'loan_summ ASC';
                break;
                
                case 'body_desc':
                    $sort = 'loan_summ DESC';                
                break;
                
                case 'total_asc':
                    $sort = 'total_summ ASC';
                break;
                
                case 'total_desc':
                    $sort = 'total_summ DESC';                
                break;

                case 'region_asc':
                    $sort = 'region_summ ASC';
                break;
                
                case 'region_desc':
                    $sort = 'region_summ DESC';                
                break;
                
            endswitch;
        }
        
        if (!empty($filter['search']))
        {
            if (!empty($filter['search']['created']))
            {
                
            }
            
            if (!empty($filter['search']['fio']))
            {
                $fio_filter = array();
                $expls = array_map('trim', explode(' ', $filter['search']['fio']));
                $search_filter .= $this->db->placehold(' AND (');
                foreach ($expls as $expl)
                {
                    $expl = $this->db->escape($expl);
                    $fio_filter[] = $this->db->placehold("(lastname LIKE '%".$expl."%' OR firstname LIKE '%".$expl."%' OR patronymic LIKE '%".$expl."%')");
                }
                $search_filter .= implode(' AND ', $fio_filter);
                $search_filter .= $this->db->placehold(')');
            }

            if (!empty($filter['search']['first_number']))
                $search_filter .= $this->db->placehold(" AND (first_number LIKE '%".$this->db->escape($filter['search']['first_number'])."%')");
            if (!empty($filter['search']['provider']))
                $search_filter .= $this->db->placehold(" AND (provider LIKE '%".$this->db->escape($filter['search']['provider'])."%')");
            if (!empty($filter['search']['region']))
                $search_filter .= $this->db->placehold(" AND (region LIKE '%".$this->db->escape($filter['search']['region'])."%')");
            if (!empty($filter['search']['body_summ']))
                $search_filter .= $this->db->placehold(" AND (body_summ LIKE '%".$this->db->escape($filter['search']['body_summ'])."%')");
            if (!empty($filter['search']['total_summ']))
                $search_filter .= $this->db->placehold(" AND (total_summ LIKE '%".$this->db->escape($filter['search']['total_summ'])."%')");
            
            if (!empty($filter['search']['tag_id']))
            {
                $users_join = 'RIGHT JOIN __users AS u ON c.user_id = u.id';                    
                $search_filter .= $this->db->placehold(" AND u.contact_status = ?", $filter['search']['tag_id']);
            }
            
            if (!empty($filter['search']['manager_id']))
            {
                if ($filter['search']['manager_id'] == 'none')
                    $search_filter .= $this->db->placehold(" AND (c.collection_manager_id = 0 OR c.collection_manager_id IS NULL)");                
                else
                    $search_filter .= $this->db->placehold(" AND c.collection_manager_id = ?", (int)$filter['search']['manager_id']);
            }
            
            if (!empty($filter['search']['delay_from']))
            {
                $delay_from_date = date('Y-m-d', time() - $filter['search']['delay_from']*86400);
                $search_filter .= $this->db->placehold(" AND DATE(c.return_date) <= ?", $delay_from_date);
            }
            if (!empty($filter['search']['delay_to']))
            {
                $delay_to_date = date('Y-m-d', time() - $filter['search']['delay_to']*86400);
                $search_filter .= $this->db->placehold(" AND DATE(c.return_date) >= ?", $delay_to_date);
            }
        }
        

        $query = $this->db->placehold("
            SELECT * 
            FROM __sudblock_contracts
            WHERE 1
                $id_filter
				$manager_id_filter
                $status_filter
                $keyword_filter
                $search_filter
                $user_filter
            ORDER BY $sort_workout $sort 
            $sql_limit
        ");
        $this->db->query($query);
        if ($results = $this->db->results())
        {
            foreach ($results as $r)
                if (!empty($r->cession_info))
                    @$r->cession_info = unserialize($r->cession_info);
        }
        
        return $results;
	}
    
	public function count_contracts($filter = array())
	{
        $id_filter = '';
        $manager_id_filter = '';
        $status_filter = '';
        $keyword_filter = '';
        $search_filter = '';
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
		
        if (!empty($filter['manager_id']))
            $manager_id_filter = $this->db->placehold("AND manager_id IN (?@)", array_map('intval', (array)$filter['manager_id']));
		
        if (!empty($filter['status']))
            $status_filter = $this->db->placehold("AND status IN (?@)", array_map('intval', (array)$filter['status']));
		
        if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
                
		$query = $this->db->placehold("
            SELECT COUNT(id) AS count
            FROM __sudblock_contracts
            WHERE 1
                $id_filter
                $manager_id_filter
                $status_filter
                $keyword_filter
                $search_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }
    
    public function add_contract($sudblock_contract)
    {
		$sudblock_contract = (array)$sudblock_contract;
        
        if (!empty($sudblock_contract['cession_info']))
            $sudblock_contract['cession_info'] = serialize($sudblock_contract['cession_info']);
        
        $query = $this->db->placehold("
            INSERT INTO __sudblock_contracts SET ?%
        ", $sudblock_contract);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_contract($id, $sudblock_contract)
    {
        $sudblock_contract = (array)$sudblock_contract;
        
        if (!empty($sudblock_contract['cession_info']))
            $sudblock_contract['cession_info'] = serialize($sudblock_contract['cession_info']);
        
		$query = $this->db->placehold("
            UPDATE __sudblock_contracts SET ?% WHERE id = ?
        ", $sudblock_contract, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_contract($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __sudblock_contracts WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }



	public function get_status($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __sudblock_statuses
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_statuses($filter = array())
	{
		$id_filter = '';
        $keyword_filter = '';
        $limit = 1000;
		$page = 1;
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
        
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
            FROM __sudblock_statuses
            WHERE 1
                $id_filter
				$keyword_filter
            ORDER BY id ASC 
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
        
    public function add_status($status)
    {
		$query = $this->db->placehold("
            INSERT INTO __sudblock_statuses SET ?%
        ", (array)$status);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_status($id, $status)
    {
		$query = $this->db->placehold("
            UPDATE __sudblock_statuses SET ?% WHERE id = ?
        ", (array)$status, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_status($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __sudblock_statuses WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }



	public function get_document($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __sudblock_documents
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_documents($filter = array())
	{
		$id_filter = '';
		$base_filter = '';
		$block_filter = '';
        $sudblock_contract_id_filter = '';
        $keyword_filter = '';
        $limit = 1000;
		$page = 1;
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
        
		if (isset($filter['base']))
            $base_filter = $this->db->placehold("AND base = ?", (int)$filter['base']);
        
		if (!empty($filter['block']))
            $block_filter = $this->db->placehold("AND block = ?", (string)$filter['block']);
        
        if (!empty($filter['sudblock_contract_id']))
            $sudblock_contract_id_filter = $this->db->placehold("AND sudblock_contract_id = ?", (int)$filter['sudblock_contract_id']);
        
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
            FROM __sudblock_documents
            WHERE 1
                $id_filter
				$base_filter
                $block_filter
                $sudblock_contract_id_filter 
                $keyword_filter
            ORDER BY position ASC 
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
        
    public function add_document($document)
    {
		$query = $this->db->placehold("
            INSERT INTO __sudblock_documents SET ?%
        ", (array)$document);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_document($id, $document)
    {
		$query = $this->db->placehold("
            UPDATE __sudblock_documents SET ?% WHERE id = ?
        ", (array)$document, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_document($id)
    {
		$doc = $this->get_document($id);
        
        if (!empty($doc->filename))
        {
            if (empty($doc->sudblock_contract_id))
                unlink($this->config->root_dir.'files/sudblock/'.$doc->filename);
            else
                unlink($this->config->root_dir.'files/sudblock/'.$doc->sudblock_contract_id.'/'.$doc->filename);
        }
        
        $query = $this->db->placehold("
            DELETE FROM __sudblock_documents WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }
}