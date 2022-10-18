<?php

class IndexController extends Controller
{	
	public $modules_dir = 'controllers/';

	public function __construct()
	{
		parent::__construct();
	}

	function fetch()
	{
			
		// Страницы
		$pages = $this->pages->get_pages(array('visible'=>1));		
		$this->design->assign('pages', $pages);
							
		// Текущий модуль (для отображения центрального блока)
		$module = $this->request->get('module', 'string');
		$module = preg_replace("/[^A-Za-z0-9]+/", "", $module);

        if ($module != 'LoginController' && !$this->manager)
        {
            header('Location: '.$this->config->root_url.'/login?back='.$this->request->url());
            exit;
        }


		// Если не задан - берем из настроек
		if (empty($module) && !empty($this->manager->role) && in_array($this->manager->role, ['collector', 'chief_collector', 'team_collector', 'yurist']))
            $module = 'CollectorContractsController';
		elseif (empty($module) && !empty($this->manager->role) && in_array($this->manager->role, ['exactor', 'chief_exactor', 'sudblock', 'chief_sudblock']))
            $module = 'SudblockContractsController';
        elseif(empty($module))
    		$module = 'OrdersController';

		if (class_exists($module))
		{
			$this->main = new $module($this);
		} 
        else 
        {
            return false;
        }
		
        if (!$content = $this->main->fetch())
		{
			return false;
		}		
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($offline_points);echo '</pre><hr />';        
		$this->design->assign('content', $content);		
		$this->design->assign('module', $module);		
		
        $wrapper = $this->design->get_var('wrapper');
		if(is_null($wrapper))
			$wrapper = 'index.tpl';
		
        if (!empty($this->manager) && in_array($this->manager->role, ['user', 'admin', 'developer']))
        {
            $params = array(
                'missing' => 300,
                'limit' => 10,
                'sort' => 'id_desc',
            );
            
            $missings = $this->users->get_users($params);

            $missings = array_map(function($var) {
                if (!empty($var->stage_card))
                {
                    $var->stages = 7;
                    $var->last_stage_date = $var->card_added_date;
                }
                elseif (!empty($var->stage_files))
                {
                    $var->stages = 6;
                    $var->last_stage_date = $var->files_added_date;
                }
                elseif (!empty($var->stage_work))
                {
                    $var->stages = 5;
                    $var->last_stage_date = $var->work_added_date;
                }
                elseif (!empty($var->stage_address))
                {
                    $var->stages = 4;
                    $var->last_stage_date = $var->address_data_added_date;
                }
                elseif (!empty($var->stage_passport))
                {
                    $var->stages = 3;
                    $var->last_stage_date = $var->passport_date_added_date;
                }
                elseif (!empty($var->stage_personal))
                {
                    $var->stages = 2;
                    $var->last_stage_date = $var->stage_personal_date;
                }
                else
                {
                    $var->stages = 1;
                    $var->last_stage_date = $var->created;
                }
    
                return $var;
            }, $missings);

//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($missings);echo '</pre><hr />';

            $this->design->assign('missings_notifications', $missings);
        }
        
        if (!empty($this->manager) && in_array('notifications', $this->manager->permissions))
        {
    		$filter = array(
                'limit' => 3,
                'notification_date' => date('Y-m-d'),
                'done' => 0
            );
            
            if (in_array($this->manager->role, array('collector', 'chief_collector', 'team_collector')))
                $filter['collection_mode'] = 1;
            
            if (in_array($this->manager->role, array('exactor', 'chief_exactor', 'sudblock', 'chief_sudblock')))
                $filter['sudblock_mode'] = 1;
            
            if (in_array($this->manager->role, array('exactor', 'sudblock', 'collector')))
                $filter['manager_id'] = $this->manager->id;
            
            
            $active_notifications = $this->notifications->get_notifications($filter);
            if (!empty($active_notifications))
            {
                foreach ($active_notifications as $an)
                {
                    if (!empty($an->event_id))
                        $an->event = $this->notifications->get_event($an->event_id);
                }
            }
            $this->design->assign('active_notifications', $active_notifications);
        }
        
        if (!empty($this->manager) && in_array('penalties', $this->manager->permissions))
        {
            $filter = array();
            if (in_array($this->manager->role, ['user', 'big_user', 'cs_pc']))
            {
                $filter['status'] = array(1);
                $filter['manager_id'] = $this->manager->id;
            }
            else
            {
                $filter['status'] = array(2);
            }
            $penalty_types = array();
            foreach ($this->penalties->get_types() as $t)
                $penalty_types[$t->id] = $t;

            if ($penalty_notifications = $this->penalties->get_penalties($filter))
            {
                foreach ($penalty_notifications as $pn)
                    if (isset($penalty_types[$pn->type_id]))
                        $pn->type = $penalty_types[$pn->type_id];
            }
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($penalty_notifications);echo '</pre><hr />';
            
            $this->design->assign('penalty_notifications', $penalty_notifications);
        }
        
        if (!empty($this->manager->offline_point_id))
        {
            $current_offline_point = $this->offline->get_point($this->manager->offline_point_id);
            $current_offline_point->worktime = $this->offline->get_date_worktime($this->manager->offline_point_id, date('Y-m-d'));
        
            $this->design->assign('current_offline_point', $current_offline_point);
        }
        
        if(!empty($wrapper))
			return $this->body = $this->design->fetch($wrapper);
		else
			return $this->body = $content;

	}
}
