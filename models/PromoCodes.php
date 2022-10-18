<?php

class PromoCodes extends Core
{
    public function get_code($id)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __promo_codes
            WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }

    public function get_code_by_code($code)
	{
		$query = $this->db->placehold("
            SELECT * 
            FROM __promo_codes
            WHERE code = ?
        ", $code);

        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($query);echo '</pre><hr />';

        $this->db->query($query);
        $result = $this->db->result();
	
        return $result;
    }
    
	public function get_codes($filter = array())
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
            FROM __promo_codes
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
    
	public function count_codes($filter = array())
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
            FROM __promo_codes
            WHERE 1
                $id_filter
                $keyword_filter
        ");
        $this->db->query($query);
        $count = $this->db->result('count');
	
        return $count;
    }

    public function add($promo_codes)
    {
		$query = $this->db->placehold("
            INSERT INTO __promo_codes SET ?%
        ", (array)$promo_codes);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function update($id, $promo_codes)
    {
		$query = $this->db->placehold("
            UPDATE __promo_codes SET ?% WHERE id = ?
        ", (array)$promo_codes, (int)$id);
        $this->db->query($query);
        
        return $id;
    }
    
    public function delete($id)
    {
		$query = $this->db->placehold("
            DELETE FROM __promo_codes WHERE id = ?
        ", (int)$id);
        $this->db->query($query);
    }
}