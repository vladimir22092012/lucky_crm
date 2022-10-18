<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class KpiReportCron extends Core
{
    public function __construct()
    {
        parent::__construct();

file_put_contents($this->config->root_dir.'logs/kpi.log', date('Y-m-d H:i:s'));

        $this->run();
    }

    private function run()
    {
        $date_from = date('Y-m-d 00:00', strtotime('-90 day'));
        $date_to = date('Y-m-d 00:00');


        $filter_status = [4,7];

        $filter_status = implode(',', $filter_status);

        $query = $this->db->placehold("
        select return_date,
        loan_body_summ,
        loan_percents_summ,
        loan_charge_summ,
        loan_peni_summ
        from s_contracts
        where status in ($filter_status)
        and return_date between ? and ?
        ", (string)$date_from, $date_to);

        $this->db->query($query);

        $records = $this->db->results();

        $results = [];
        $results['1-30']['loan_body_summ'] = 0;
        $results['1-30']['loan_percents_summ'] = 0;
        $results['1-30']['loan_charge_summ'] = 0;
        $results['1-30']['loan_peni_summ'] = 0;
        $results['31-60']['loan_body_summ'] = 0;
        $results['31-60']['loan_percents_summ'] = 0;
        $results['31-60']['loan_charge_summ'] = 0;
        $results['31-60']['loan_peni_summ'] = 0;
        $results['61-90']['loan_body_summ'] = 0;
        $results['61-90']['loan_percents_summ'] = 0;
        $results['61-90']['loan_charge_summ'] = 0;
        $results['61-90']['loan_peni_summ'] = 0;

        foreach ($records as $record) {
            $date_to = date('Y-m-d', strtotime($date_to));
            $date_from = date('Y-m-d', strtotime($record->return_date));

            if (strtotime($date_to) - strtotime($date_from) >= 1 * 24 * 60 * 60 && strtotime($date_to) - strtotime($date_from) <= 30 * 24 * 60 * 60) {
                $results['1-30']['loan_body_summ'] += (int)$record->loan_body_summ;
                $results['1-30']['loan_percents_summ'] += (int)$record->loan_percents_summ;
                $results['1-30']['loan_charge_summ'] += (int)$record->loan_charge_summ;
                $results['1-30']['loan_peni_summ'] += (int)$record->loan_peni_summ;
            }
            if (strtotime($date_to) - strtotime($date_from) >= 31 * 24 * 60 * 60 && strtotime($date_to) - strtotime($date_from) <= 60 * 24 * 60 * 60) {
                $results['31-60']['loan_body_summ'] += (int)$record->loan_body_summ;
                $results['31-60']['loan_percents_summ'] += (int)$record->loan_percents_summ;
                $results['31-60']['loan_charge_summ'] += (int)$record->loan_charge_summ;
                $results['31-60']['loan_peni_summ'] += (int)$record->loan_peni_summ;
            }
            if (strtotime($date_to) - strtotime($date_from) >= 61 * 24 * 60 * 60 && strtotime($date_to) - strtotime($date_from) <= 90 * 24 * 60 * 60) {
                $results['61-90']['loan_body_summ'] += (int)$record->loan_body_summ;
                $results['61-90']['loan_percents_summ'] += (int)$record->loan_percents_summ;
                $results['61-90']['loan_charge_summ'] += (int)$record->loan_charge_summ;
                $results['61-90']['loan_peni_summ'] += (int)$record->loan_peni_summ;
            }
        }

        $sum[0] = ['position' => '1-30', 'od_sum' => array_sum($results['1-30'])];
        $sum[1] = ['position' => '31-60', 'od_sum' => array_sum($results['31-60'])];
        $sum[2] = ['position' => '61-90', 'od_sum' => array_sum($results['61-90'])];
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($sum);echo '</pre><hr />';

        foreach ($sum as $value) {
            $query = $this->db->placehold("
                insert into s_kpicollections SET ?%
            ", $value);

            $this->db->query($query);
        }

    }
}

new KpiReportCron();