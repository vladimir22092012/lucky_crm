<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class KpiCollectionCron extends Core
{
    public function __construct()
    {
        parent::__construct();

        $this->run();
    }

    private function run()
    {
        $date_from = date('Y-m-d 00:00:00');
        $date_to = date('Y-m-d 23:59:59');

        $results = $this->transactions->get_transactions_collections($date_from,$date_to);

        foreach ($results as $result) {
            $sum = (int)$result->percents_summ + (int)$result->charge_summ + (int)$result->peni_summ + (int)$result->commision_summ;
            $record_date = date('Y-m-d', strtotime($result->created));
            $now_date = date('Y-m-d H:i:s');

            if (!isset($report[$record_date])) {
                $report[$record_date] = array();
            }


            if ($result->delay_period >= 1 && $result->delay_period <= 30) {

                $key = '1-30';
            }
            if ($result->delay_period >= 31 && $result->delay_period <= 60) {

                $key = '31-60';
            }
            if ($result->delay_period >= 61 && $result->delay_period <= 90) {

                $key = '61-90';
            }

            if (isset($report[$record_date][$key])) {
                $report[$record_date][$key]['pay_sum'] += $sum;
            } else {
                $report[$record_date][$key] = [
                    'pay_sum' => $sum,
                    'update_at' => $now_date];
            }

        }


        foreach ($report as $date => $value) {
            foreach ($value as $position => $val) {

                $format_date_from = date('Y-m-d 00:00:00', strtotime($date));
                $format_date_to = date('Y-m-d 23:59:59', strtotime($date));

                $kpi = $this->Kpicollections->get_records($format_date_from, $format_date_to);

                foreach ($kpi as $record)
                {
                    $kpi = $val['pay_sum'] / $record->od_sum * 100;

                    $data = ['pay_sum' => (int)$val['pay_sum'], 'update_at' => $val['update_at'], 'kpi' => $kpi];
                    $this->Kpicollections->update_record($data, $position, $date);
                }
            }
        }
    }
}

new KpiCollectionCron();