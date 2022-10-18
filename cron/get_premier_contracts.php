<?php
error_reporting(-1);
ini_set('display_errors', 'On');

chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class PremierContractsCron extends Core
{
    public function __construct()
    {
    	parent::__construct();
        
        $this->run();
    }
    
    private function run()
    {
        $date_from = date('Y-m-d', time() - 14 * 86400);
        $date_to = date('Y-m-d', time() - 0 * 86400);
        
        $this->get_premier_contracts($date_from, $date_to);
        $this->get_sud_contracts($date_from, $date_to);
    
        $this->send_new_tribunals();
    }
    
    private function send_new_tribunals()
    {
        $tribunals = $core->tribunals->get_tribunals();

        foreach ($tribunals as $tribunal)
        {
            if (empty($tribunal->uid))
            {
                $request = [];
                
                $request['Наименование'] = $tribunal->sud;
                $request['АдресСуда'] = '';
                $request['ТелефонСуда'] = '';
                $request['Судья'] = '';
                $request['Email'] = '';
                $request['КакогоСуда'] = '';
                $request['КакимСудом'] = '';
                $request['Суд_БанкПолучателя'] = '';
                $request['Суд_БИК'] = '';
                $request['Суд_ИНН'] = '';
                $request['Суд_КПП'] = '';
                $request['Суд_НомерСчета'] = '';
                $request['Суд_НаименованиеПолучателяПлатежа'] = '';
                $request['Суд_КБК'] = '';
                $request['Суд_ОКТМО'] = '';
                $request['СудГАСРФ'] = '';
                
                if ($resp = $core->soap1c->get_onec_tribunals(json_encode($request)))
                {
                    $core->tribunals->update_tribunal($tribunal->id, array('uid'=>$resp));
                }
        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($tribunal, $resp);echo '</pre><hr />';
            
            }
        }

    }
    
    private function get_sud_contracts($date_from, $date_to)
    {
        $resp = $this->soap1c->get_sud_contracts($date_from, $date_to);

        $numbers = json_decode($resp->return);
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($numbers);echo '</pre><hr />';        
        foreach ($numbers as $number)
        {
            $contract = $this->contracts->get_number_contract($number);
            
            $this->contracts->update_contract($contract->id, array(
                'status' => 10
            ));
            
            
            $this->db->query("
                SELECT id FROM __sudblock_contracts WHERE first_number = ?
            ", $number);
            if ($sudblock_contract_id = $this->db->result('id'))
            {
                $this->sudblock->update_contract($sudblock_contract_id, array(
                    'sud_onec' => 1
                ));
            }
        }
    }
    
    private function get_premier_contracts($date_from, $date_to)
    {
        $contracts = $this->soap1c->get_premier_contracts($date_from, $date_to);
        if (!empty($contracts))
        {
            foreach ($contracts as $item)
            {
                if ($current_contract = $this->contracts->get_number_contract($item->Номер))
                {
                    $this->contracts->update_contract($current_contract->id, array(
                        'sold' => 1,
                        'premier' => 1,
                        'premier_date' => date('Y-m-d H:i:s', strtotime($item->ДатаПремьер)),
                    ));
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($item);echo '</pre><hr />';    
                }
            }
        }
        
    }
    
}
new PremierContractsCron();