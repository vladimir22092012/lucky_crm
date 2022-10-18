<?php
error_reporting(-1);
ini_set('display_errors', 'On');

session_start();

chdir('..');
require 'autoload.php';

class CommunicationsAjax extends Core
{
    private $manager = 0;
    
    private $response = array();
    
    public function __construct()
    {
    	parent::__construct();
        
        $this->manager = $this->managers->get_manager($_SESSION['manager_id']);
        
        $this->run();
        
    }
    
    public function run()
    {
    	$action = $this->request->get('action', 'string');
        
        switch ($action):
            
            case 'add':
                $this->action_add_communication();                
            break;
            
            case 'check':
                $this->action_check_communication();                
            break;
            
        endswitch;

        $this->json_output();
        
    }
    
    private function action_add_communication()
    {
        $user_id = $this->request->get('user_id', 'integer');
        $order_id = $this->request->get('order_id', 'integer');
        $type = $this->request->get('type', 'string');
        $content = (string)$this->request->get('content');
        $from_number = (string)$this->request->get('from_number');
        $to_number = (string)$this->request->get('to_number');
        $mangocall_id = (int)$this->request->get('mangocall_id');
        $yuk = (int)$this->request->get('yuk');
        
        if (empty($order_id))
        {
            $this->db->query("
                SELECT order_id 
                FROM __contracts
                WHERE user_id = ?
                AND status IN(2, 4)
                LIMIT 1
            ", $user_id);
            $order_id = (int)$this->db->result('order_id');
        }
        
        if ($type == 'call')
            $from_number = $this->mango->get_linenumber($yuk);
        
        $this->response = $this->communications->add_communication(array(
            'user_id' => $user_id,
            'order_id' => $order_id,
            'manager_id' => $this->manager->id,
            'created' => date('Y-m-d H:i:s'),
            'type' => $type,
            'content' => $content,
            'outer_id' => $mangocall_id,
            'from_number' => $from_number,
            'to_number' => $to_number,
            'yuk' => $yuk,
        ));
    }
    
    private function action_check_communication()
    {
        $user_id = $this->request->get('user_id', 'integer');
        $is_call = $this->request->get('call', 'integer');
        
        $this->response = (int)$this->communications->check_user($user_id, $is_call);
    }
    
    
    private function json_output()
    {
        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");	
        
        echo json_encode($this->response);
    }
}
new CommunicationsAjax();