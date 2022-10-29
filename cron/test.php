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
        $this->import_contracts();
    }

    private function import_contracts()
    {
        $tmp_name = $this->config->root_dir . '/files/contracts.xlsx';
        $format = IOFactory::identify($tmp_name);
        $reader = IOFactory::createReader($format);
        $spreadsheet = $reader->load($tmp_name);

        $active_sheet = $spreadsheet->getActiveSheet();

        $first_row = 5;
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
}

new test();