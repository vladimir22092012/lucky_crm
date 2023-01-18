<?php
error_reporting(-1);
ini_set('display_errors', 'On');


//chdir('/home/v/vse4etkoy2/nalic_eva-p_ru/public_html/');
chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class ReccurentsCron extends Core
{
    public function __construct()
    {
        parent::__construct();
        $this->run();
    }

    private function run()
    {
        $contracts = ContractsORM::where('status', 4)->get();

        foreach ($contracts as $contract) {
            $description = 'Оплата по договору ' . $contract->number;

            $debt = $contract->loan_body_summ + $contract->loan_percents_summ;


            for ($i = 1; $i <= 4; $i++) {

                $prc = ($i * 10) / 100;

                $sum = $debt * $prc;

                if(is_float($sum))
                    $sum = ceil($sum);

                $reasonCode = $this->debiting($contract->card_id, $sum * 100, $description);

                var_dump($reasonCode);
                exit;

                if (in_array($reasonCode, [2, 3])) {
                    CardsORM::destroy($contract->card_id);
                    break;
                } elseif ($reasonCode == 1) {
                    $debt -= $sum;
                    $sumPay = $sum;

                    // списываем проценты
                    $contract_loan_percents_summ = (float)$contract->loan_percents_summ;
                    if ($contract->loan_percents_summ > 0) {
                        if ($sum >= $contract->loan_percents_summ) {
                            $contract_loan_percents_summ = 0;
                            $sum -= $contract->loan_percents_summ;
                        } else {
                            $contract_loan_percents_summ = $contract->loan_percents_summ - $sum;
                            $sum = 0;
                        }
                    }

                    // списываем основной долг
                    $contract_loan_body_summ = (float)$contract->loan_body_summ;
                    if ($contract->loan_body_summ > 0) {
                        if ($sum >= $contract->loan_body_summ) {
                            $contract_loan_body_summ = 0;
                            $sum -= $contract->loan_body_summ;
                        } else {
                            $contract_loan_body_summ = $contract->loan_body_summ - $sum;
                            $sum = 0;
                        }
                    }

                    $this->contracts->update_contract($contract->id, array(
                        'loan_percents_summ' => $contract_loan_percents_summ,
                        'loan_body_summ' => $contract_loan_body_summ,
                    ));

                    // закрываем кредит
                    $contract_loan_percents_summ = round($contract_loan_percents_summ, 2);
                    $contract_loan_body_summ = round($contract_loan_body_summ, 2);
                    if ($contract_loan_body_summ <= 0 && $contract_loan_percents_summ <= 0) {
                        $this->contracts->update_contract($contract->id, array(
                            'status' => 3,
                            'collection_status' => 0,
                            'close_date' => date('Y-m-d H:i:s'),
                        ));

                        $this->orders->update_order($contract->order_id, array(
                            'status' => 7
                        ));
                    }

                    $this->operations->add_operation(array(
                        'contract_id' => $contract->id,
                        'user_id' => $contract->user_id,
                        'order_id' => $contract->order_id,
                        'type' => 'PAY-REC',
                        'amount' => $sumPay,
                        'created' => date('Y-m-d H:i:s'),
                        'transaction_id' => 0,
                    ));
                } else
                    break;
            }
        }
    }

    private function debiting($contractId, $sum, $description)
    {
        $xml = $this->best2pay->purchase($contractId, $sum, $description);
        return $xml;
        $reasonCode = (string)$xml->reason_code;
    }
}

new ReccurentsCron();