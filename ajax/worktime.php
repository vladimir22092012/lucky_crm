<?php

error_reporting(-1);
ini_set('display_errors', 'On');

chdir('..');

require 'autoload.php';


class WorktimeAjax extends Ajax
{
    public function __construct()
    {
    	parent::__construct();
        
        switch ($this->request->get('action', 'string')):
            
            case 'update':
                $this->update_worktime();
            break;
            
            case 'open_offline_point':
                $this->open_point();
            break;
            
            case 'close_offline_point':
                $this->close_point();
            break;
            
        endswitch;

        $this->output();
    }
    
    private function update_worktime()
    {
        if ($worktime = $this->managers->get_date_worktime($this->manager->id, date('Y-m-d')))
        {
            $this->response['update'] = $this->managers->update_worktime($worktime->id, array(
                'last_active' => date('Y-m-d H:i:s'),
                'last_ip' => $_SERVER['REMOTE_ADDR']
            ));
        }                
        
    }
    
    private function open_point()
    {
        $today = date('Y-m-d');
        $offline_point_id = $this->request->get('offline_point_id', 'integer');
        
        $offline_point = $this->offline->get_point($offline_point_id);
        
        $worktime = $this->offline->get_date_worktime($offline_point_id, $today);
        
        if (!empty($worktime) && !empty($worktime->open_date))
        {
            $this->response['error'] = 'Отделение уже открыто';
        }
        else
        {
            $current_time = date('H:i:s', time() + 3600 * $offline_point->timezone);
            $ip = $this->helpers->get_ip();
            
            $open_time = strtotime($current_time) < strtotime($offline_point->open_time) ? $offline_point->open_time : $current_time;

            $worktime_id = $this->offline->add_worktime([
                'workdate' => $today,
                'offline_point_id' => $offline_point_id,
                'manager_id' => $this->manager->id,
                'open_time' => date('H:i:s'),
                'open_request_time' => date('H:i:s'),
                'open_ip' => $ip,
            ]);
            
            $this->check_ip($offline_point, $ip, 'open');
            
            $this->check_open_time($current_time, $offline_point->open_time);
            
            $this->response['success'] = $worktime_id;
        }
        
    }
    
    private function close_point()
    {
        $today = date('Y-m-d');
        $offline_point_id = $this->request->get('offline_point_id', 'integer');
        
        $offline_point = $this->offline->get_point($offline_point_id);
        
        $worktime = $this->offline->get_date_worktime($offline_point_id, $today);
        
        if (empty($worktime))
        {
            $this->response['error'] = 'Отделение сегодня не было открыто';
        }
        elseif (!empty($worktime->close_time))
        {
            $this->response['error'] = 'Отделение уже закрыто';
        }
        else
        {
            $current_time = date('H:i:s', time() + 3600 * $offline_point->timezone);
            $ip = $this->helpers->get_ip();
            
            $close_time = strtotime($current_time) > strtotime($offline_point->close_time) ? $offline_point->close_time : $current_time;
            
            $update = [
                'close_time' => $close_time,
                'close_request_time' => $current_time,
                'close_ip' => $ip,
            ];
            $this->response['success'] = $this->offline->update_worktime($worktime->id, $update);
        
            $this->check_ip($offline_point, $ip, 'close');
        }
        
        $this->response['current_time'] = $current_time;
        $this->response['timezone'] = $offline_point->timezone;
        $this->response['offline_point'] = $offline_point;
        
    }
    
    /**
     * WorktimeAjax::check_ip()
     * 
     * проверяет айпи и начисляет штраф
     * @param object $offline_point
     * @param string $ip
     * @param string $action
     * @return void
     */
    private function check_ip($offline_point, $ip, $action)
    {
        $types = [
            'open' => 15,
            'close' => 16
        ];
        
        if ($ip != $offline_point->ip)
        {
            $penalty_type = $this->penalties->get_type($types[$action]);
            $comment = 'Вам начислен '.$penalty_type->name.' ('.$offline_point->address.') - '.$penalty_type->cost.' руб';
            
            $this->penalties->add_penalty([
                'manager_id' => $this->manager->id,
                'type_id' => $penalty_type->id,
                'created' => date('Y-m-d H:i:s'),
                'control_manager_id' => 100, // system
                'status' => 1,
                'cost' => $penalty_type->cost,
                'comment' => $comment,
            ]);
            
            $this->response['penalty_ip'] = $comment;
        }
    }
    
    private function check_open_time($current_time, $open_time)
    {
        if (strtotime($current_time) > strtotime($open_time))
        {
            $diff = intval((strtotime($current_time) - strtotime($open_time)) / 60);
            if ($diff > 0)
            {
                $penalty_type = $this->penalties->get_type(17);
                $penalty_cost = $penalty_type->cost * $diff;
                $comment = 'Вам начислен '.$penalty_type->name.' на '.$diff.' мин - '.$penalty_cost.' руб';
                
                $this->penalties->add_penalty([
                    'manager_id' => $this->manager->id,
                    'type_id' => $penalty_type->id,
                    'created' => date('Y-m-d H:i:s'),
                    'control_manager_id' => 100, // system
                    'status' => 1,
                    'cost' => $penalty_cost,
                    'comment' => $comment,
                ]);
                
                $this->response['penalty_time'] = $comment;
                
            }
        }
    }
}
new WorktimeAjax();