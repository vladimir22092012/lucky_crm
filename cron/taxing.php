<?php
error_reporting(-1);
ini_set('display_errors', 'On');

chdir(dirname(__FILE__).'/../');

require 'autoload.php';


/**
 * TaxingCron
 * Скрипт начисляет проценты, пени, просрочки по выданным договорам
 * переводит договора по стадиям и распределяет по коллекторам
 * 
 */
class TaxingCron extends Core
{
    public function __construct()
    {
    	parent::__construct();
        
        file_put_contents($this->config->root_dir.'cron/log.txt', date('d-m-Y H:i:s').' Taxing RUN'.PHP_EOL, FILE_APPEND);
    
        $this->run();
    }

    private function run()
    {
        // перевод контрактов в статус просрочен
        $this->contracts->check_expiration_contracts();

        // перевод контрактов по стадиям коллекшина
        $this->contracts->check_collection_contracts();

        // перевод контрактов на юк
        $this->contracts->check_sold_contracts();

        // распределение контрактов между коллекторами
        $this->contracts->distribute_contracts();
    
        // начисление по выданным договорам 
        $this->taxing_contracts();
        
        // начисление по просроченным договорам
        $this->taxing_expired_contracts();
        
        // начисление по оффлайн договорам
        $this->taxing_offline_contracts();
        
        // начисление по оффлайн договорам
        $this->taxing_offline_expired_contracts();
        
    }
    
    private function taxing_contracts()
    {
        $params = [
            'status' => 2,
            'date' => date('Y-m-d'),
            'type' => 'base',
        ];
        while ($contracts = $this->get_contracts($params))
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
                        'created' => date('Y-m-d H:i:s'),
                        'loan_body_summ' => $contract->loan_body_summ,
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                        'loan_charge_summ' => $contract->loan_charge_summ,
                        'loan_peni_summ' => $contract->loan_peni_summ,
                    ));
                }
            }

echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contracts);echo '</pre><hr />';
//exit;
        }
    }
    
    private function taxing_expired_contracts()
    {
        $params = [
            'status' => 4,
            'date' => date('Y-m-d'),
            'type' => 'base',
        ];
        
        while ($contracts = $this->get_contracts($params))
        {
            foreach ($contracts as $contract)
            {
                // начисляем по обычной ставке
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
                        'created' => date('Y-m-d H:i:s'),
                        'loan_body_summ' => $contract->loan_body_summ,
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                        'loan_charge_summ' => $contract->loan_charge_summ,
                        'loan_peni_summ' => $contract->loan_peni_summ,
                    ));
                }
                
                $return_date_unix = strtotime(date('Y-m-d 00:00:00', strtotime($contract->return_date)));
                $today_date_unix = strtotime(date('Y-m-d 00:00:00'));
                $contract_expired = $today_date_unix > $return_date_unix;
                    
                $charge_percents_summ = 0;
                if ($contract->sold && $contract_expired)
                {
                    // начисляем ответственность
                    $charge_percents_summ = round($contract->loan_body_summ / 100 * $contract->charge_percent, 2);
                     
                    if ($charge_percents_summ > 0)
                    {
                        $this->contracts->update_contract($contract->id, array(
                            'loan_charge_summ' => $contract->loan_charge_summ + $charge_percents_summ
                        ));
                        
                        $this->operations->add_operation(array(
                            'contract_id' => $contract->id,
                            'user_id' => $contract->user_id,
                            'order_id' => $contract->order_id,
                            'type' => 'CHARGE',
                            'amount' => $charge_percents_summ,
                            'created' => date('Y-m-d H:i:s'),
                            'loan_body_summ' => $contract->loan_body_summ,
                            'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                            'loan_charge_summ' => $contract->loan_charge_summ + $charge_percents_summ,
                            'loan_peni_summ' => $contract->loan_peni_summ,
                        ));
                    }
                }
                
                // начисляем пени
                $peni_summ = round($contract->loan_body_summ / 100 * ($contract->peni_percent / 365), 2);
                if ($peni_summ > 0 && $contract_expired)
                {
                    $this->contracts->update_contract($contract->id, array(
                        'loan_peni_summ' => $contract->loan_peni_summ + $peni_summ
                    ));
                    
                    $this->operations->add_operation(array(
                        'contract_id' => $contract->id,
                        'user_id' => $contract->user_id,
                        'order_id' => $contract->order_id,
                        'type' => 'PENI',
                        'amount' => $peni_summ,
                        'created' => date('Y-m-d H:i:s'),
                        'loan_body_summ' => $contract->loan_body_summ,
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                        'loan_charge_summ' => $contract->loan_charge_summ + $charge_percents_summ,
                        'loan_peni_summ' => $contract->loan_peni_summ + $peni_summ,
                    ));
                }
            }
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contracts);echo '</pre><hr />';
//exit;
        }
    }
    
    private function taxing_offline_contracts()
    {
        $params = [
            'status' => 2,
            'date' => date('Y-m-d'),
            'type' => 'offline',
        ];
        
        while ($contracts = $this->get_contracts($params))
        {
            foreach ($contracts as $contract)
            {
                // начисляем по обычной ставке
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
                        'created' => date('Y-m-d H:i:s'),
                        'loan_body_summ' => $contract->loan_body_summ,
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                        'loan_charge_summ' => $contract->loan_charge_summ,
                        'loan_peni_summ' => $contract->loan_peni_summ,
                    ));
                }
            }

        }

    }
    
    private function taxing_offline_expired_contracts()
    {
        $params = [
            'status' => 4,
            'date' => date('Y-m-d'),
            'type' => 'offline',
        ];
        
        while ($contracts = $this->get_contracts($params))
        {
            foreach ($contracts as $contract)
            {
                // начисляем по обычной ставке
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
                        'created' => date('Y-m-d H:i:s'),
                        'loan_body_summ' => $contract->loan_body_summ,
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                        'loan_charge_summ' => $contract->loan_charge_summ,
                        'loan_peni_summ' => $contract->loan_peni_summ,
                    ));
                }
                
                $return_date_unix = strtotime(date('Y-m-d 00:00:00', strtotime($contract->return_date)));
                $today_date_unix = strtotime(date('Y-m-d 00:00:00'));
                $contract_expired = $today_date_unix > $return_date_unix;
                    
                $charge_percents_summ = 0;
                if ($contract_expired)
                {
                    // начисляем ответственность
                    $charge_percents_summ = round($contract->loan_body_summ / 100 * $contract->charge_percent, 2);
                     
                    if ($charge_percents_summ > 0)
                    {
                        $this->contracts->update_contract($contract->id, array(
                            'loan_charge_summ' => $contract->loan_charge_summ + $charge_percents_summ
                        ));
                        
                        $this->operations->add_operation(array(
                            'contract_id' => $contract->id,
                            'user_id' => $contract->user_id,
                            'order_id' => $contract->order_id,
                            'type' => 'CHARGE',
                            'amount' => $charge_percents_summ,
                            'created' => date('Y-m-d H:i:s'),
                            'loan_body_summ' => $contract->loan_body_summ,
                            'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                            'loan_charge_summ' => $contract->loan_charge_summ + $charge_percents_summ,
                            'loan_peni_summ' => $contract->loan_peni_summ,
                        ));
                    }
                }
                
                // начисляем пени
                $peni_summ = round($contract->loan_body_summ / 100 * ($contract->peni_percent / 365), 2);
                if ($peni_summ > 0 && $contract_expired)
                {
                    $this->contracts->update_contract($contract->id, array(
                        'loan_peni_summ' => $contract->loan_peni_summ + $peni_summ
                    ));
                    
                    $this->operations->add_operation(array(
                        'contract_id' => $contract->id,
                        'user_id' => $contract->user_id,
                        'order_id' => $contract->order_id,
                        'type' => 'PENI',
                        'amount' => $peni_summ,
                        'created' => date('Y-m-d H:i:s'),
                        'loan_body_summ' => $contract->loan_body_summ,
                        'loan_percents_summ' => $contract->loan_percents_summ + $percents_summ,
                        'loan_charge_summ' => $contract->loan_charge_summ + $charge_percents_summ,
                        'loan_peni_summ' => $contract->loan_peni_summ + $peni_summ,
                    ));
                }
            }
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contracts);echo '</pre><hr />';
//exit;
        }
    }
    
    private function get_contracts($params)
    {
        if (empty($params['status']) || empty($params['date']) || empty($params['type']))
            throw new Exception('empty status or date or type');
        
        $filter_status = $this->db->placehold("AND status = ?", (int)$params['status']);

        $filter_type = $this->db->placehold("AND type = ?", (string)$params['type']);
        
        $date_filter = $this->db->placehold("
            AND c.id NOT IN(
                SELECT contract_id 
                FROM __operations
                WHERE type = 'PERCENTS'
                AND DATE(created) = ?
            )
        ", $params['date']);
        
        $query = $this->db->placehold("
            SELECT *
            FROM __contracts as c
            WHERE c.sud = 0
            AND loan_body_summ > 0
                $filter_type
                $filter_status
                $date_filter
            LIMIT 100
        ");
        $this->db->query($query);
        
        $results = $this->db->results();
        
        return $results;
    }
}
new TaxingCron();