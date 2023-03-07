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

            $card = CardsORM::find($contract->card_id);

            if (!empty($card->deleted))
                continue;

            $iterations =
                [
                    1 => 5,
                    2 => 5,
                    3 => 5,
                    4 => 5,
                    5 => 5,
                    6 => 7,
                    7 => 7,
                    8 => 7,
                    9 => 7,
                    10 => 7,
                    11 => 20,
                    12 => 30,
                    13 => 100
                ];


            for ($i = 1; $i <= count($iterations); $i++) {

                $contract = ContractsORM::find($contract->id);

                $debt = $contract->loan_body_summ + $contract->loan_percents_summ;

                $prc = ($i * $iterations[$i]) / 100;

                $sum = $debt * $prc;

                if (is_float($sum))
                    $sum = ceil($sum);

                $reasonCode = $this->debiting($contract->card_id, $sum * 100, $description);

                if (in_array($reasonCode, [2, 3])) {
                    CardsORM::where('id', $contract->card_id)->update(['deleted' => 1]);
                    break;
                } elseif ($reasonCode == 1) {
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
                        } else {
                            $contract_loan_body_summ = $contract->loan_body_summ - $sum;
                        }
                    }

                    $this->contracts->update_contract($contract->id, array(
                        'loan_percents_summ' => $contract_loan_percents_summ,
                        'loan_body_summ' => $contract_loan_body_summ,
                    ));

                    $this->operations->add_operation(array(
                        'contract_id' => $contract->id,
                        'user_id' => $contract->user_id,
                        'order_id' => $contract->order_id,
                        'type' => 'PAY-REC',
                        'amount' => $sumPay,
                        'created' => date('Y-m-d H:i:s'),
                        'transaction_id' => 0,
                        'loan_body_summ' => $contract_loan_body_summ,
                        'loan_percents_summ' => $contract_loan_percents_summ
                    ));

                    if ($contract_loan_body_summ <= 0 && $contract_loan_percents_summ <= 0) {
                        $this->contracts->update_contract($contract->id, array(
                            'status' => 3,
                            'collection_status' => 0,
                            'close_date' => date('Y-m-d H:i:s'),
                        ));

                        $this->orders->update_order($contract->order_id, array(
                            'status' => 7
                        ));

                        $equiReport = EquifaxFactory::get('close');
                        $equiReport->processing($contract->id);
                    }
                } else
                    break;
            }
        }
    }

    private function debiting($contractId, $sum, $description)
    {
        $xml = $this->best2pay->purchase_by_token($contractId, $sum, $description);
        $reasonCode = (string)$xml->reason_code;
        return $reasonCode;
    }
}

new ReccurentsCron();