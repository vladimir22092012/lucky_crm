<?php

class Ordertimers extends Core
{
	public function get_ordertimer($order_id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __ordertimers
            WHERE order_id = ?
        ", (int)$order_id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_ordertimers($filter = array())
	{
		$order_id_filter = '';
		$manager_id_filter = '';
        $keyword_filter = '';
        $limit = 1000;
		$page = 1;
        
        if (!empty($filter['order_id']))
            $order_id_filter = $this->db->placehold("AND order_id IN (?@)", array_map('intval', (array)$filter['order_id']));
        
        if (!empty($filter['manager_id']))
            $manager_id_filter = $this->db->placehold("AND manager_id IN (?@)", array_map('intval', (array)$filter['manager_id']));
        
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
            FROM __ordertimers
            WHERE 1
                $order_id_filter
                $manager_id_filter
				$keyword_filter
            ORDER BY id DESC 
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
    
	public function count_ordertimers($filter = array())
	{
        $order_id_filter = '';
        $manager_id_filter = '';
        $keyword_filter = '';
        
        if (!empty($filter['order_id']))
            $order_id_filter = $this->db->placehold("AND order_id IN (?@)", array_map('intval', (array)$filter['order_id']));
        
        if (!empty($filter['manager_id']))
            $manager_id_filter = $this->db->placehold("AND manager_id IN (?@)", array_map('intval', (array)$filter['manager_id']));
        
        if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
                
		$query = $this->db->placehold("
            SELECT COUNT(order_id) AS count
            FROM __ordertimers
            WHERE 1
                $order_id_filter
                $manager_id_filter
                $keyword_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }
    
    public function add_ordertimer($ordertimer)
    {
		$query = $this->db->placehold("
            REPLACE INTO __ordertimers SET ?%
        ", (array)$ordertimer);
        $this->db->query($query);
        $id = $this->db->insert_id();
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($query);echo '</pre><hr />';        
        return $id;
    }
    
    public function update_ordertimer($order_id, $ordertimer)
    {
		$query = $this->db->placehold("
            UPDATE __ordertimers SET ?% WHERE order_id = ?
        ", (array)$ordertimer, (int)$order_id);
        $this->db->query($query);
        
        return $order_id;
    }
    
    public function delete_ordertimer($order_id)
    {
		$query = $this->db->placehold("
            DELETE FROM __ordertimers WHERE order_id = ?
        ", (int)$order_id);
        $this->db->query($query);
    }
}