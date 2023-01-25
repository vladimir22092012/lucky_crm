<?php

error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('memory_limit', '1024M');

chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class test extends Core
{

    public function __construct()
    {
        parent::__construct();
        $this->sendOnec();
    }

    private function import_clients()
    {
        $tmp_name = $this->config->root_dir . '/files/reestr.xlsx';
        $format = IOFactory::identify($tmp_name);
        $reader = IOFactory::createReader($format);
        $spreadsheet = $reader->load($tmp_name);

        $active_sheet = $spreadsheet->getActiveSheet();

        $first_row = 3;
        $last_row = $active_sheet->getHighestRow();

        for ($row = $first_row; $row <= $last_row; $row++) {

            $lastname = $active_sheet->getCell('B' . $row)->getValue();
            $firstname = $active_sheet->getCell('C' . $row)->getValue();
            $patronymic = $active_sheet->getCell('D' . $row)->getValue();

            if (empty($lastname))
                continue;

            $birth = $active_sheet->getCell('E' . $row)->getFormattedValue();
            $passport_date = $active_sheet->getCell('AE' . $row)->getFormattedValue();

            $regaddress = $Faktroom = $active_sheet->getCell('V' . $row)->getValue();
            $faktaddress = $Faktroom = $active_sheet->getCell('W' . $row)->getValue();

            $reg_id = $this->Addresses->add_address(['adressfull' => $regaddress]);
            $fakt_id = $this->Addresses->add_address(['adressfull' => $faktaddress]);

            $phone = preg_replace("/[^,.0-9]/", '', $active_sheet->getCell('H' . $row)->getValue());
            $phone = str_split($phone);
            $phone[0] = '7';
            $phone = implode('', $phone);

            $user =
                [
                    'firstname' => ucfirst($firstname),
                    'lastname' => ucfirst($lastname),
                    'patronymic' => ucfirst($patronymic),
                    'phone_mobile' => $phone,
                    'email' => $active_sheet->getCell('F' . $row)->getValue(),
                    'birth' => date('d.m.Y', strtotime($birth)),
                    'birth_place' => $active_sheet->getCell('AC' . $row)->getValue(),
                    'passport_serial' => $active_sheet->getCell('X' . $row)->getValue() . '-' . $active_sheet->getCell('Y' . $row)->getValue(),
                    'passport_date' => date('d.m.Y', strtotime($passport_date)),
                    'passport_issued' => $active_sheet->getCell('Z' . $row)->getValue(),
                    'subdivision_code' => $active_sheet->getCell('AA' . $row)->getValue(),
                    'snils' => $active_sheet->getCell('U' . $row)->getValue(),
                    'workphone' => $active_sheet->getCell('G' . $row)->getValue(),
                    'regaddress_id' => $reg_id,
                    'faktaddress_id' => $fakt_id,
                    'created' => date('Y-m-d H:i:s'),
                    'stage_personal' => 1,
                    'stage_passport' => 1,
                    'stage_address' => 1,
                    'stage_work' => 1,
                    'stage_files' => 1,
                    'stage_card' => 1
                ];

            $userId = $this->users->add_user($user);

            $issuance_date = $active_sheet->getCell('J' . $row)->getFormattedValue();
            $returnDate = $active_sheet->getCell('K' . $row)->getFormattedValue();

            $new_order = [
                'date' => date('Y-m-d H:i:s', strtotime($issuance_date)),
                'user_id' => $userId,
                'period' => 30,
                'amount' => $active_sheet->getCell('N' . $row)->getValue(),
                'accept_date' => date('Y-m-d H:i:s', strtotime($issuance_date)),
                'confirm_date' => date('Y-m-d H:i:s', strtotime($issuance_date)),
                'status' => 5,
                'percent' => 1
            ];

            $orderId = $this->orders->add_order($new_order);

            $new_contract =
                [
                    'user_id' => $userId,
                    'order_id' => $orderId,
                    'number' => $active_sheet->getCell('I' . $row)->getValue(),
                    'type' => 'base',
                    'period' => 30,
                    'base_percent' => 1,
                    'amount' => $active_sheet->getCell('N' . $row)->getValue(),
                    'status' => 4,
                    'expired_days' => $active_sheet->getCell('S' . $row)->getValue(),
                    'create_date' => $issuance_date,
                    'inssuance_date' => date('Y-m-d H:i:s', strtotime($issuance_date)),
                    'return_date' => date('Y-m-d', strtotime($returnDate)),
                    'loan_body_summ' => $active_sheet->getCell('O' . $row)->getValue(),
                    'loan_percents_summ' => $active_sheet->getCell('P' . $row)->getValue(),
                    'loan_peni_summ' => $active_sheet->getCell('Q' . $row)->getValue(),
                ];

            $contractId = $this->contracts->add_contract($new_contract);
            $this->orders->update_order($orderId, ['contract_id' => $contractId]);

            /*

            $percents_summ = round(($new_contract['loan_body_summ'] / 100 * $new_contract['base_percent']) * 5, 2);

            $this->contracts->update_contract($contractId, array(
                'loan_percents_summ' => $new_contract['loan_percents_summ'] + $percents_summ
            ));


            $this->operations->add_operation(array(
                'contract_id' => $contractId,
                'user_id' => $userId,
                'order_id' => $orderId,
                'type' => 'PERCENTS',
                'amount' => $percents_summ,
                'created' => date('Y-m-d H:i:s'),
                'loan_body_summ' => $new_contract['loan_body_summ'],
                'loan_percents_summ' => $new_contract['loan_percents_summ'] + $percents_summ,
                'loan_peni_summ' => $new_contract['loan_peni_summ']
            ));

            */
        }
    }

    private function import_orders()
    {
        $tmp_name = $this->config->root_dir . '/files/orders.xlsx';
        $format = IOFactory::identify($tmp_name);
        $reader = IOFactory::createReader($format);
        $spreadsheet = $reader->load($tmp_name);

        $active_sheet = $spreadsheet->getActiveSheet();

        $first_row = 5;
        $last_row = $active_sheet->getHighestRow();

        for ($row = $first_row; $row <= $last_row; $row++) {

            $id = $active_sheet->getCell('D' . $row)->getValue();

            if (empty($id))
                continue;

            $created = $active_sheet->getCell('A' . $row)->getFormattedValue();
            $created = date('Y-m-d H:i:s', strtotime($created));

            $reject_reason = '';

            if ($active_sheet->getCell('I' . $row)->getValue() === 'Отказ') {
                $reject_reason = $active_sheet->getCell('N' . $row)->getValue();
                $status = 3;
            }

            if (in_array($active_sheet->getCell('I' . $row)->getFormattedValue(), ['Выдан', 'В суде', 'Отправлена претензия', 'Передан на судебную стадию', "Подписан (дистанционно)", "Получен исполнительный лист", "У коллектора"]))
                $status = 5;

            if ($active_sheet->getCell('I' . $row)->getValue() === 'На рассмотрении')
                $status = 1;

            if ($active_sheet->getCell('I' . $row)->getValue() === 'Оплачен' || $active_sheet->getCell('I' . $row)->getValue() === 'Списан')
                $status = 7;

            if ($active_sheet->getCell('I' . $row)->getValue() === 'Отменен')
                $status = 8;

            if ($active_sheet->getCell('I' . $row)->getValue() === 'Одобрен' || $active_sheet->getCell('I' . $row)->getValue() === 'Одобрен предварительно')
                $status = 2;


            if ($active_sheet->getCell('Q' . $row)->getValue() === 'ONLINE-0,5!')
                $loantype_id = 2;
            elseif ($active_sheet->getCell('Q' . $row)->getValue() === 'ВСЕМ-0,9!')
                $loantype_id = 3;
            else
                $loantype_id = 1;

            $loantype = $this->Loantypes->get_loantype($loantype_id);


            $new_order = [
                'outer_id' => $id,
                'date' => $created,
                'loantype_id' => $loantype_id,
                'period' => 30,
                'amount' => $active_sheet->getCell('G' . $row)->getValue(),
                'accept_date' => $created,
                'confirm_date' => $created,
                'status' => $status,
                'percent' => $loantype->percent,
                'reject_reason' => $reject_reason
            ];

            $order_id = $this->orders->add_order($new_order);

            $this->db->query("
                SELECT *
                FROM s_users
                where outer_id = ?
                ", $active_sheet->getCell('O' . $row)->getValue());

            $user = $this->db->result();

            if (!empty($user))
                $this->orders->update_order($order_id, ['user_id' => $user->id]);

        }
        exit;
    }

    private function import_contracts()
    {
        $tmp_name = $this->config->root_dir . '/files/contracts.xlsx';
        $format = IOFactory::identify($tmp_name);
        $reader = IOFactory::createReader($format);
        $spreadsheet = $reader->load($tmp_name);

        $active_sheet = $spreadsheet->getActiveSheet();

        $first_row = 2;
        $last_row = $active_sheet->getHighestRow();

        for ($row = $first_row; $row <= $last_row; $row++) {

            $created = $active_sheet->getCell('B' . $row)->getFormattedValue();
            $created = date('Y-m-d H:i:s', strtotime($created));

            $issuance_date = $active_sheet->getCell('C' . $row)->getFormattedValue();
            $issuance_date = date('Y-m-d H:i:s', strtotime($issuance_date));

            $return_date = $active_sheet->getCell('E' . $row)->getFormattedValue();
            $return_date = date('Y-m-d', strtotime($return_date));

            $new_contract =
                [
                    'number' => $active_sheet->getCell('A' . $row)->getValue(),
                    'type' => 'base',
                    'period' => 30,
                    'uid' => $active_sheet->getCell('K' . $row)->getValue(),
                    'amount' => $active_sheet->getCell('F' . $row)->getValue(),
                    'status' => 0,
                    'create_date' => $created,
                    'inssuance_date' => $issuance_date,
                    'return_date' => $return_date
                ];

            $contract_id = $this->contracts->add_contract($new_contract);

            $this->db->query("
                SELECT *
                FROM s_users
                where outer_id = ?
                ", $active_sheet->getCell('N' . $row)->getValue());

            $user = $this->db->result();

            if (!empty($user))
                $this->contracts->update_contract($contract_id, ['user_id' => $user->id]);

            $this->db->query("
                SELECT *
                FROM s_orders
                where outer_id = ?
                ", $active_sheet->getCell('M' . $row)->getValue());

            $order = $this->db->result();

            $loantype = $this->Loantypes->get_loantype($order->loantype_id);
            $percent = $loantype->percent;

            $statuses = array(
                1 => 0,
                3 => 8,
                5 => 2,
                7 => 3,
                8 => 8
            );

            $new_contract =
                [
                    'order_id' => $order->id,
                    'base_percent' => $percent,
                    'status' => $statuses[$order->status]
                ];

            $this->contracts->update_contract($contract_id, $new_contract);
            $this->orders->update_order($order->id, ['contract_id' => $contract_id]);
        }
    }

    private function correct_balances()
    {
        $tmp_name = $this->config->root_dir . '/files/clients.xlsx';
        $format = IOFactory::identify($tmp_name);
        $reader = IOFactory::createReader($format);
        $spreadsheet = $reader->load($tmp_name);

        $active_sheet = $spreadsheet->getActiveSheet();

        $first_row = 5;
        $last_row = $active_sheet->getHighestRow();

        for ($row = $first_row; $row <= $last_row; $row++) {

            $lastname = $active_sheet->getCell('B' . $row)->getValue();
            $firstname = $active_sheet->getCell('C' . $row)->getValue();
            $patronymic = $active_sheet->getCell('D' . $row)->getValue();

            if (empty($lastname))
                continue;

            $this->db->query("
            SELECT id
            FROM s_users
            where lastname = ?
            and firstname = ?
            and patronymic = ?
            ", $lastname, $firstname, $patronymic);

            $userId = $this->db->result('id');

            $this->db->query("
            SELECT *
            FROM s_contracts
            where user_id = ?
            ", $userId);

            $contract = $this->db->result();

            $percents = $active_sheet->getCell('R' . $row)->getValue();

            $percents_summ = round(($contract->loan_body_summ / 100 * $contract->base_percent) * 12, 2);

            $this->contracts->update_contract($contract->id, array(
                'loan_percents_summ' => $percents + $percents_summ
            ));


            $this->operations->add_operation(array(
                'contract_id' => $contract->id,
                'user_id' => $contract->user_id,
                'order_id' => $contract->order_id,
                'type' => 'PERCENTS',
                'amount' => $percents_summ,
                'created' => date('Y-m-d H:i:s'),
                'loan_body_summ' => $contract->loan_body_summ,
                'loan_percents_summ' => $percents + $percents_summ,
                'loan_charge_summ' => $contract->loan_charge_summ,
                'loan_peni_summ' => $contract->loan_peni_summ,
            ));
        }
    }

    private function sendOnec()
    {
        $contracts = ContractsORM::where('sent_status', 0)->get();

        foreach ($contracts as $contract) {
            $result = Onec::sendRequest($contract->order_id);
            ContractsORM::where('id', $contract->id)->update(['sent_date' => date('Y-m-d H:i:s'), 'sent_status' => $result]);
        }
    }
}

new test();