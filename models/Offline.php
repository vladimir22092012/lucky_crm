<?php

class Offline extends Core
{
	public function get_point($id)
	{
		$query = $this->db->placehold("
            SELECT *
            FROM __offline_points
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_point_by_code($code)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __offline_points
            WHERE code = ?
        ", (int)$code);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_points($filter = array())
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
            FROM __offline_points
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
    
	public function count_points($filter = array())
	{
        $id_filter = '';
        $keyword_filter = '';
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
		
        if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
                
		$query = $this->db->placehold("
            SELECT COUNT(id) AS count
            FROM __offline_points
            WHERE 1
                $id_filter
                $keyword_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }
    
    public function add_point($point)
    {
		$query = $this->db->placehold("
            INSERT INTO __offline_points SET ?%
        ", (array)$point);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_point($id, $point)
    {
		$query = $this->db->placehold("
            UPDATE __offline_points SET ?% WHERE id = ?
        ", (array)$point, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_point($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __offline_points WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }


	public function get_organization($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __organizations
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_organization_by_bode($code)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __organizations
            WHERE code = ?
        ", (int)$code);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_organizations($filter = array())
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
            FROM __organizations
            WHERE 1
                $id_filter
				$keyword_filter
            ORDER BY id DESC 
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
    
	public function count_organizations($filter = array())
	{
        $id_filter = '';
        $keyword_filter = '';
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
		
        if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
                
		$query = $this->db->placehold("
            SELECT COUNT(id) AS count
            FROM __organizations
            WHERE 1
                $id_filter
                $keyword_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }
    
    public function add_organization($organization)
    {
		$query = $this->db->placehold("
            INSERT INTO __organizations SET ?%
        ", (array)$organization);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_organization($id, $organization)
    {
		$query = $this->db->placehold("
            UPDATE __organizations SET ?% WHERE id = ?
        ", (array)$organization, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_organization($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __organizations WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }

	public function get_date_worktime($offline_point_id, $workdate)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __offline_worktimes
            WHERE offline_point_id = ?
            AND workdate = ?
        ", (int)$offline_point_id, $workdate);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_worktime($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __offline_worktimes
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_worktimes($filter = array())
	{
		$id_filter = '';
        $offline_point_id_filter = '';
        $manager_id_filter = '';
        $workdate_filter = '';
        $limit = 1000;
		$page = 1;
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
        
        if (!empty($filter['offline_point_id']))
            $offline_point_id_filter = $this->db->placehold("AND offline_point_id = ?", (int)$filter['offline_point_id']);
        
        if (!empty($filter['manager_id']))
            $manager_id_filter = $this->db->placehold("AND manager_id = ?", (int)$filter['manager_id']);
        
        if (!empty($filter['workdate']))
            $workdate_filter = $this->db->placehold("AND workdate IN (?@)", (array)$filter['workdate']);
        
		if(isset($filter['limit']))
			$limit = max(1, intval($filter['limit']));

		if(isset($filter['page']))
			$page = max(1, intval($filter['page']));
            
        $sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);

        $query = $this->db->placehold("
            SELECT * 
            FROM __offline_worktimes
            WHERE 1
                $id_filter
                $offline_point_id_filter
                $manager_id_filter
                $workdate_filter
            ORDER BY id DESC 
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
    
	public function count_worktimes($filter = array())
	{
        $id_filter = '';
        $offline_point_id_filter = '';
        $manager_id_filter = '';
        $workdate_filter = '';
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
                
        if (!empty($filter['offline_point_id']))
            $offline_point_id_filter = $this->db->placehold("AND offline_point_id = ?", (int)$filter['offline_point_id']);
        
        if (!empty($filter['manager_id']))
            $manager_id_filter = $this->db->placehold("AND manager_id = ?", (int)$filter['manager_id']);
        
        if (!empty($filter['workdate']))
            $workdate_filter = $this->db->placehold("AND workdate IN (?@)", (array)$filter['workdate']);
        
		$query = $this->db->placehold("
            SELECT COUNT(id) AS count
            FROM __offline_worktimes
            WHERE 1
                $id_filter
                $offline_point_id_filter
                $manager_id_filter
                $workdate_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }
    
    public function add_worktime($worktime)
    {
		$query = $this->db->placehold("
            INSERT INTO __offline_worktimes SET ?%
        ", (array)$worktime);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_worktime($id, $worktime)
    {
		$query = $this->db->placehold("
            UPDATE __offline_worktimes SET ?% WHERE id = ?
        ", (array)$worktime, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_worktime($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __offline_worktimes WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }

    public function get_saldo_date($date, $offline_point_id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __saldo_points
            WHERE offline_point_id = ?
            AND created = ?
        ", (int)$offline_point_id, $date);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }

	public function get_saldo_point($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __saldo_points
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_saldo_points($filter = array())
	{
		$id_filter = '';
		$offline_point_id_filter = '';
        $created_filter = '';
        $keyword_filter = '';
        $limit = 1000;
		$page = 1;
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
        
        if (!empty($filter['offline_point_id']))
            $offline_point_id_filter = $this->db->placehold("AND offline_point_id IN (?@)", array_map('intval', (array)$filter['offline_point_id']));
        
        if (!empty($filter['created']))
            $created_filter = $this->db->placehold("AND created IN (?@)", (array)$filter['created']);
        
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
            FROM __saldo_points
            WHERE 1
                $id_filter
                $offline_point_id_filter
				$created_filter
                $keyword_filter
            ORDER BY id DESC 
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
    
	public function count_saldo_points($filter = array())
	{
        $id_filter = '';
        $offline_point_id_filter = '';
        $created_filter = '';
        $keyword_filter = '';
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND id IN (?@)", array_map('intval', (array)$filter['id']));
		
        if (!empty($filter['offline_point_id']))
            $offline_point_id_filter = $this->db->placehold("AND offline_point_id IN (?@)", array_map('intval', (array)$filter['offline_point_id']));
        
        if (!empty($filter['created']))
            $created_filter = $this->db->placehold("AND created IN (?@)", (array)$filter['created']);
        
        if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
                
		$query = $this->db->placehold("
            SELECT COUNT(id) AS count
            FROM __saldo_points
            WHERE 1
                $id_filter
                $offline_point_id_filter
                $created_filter
                $keyword_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }
    
    public function add_saldo_point($saldo_point)
    {
		$query = $this->db->placehold("
            INSERT INTO __saldo_points SET ?%
        ", (array)$saldo_point);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update_saldo_point($id, $saldo_point)
    {
		$query = $this->db->placehold("
            UPDATE __saldo_points SET ?% WHERE id = ?
        ", (array)$saldo_point, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete_saldo_point($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __saldo_points WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }

}