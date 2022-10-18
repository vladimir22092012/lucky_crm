<?php

chdir('..');

require 'autoload.php';

class OperationsService extends Core
{
    private $response = array(

        'info' => array(
            'PERCENTS' => 'Проценты',
            'PENI' => 'Пени',
            'CHARGE' => 'Ответственность',
        )
        
    );
    
    private $password = 'AX6878EK';
    
    public function __construct()
    {
    	$this->run();
    }
    
    private function run()
    {
    	$number = $this->request->get('number');
        
        if (empty($number))
        {
            $this->response['error'] = 1;
            $this->response['message'] = 'Не указан номер договора';
            
            $this->output();
        }
        
        $password = $this->request->get('password');
        if ($password != $this->password)
        {
            $this->response['error'] = 1;
            $this->response['message'] = 'Укажите пароль обмена';
            
            $this->output();            
        }

        $query = $this->db->placehold("
            SELECT 
                *
            FROM __contracts
            WHERE 
                number = ?
        ", $number);
        $this->db->query($query);
        $contract = $this->db->result();
        if (empty($contract))
        {
            $this->response['error'] = 1;
            $this->response['message'] = 'Договор не найден';
            
            $this->output();            
            
        }
        
        $query = $this->db->placehold("
            SELECT 
                o.type,
                o.amount,
                o.created
            FROM __operations AS o
            WHERE o.type IN ('PERCENTS', 'PENI', 'CHARGE') 
            AND o.contract_id = ?
        ", $contract->id);
        $this->db->query($query);
        $operations = $this->db->results();
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($query);echo '</pre><hr />';        
        $this->response['success'] = 1;
        
        if (!empty($operations))
        {
            $this->response['operations'] = array();
            foreach ($operations as $operation)
            {
                $format_date = date('d.m.Y', strtotime($operation->created));
                if (!isset($this->response['operations'][$format_date]))
                {
                    $this->response['operations'][$format_date] = array(
                        'date' => $format_date,
                        'PERCENTS' => 0,
                        'PENI' => 0,
                        'CHARGE' => 0
                    );
                }
                $this->response['operations'][$format_date][$operation->type] += $operation->amount;
            }
        }

        $this->output();
    }
    
    private function output()
    {
        header('Content-type:application/json');
        echo json_encode($this->response);
        
        exit;
    }
}
new OperationsService();