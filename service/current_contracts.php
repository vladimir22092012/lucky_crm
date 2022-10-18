<?php

chdir('..');

require 'autoload.php';

class CurrentContractsService extends Core
{
    private $response = array();
    
    private $password = 'AX6878EK';
    
    public function __construct()
    {
    	$this->run();
    }
    
    private function run()
    {
        $password = $this->request->get('password');
        if ($password != $this->password)
        {
            $this->response['error'] = 1;
            $this->response['message'] = 'Укажите пароль обмена';
            
            $this->output();            
        }
        
    	$from = $this->request->get('from');
    	$to = $this->request->get('to');
        
        $from_split = str_split($from);
        $date_from = $from_split[0].$from_split[1].$from_split[2].$from_split[3].'-'.$from_split[4].$from_split[5].'-'.$from_split[6].$from_split[7].' '.$from_split[8].$from_split[9].':'.$from_split[10].$from_split[11].':'.$from_split[12].$from_split[13];
        
        $to_split = str_split($to);
        $date_to = $to_split[0].$to_split[1].$to_split[2].$to_split[3].'-'.$to_split[4].$to_split[5].'-'.$to_split[6].$to_split[7].' '.$to_split[8].$to_split[9].':'.$to_split[10].$to_split[11].':'.$to_split[12].$to_split[13];
        
        if (empty($date_from) || empty($date_to))
        {
            $this->response['error'] = 1;
            $this->response['message'] = 'Укажите даты в формате ггггММддЧЧммсс';
            
            $this->output();
        }
        
        
        
        $query = $this->db->placehold("
            SELECT 
                c.number,
                c.inssuance_date,
                c.loan_body_summ,
                c.loan_percents_summ,
                c.loan_peni_summ,
                c.loan_charge_summ,
                c.status,
                c.sold,
                c.premier,
                u.lastname,
                u.firstname,
                u.patronymic,
                u.birth
            FROM __contracts AS c
            LEFT JOIN __users AS u
            ON u.id = c.user_id
            WHERE DATE(c.inssuance_date) >= ?
            AND DATE(c.inssuance_date) <= ?
            AND status IN (2, 4, 10)
        ", $date_from, $date_to);
        $this->db->query($query);
        $contracts = $this->db->results();
        
        $this->response['success'] = 1;
        $this->response['from'] = $date_from;;
        $this->response['to'] = $date_to;

        $this->response['items'] = array();
        
        if (!empty($contracts))
        {
            foreach ($contracts as $contract)
            {
                
                $item = new StdClass();
                $item->number = $contract->number;
                $item->date = $contract->inssuance_date;
                $item->client = $contract->lastname.' '.$contract->firstname.' '.$contract->patronymic;
                $item->od = $contract->loan_body_summ;
                $item->percents = $contract->loan_percents_summ;
                $item->peni = $contract->loan_peni_summ;
                $item->charge = $contract->loan_charge_summ;

                if ($contract->premier)
                    $item->organization = 'Премьер';
                elseif ($contract->sold)
                    $item->organization = 'ЮК';
                else
                    $item->organization = 'НалПлюс';
            
                $this->response['items'][] = $item;
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
new CurrentContractsService();