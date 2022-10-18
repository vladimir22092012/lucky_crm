<?php
error_reporting(-1);
ini_set('display_errors', 'On');

chdir(dirname(__FILE__).'/../');

require 'autoload.php';


/**
 * TaxingCron
 * Скрипт начисляет проценты, пени, просрочки на дату
 * 
 */
class TaxingOnDateScript extends Core
{
    private $taxing_date = '2022-06-02';
    
    public function __construct()
    {
    	parent::__construct();
        
        $this->run();
    }

    private function run()
    {
        // начисление по выданным договорам 
//        $this->taxing_contracts();
        
        // начисление по просроченным договорам
        $this->taxing_expired_contracts();

    }
    
    private function taxing_contracts()
    {
        while ($contracts = $this->get_valid_contracts())
        {
            foreach ($contracts as $contract)
            {
                // если займ не просрочен начисляем по обычной ставке
                $percents_summ = round($contract->loan_body_summ / 100 * $contract->base_percent, 2);
 
                if ($percents_summ > 0)
                {

                    $this->contracts->update_contract($contract->id, array(
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ
                    ));
                    
                    $this->operations->add_operation(array(
                        'contract_id' => $contract->id,
                        'user_id' => $contract->user_id,
                        'order_id' => $contract->order_id,
                        'type' => 'PERCENTS',
                        'amount' => $percents_summ,
                        'created' => date('Y-m-d H:i:s', strtotime($this->taxing_date)),
                        'loan_body_summ' => $contract->loan_body_summ,
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                        'loan_charge_summ' => $contract->loan_charge_summ,
                        'loan_peni_summ' => $contract->loan_peni_summ,
                    ));

echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contract, $percents_summ);echo '</pre><hr />';

                }
            }
  
//exit;
        }
    }
    
    
    private function get_valid_contracts()
    {
        $query = $this->db->placehold("
            SELECT *
            FROM __contracts as c
            WHERE c.type = 'base'
            AND loan_body_summ > 0
            AND status = 2
            AND DATE(inssuance_date) < ?
            AND c.id NOT IN(
                SELECT contract_id 
                FROM __operations
                WHERE type = 'PERCENTS'
                AND DATE(created) = ?
            )
            ORDER BY id ASC
            LIMIT 100
        ", $this->taxing_date, $this->taxing_date);
        $this->db->query($query);
        
        $results = $this->db->results();

echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($query);echo '</pre><hr />';        
//exit;

        return $results;
    }
    
    
    private function taxing_expired_contracts()
    {
        
        while ($contracts = $this->get_expired_contracts($params))
        {
            foreach ($contracts as $contract)
            {
                // начисляем по обычной ставке
                $percents_summ = round($contract->loan_body_summ / 100 * $contract->base_percent, 2);
echo 'PERCENTS: '.$percents_summ.'<br />';                 
                $this->contracts->update_contract($contract->id, array(
                    'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ
                ));
                
                $this->operations->add_operation(array(
                    'contract_id' => $contract->id,
                    'user_id' => $contract->user_id,
                    'order_id' => $contract->order_id,
                    'type' => 'PERCENTS',
                    'amount' => $percents_summ,
                    'created' => date('Y-m-d 00:00:00', strtotime($this->taxing_date)),
                    'loan_body_summ' => $contract->loan_body_summ,
                    'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                    'loan_charge_summ' => $contract->loan_charge_summ,
                    'loan_peni_summ' => $contract->loan_peni_summ,
                ));
                
                $charge_percents_summ = 0;
                $sold_date = strtotime(date('Y-m-d 00:00:00', strtotime($contract->sold_date)));
                if ($contract->sold && ($sold_date <= strtotime($this->taxing_date)))
                {
                    // начисляем ответственность
                    $charge_percents_summ = round($contract->loan_body_summ / 100 * $contract->charge_percent, 2);
                     
echo 'CHARGE: '.$charge_percents_summ.'<br />';
                    $this->contracts->update_contract($contract->id, array(
                        'loan_charge_summ' => $contract->loan_charge_summ + $charge_percents_summ
                    ));
                    
                    $this->operations->add_operation(array(
                        'contract_id' => $contract->id,
                        'user_id' => $contract->user_id,
                        'order_id' => $contract->order_id,
                        'type' => 'CHARGE',
                        'amount' => $charge_percents_summ,
                        'created' => date('Y-m-d 00:00:00', strtotime($this->taxing_date)),
                        'loan_body_summ' => $contract->loan_body_summ,
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                        'loan_charge_summ' => $contract->loan_charge_summ + $charge_percents_summ,
                        'loan_peni_summ' => $contract->loan_peni_summ,
                    ));
                }
                
                // начисляем пени
                $peni_summ = round($contract->loan_body_summ / 100 * ($contract->peni_percent / 365), 2);
                
                $return_date = strtotime(date('Y-m-d 00:00:00', strtotime($contract->return_date)));
                if ($return_date <= strtotime($this->taxing_date))
                {
echo 'PENI: '.$peni_summ.'<br />';
                    $this->contracts->update_contract($contract->id, array(
                        'loan_peni_summ' => $contract->loan_peni_summ + $peni_summ
                    ));
                    
                    $this->operations->add_operation(array(
                        'contract_id' => $contract->id,
                        'user_id' => $contract->user_id,
                        'order_id' => $contract->order_id,
                        'type' => 'PENI',
                        'amount' => $peni_summ,
                        'created' => date('Y-m-d 00:00:00', strtotime($this->taxing_date)),
                        'loan_body_summ' => $contract->loan_body_summ,
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                        'loan_charge_summ' => $contract->loan_charge_summ + $charge_percents_summ,
                        'loan_peni_summ' => $contract->loan_peni_summ + $peni_summ,
                    ));
                }
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contract);echo '</pre><hr />';
            }
//exit;
        }
    }
    
    private function get_expired_contracts()
    {
        $query = $this->db->placehold("
            SELECT *
            FROM __contracts as c
            WHERE c.type = 'base'
            AND loan_body_summ > 0
            AND status = 4
            AND DATE(inssuance_date) < ?
            AND sud = 0
            AND c.id NOT IN(
                SELECT contract_id 
                FROM __operations
                WHERE type = 'PERCENTS'
                AND DATE(created) = ?
            )
            ORDER BY id DESC
            LIMIT 100
        ", $this->taxing_date, $this->taxing_date);
        $this->db->query($query);
        
        $results = $this->db->results();

echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($query);echo '</pre><hr />';        
//exit;

        return $results;
    }
    
}
new TaxingOnDateScript();