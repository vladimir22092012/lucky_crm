<?php
error_reporting(-1);
ini_set('display_errors', 'On');


//chdir('/home/v/vse4etkoy2/nalic_eva-p_ru/public_html/');
chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

/**
 * IssuanceCron
 *
 * Скрипт выдает кредиты, и списывает страховку
 *
 * @author Ruslan Kopyl
 * @copyright 2021
 * @version $Id$
 * @access public
 */
class IssuanceCron extends Core
{
    public function __construct()
    {
        parent::__construct();

        $i = 0;
        while ($i < 10) {
            $this->run();
            $i++;
        }
    }

    private function run()
    {
        if ($contracts = $this->contracts->get_contracts(array('status' => 1, 'limit' => 1))) {

            foreach ($contracts as $contract) {
                $res = $this->best2pay->pay_contract_with_register($contract->id);

                if ($res == 'APPROVED') {
                    $ob_date = new DateTime();
                    $ob_date->add(DateInterval::createFromDateString($contract->period . ' days'));
                    $return_date = $ob_date->format('Y-m-d H:i:s');


                    // Снимаем страховку если есть
                    if (!empty($contract->service_insurance)) 
                    {
                        $insurance_cost = $contract->amount * 0.25;

                        if ($insurance_cost > 0)
                        {
                            $insurance_amount = $insurance_cost * 100;
    
                            $description = 'Страховой полис';
    
                            $xml = $this->best2pay->purchase_by_token($contract->card_id, $insurance_amount, $description);
                            $status = (string)$xml->state;
    
                            if ($status == 'APPROVED') {
                                $transaction = $this->transactions->get_register_id_transaction($xml->order_id);
    
                                $contract = $this->contracts->get_contract($contract->id);
    
                                $payment_amount = $insurance_cost;
    
                                $operation_id = $this->operations->add_operation(array(
                                    'contract_id' => $contract->id,
                                    'user_id' => $contract->user_id,
                                    'order_id' => $contract->order_id,
                                    'type' => 'INSURANCE',
                                    'amount' => $payment_amount,
                                    'created' => date('Y-m-d H:i:s'),
                                    'transaction_id' => $transaction->id,
                                ));
    
                                $dt = new DateTime();
                                $dt->add(new DateInterval('P6M'));
                                $end_date = $dt->format('Y-m-d 23:59:59');

                                try{
                                    $contract->insurance = new InsurancesORM();
                                    $contract->insurance->amount = $insurance_cost;
                                    $contract->insurance->user_id = $contract->user_id;
                                    $contract->insurance->order_id = $contract->order_id;
                                    $contract->insurance->start_date = date('Y-m-d 00:00:00', time() + (1 * 86400));
                                    $contract->insurance->end_date = $end_date;
                                    $contract->insurance->operation_id = $operation_id;
                                    $contract->insurance->save();

                                    $contract->insurance->number = InsurancesORM::create_number($contract->insurance->id);

                                    InsurancesORM::where('id', $contract->insurance->id)->update(['number' => $contract->insurance->number]);
                                }catch (Exception $e)
                                {

                                }
    
                                $this->contracts->update_contract($contract->id, array(
                                    'insurance_id' => $contract->insurance->id
                                ));
    
    
                                $contract->insurance_id = $contract->insurance->id;
                                //TODO: Страховой полиc
                                $this->create_document('POLIS_STRAHOVANIYA', $contract);
                            }
                        }
                    }

                    $this->create_document('IND_USLOVIYA', $contract);

                    $this->contracts->update_contract($contract->id, array(
                        'status' => 2,
                        'inssuance_date' => date('Y-m-d H:i:s'),
                        'loan_body_summ' => $contract->amount,
                        'loan_percents_summ' => 0,
                        'return_date' => $return_date,
                    ));

                    $this->orders->update_order($contract->order_id, array('status' => 5));

                    $this->operations->add_operation(array(
                        'contract_id' => $contract->id,
                        'user_id' => $contract->user_id,
                        'order_id' => $contract->order_id,
                        'type' => 'P2P',
                        'amount' => $contract->amount,
                        'created' => date('Y-m-d H:i:s'),
                    ));

                    Onec::sendRequest(['method' => 'send_loan', 'order_id' => $contract->order_id]);
                    $order = OrdersORM::find($contract->order_id);

                    if($order->utm_source == 'guruleads')
                        Guruleads::sendRequest(['orderId' => $contract->order_id, 'method' => 'sendApprovePostback']);

                    $equifax = EquifaxFactory::get('issuance');
                    $equifax->processing($contract->id);

                } elseif ($res == false) {


                } else {
                    $this->contracts->update_contract($contract->id, array('status' => 6));

                    $this->orders->update_order($contract->order_id, array('status' => 6)); // статус 6 - не удалосб выдать
                }


                echo __FILE__ . ' ' . __LINE__ . '<br /><pre>';
                var_dump($res);
                echo '</pre><hr />';
            }
        }
    }

