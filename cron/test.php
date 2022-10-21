<?php

error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('memory_limit', '1024M');

chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class test extends Core
{
    public function __construct()
    {
        parent::__construct();
        $this->import();
    }

    private function import()
    {
        $tmp_name = $this->config->root_dir . '/files/import.xlsx';
        $format = \PhpOffice\PhpSpreadsheet\IOFactory::identify($tmp_name);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($format);
        $spreadsheet = $reader->load($tmp_name);

        $active_sheet = $spreadsheet->getActiveSheet();

        $first_row = 5;
        $last_row = $active_sheet->getHighestRow();

        for ($row = $first_row; $row <= $last_row; $row++) {

            $birth = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($active_sheet->getCell('E' . $row)->getValue());
            $passport_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($active_sheet->getCell('AG' . $row)->getValue());
            $issuance_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($active_sheet->getCell('K' . $row)->getValue());
            $return_date   = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($active_sheet->getCell('L' . $row)->getValue());

            $regaddress  = $active_sheet->getCell('AB' . $row)->getValue();
            $faktaddress = $active_sheet->getCell('AA' . $row)->getValue();

            $fakt_id = $this->Addresses->add_address(['adressfull' => $faktaddress]);
            $reg_id  = $this->Addresses->add_address(['adressfull' => $regaddress]);

            $user = [
                'firstname' => ucfirst($active_sheet->getCell('C' . $row)->getValue()),
                'lastname' => ucfirst($active_sheet->getCell('B' . $row)->getValue()),
                'patronymic' => ucfirst($active_sheet->getCell('D' . $row)->getValue()),
                'phone_mobile' => preg_replace("/[^,.0-9]/", '', $active_sheet->getCell('I' . $row)->getValue()),
                'email' => $active_sheet->getCell('F' . $row)->getValue(),
                'birth' => date('d.m.Y', $birth),
                'passport_serial' => $active_sheet->getCell('AE' . $row)->getValue() . '-' . $active_sheet->getCell('AD' . $row)->getValue(),
                'passport_date' => date('d.m.Y', $passport_date),
                'passport_issued' => $active_sheet->getCell('AF' . $row)->getValue(),
                'snils' => $active_sheet->getCell('Y' . $row)->getValue(),
                'regaddress_id' => $reg_id,
                'faktaddress_id' => $fakt_id
            ];

            $userId = $this->users->add_user($user);

            $order = [
                'user_id' => $userId,
                'date' => date('Y-m-d H:i:s', $issuance_date),
                'period' => 30,
                'amount' => $active_sheet->getCell('P' . $row)->getValue(),
                'accept_date' => date('Y-m-d H:i:s', $issuance_date),
                'confirm_date' => date('Y-m-d H:i:s', $issuance_date),
                'status' => 5,
                'offline_point_id' => 0,
                'percent' => 1,
                'charge' => 1,
                'reject_reason' => ''
            ];

            $orderId = $this->orders->add_order($order);

            $new_contract =
                [
                    'order_id' => $orderId,
                    'user_id'  => $userId,
                    'number' => $active_sheet->getCell('J' . $row)->getValue(),
                    'type' => 'base',
                    'period' => 30,
                    'amount' => $active_sheet->getCell('P' . $row)->getValue(),
                    'status' => 4,
                    'create_date' => date('Y-m-d H:i:s', $issuance_date),
                    'inssuance_date' => date('Y-m-d H:i:s', $issuance_date),
                    'expired_days' => $active_sheet->getCell('U' . $row)->getValue(),
                    'return_date' => date('Y-m-d H:i:s', $return_date),
                    'loan_body_summ' => $active_sheet->getCell('Q' . $row)->getValue(),
                    'loan_percents_summ' => $active_sheet->getCell('R' . $row)->getValue(),
                    'loan_peni_summ' => $active_sheet->getCell('S' . $row)->getValue()
                ];

            $contractId = $this->contracts->add_contract($new_contract);

            $this->orders->update_order($orderId, ['contract_id' => $contractId]);
        }
    }

}

new test();