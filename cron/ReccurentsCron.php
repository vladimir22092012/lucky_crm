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


            for ($i = 1; $i <= 10; $i++) {

                $sum = ($debt / $i * 10) * 100;

                $reasonCode = $this->debiting($contract->card_id, $sum, $description);

                if (in_array($reasonCode, [2, 3])) {
                    CardsORM::destroy($contract->card_id);
                    break;
                }
                elseif ($reasonCode == 1)
                    $debt -= $sum;
                else
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