    public function create_document($document_type, $contract)
    {
        $ob_date = new DateTime();
        $ob_date->add(DateInterval::createFromDateString($contract->period . ' days'));
        $return_date = $ob_date->format('Y-m-d H:i:s');

        $return_amount = round($contract->amount + $contract->amount * $contract->base_percent * $contract->period / 100, 2);
        $return_amount_rouble = (int)$return_amount;
        $return_amount_kop = ($return_amount - $return_amount_rouble) * 100;

        $contract_order = $this->orders->get_order((int)$contract->order_id);

        $insurance_cost = $contract->amount * 0.25;

        $params = array(
            'lastname' => $contract_order->lastname,
            'firstname' => $contract_order->firstname,
            'patronymic' => $contract_order->patronymic,
            'phone' => $contract_order->phone_mobile,
            'birth' => $contract_order->birth,
            'number' => $contract->number,
            'contract_date' => date('Y-m-d H:i:s'),
            'created' => date('Y-m-d H:i:s'),
            'return_date' => $return_date,
            'return_date_day' => date('d', strtotime($return_date)),
            'return_date_month' => date('m', strtotime($return_date)),
            'return_date_year' => date('Y', strtotime($return_date)),
            'return_amount' => $return_amount,
            'return_amount_rouble' => $return_amount_rouble,
            'return_amount_kop' => $return_amount_kop,
            'base_percent' => $contract->base_percent,
            'amount' => $contract->amount,
            'period' => $contract->period,
            'return_amount_percents' => round($contract->amount * $contract->base_percent * $contract->period / 100, 2),
            'passport_serial' => $contract_order->passport_serial,
            'passport_date' => $contract_order->passport_date,
            'subdivision_code' => $contract_order->subdivision_code,
            'passport_issued' => $contract_order->passport_issued,
            'passport_series' => substr(str_replace(array(' ', '-'), '', $contract_order->passport_serial), 0, 4),
            'passport_number' => substr(str_replace(array(' ', '-'), '', $contract_order->passport_serial), 4, 6),
            'asp' => $contract->accept_code,
            'insurance_summ' => $insurance_cost,
        );
        $regaddress_full = empty($contract_order->Regindex) ? '' : $contract_order->Regindex . ', ';
        $regaddress_full .= trim($contract_order->Regregion . ' ' . $contract_order->Regregion_shorttype);
        $regaddress_full .= empty($contract_order->Regcity) ? '' : trim(', ' . $contract_order->Regcity . ' ' . $contract_order->Regcity_shorttype);
        $regaddress_full .= empty($contract_order->Regdistrict) ? '' : trim(', ' . $contract_order->Regdistrict . ' ' . $contract_order->Regdistrict_shorttype);
        $regaddress_full .= empty($contract_order->Reglocality) ? '' : trim(', ' . $contract_order->Reglocality . ' ' . $contract_order->Reglocality_shorttype);
        $regaddress_full .= empty($contract_order->Regstreet) ? '' : trim(', ' . $contract_order->Regstreet . ' ' . $contract_order->Regstreet_shorttype);
        $regaddress_full .= empty($contract_order->Reghousing) ? '' : ', д.' . $contract_order->Reghousing;
        $regaddress_full .= empty($contract_order->Regbuilding) ? '' : ', стр.' . $contract_order->Regbuilding;
        $regaddress_full .= empty($contract_order->Regroom) ? '' : ', к.' . $contract_order->Regroom;

        $params['regaddress_full'] = $regaddress_full;

        if (!empty($contract->insurance_id)) {
            $params['insurance'] = $this->insurances->get_insurance($contract->insurance_id);
        }

        $params['user'] = $this->users->get_user($contract->user_id);
        $params['order'] = $this->orders->get_order($contract->order_id);
        $params['contract'] = $contract;


        $this->documents->create_document(array(
            'user_id' => $contract->user_id,
            'order_id' => $contract->order_id,
            'contract_id' => $contract->id,
            'type' => $document_type,
            'params' => $params,
        ));

    }

}

$cron = new IssuanceCron();
