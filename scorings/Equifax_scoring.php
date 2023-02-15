<?php

class Equifax_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $order = $this->orders->get_order($scoring->order_id);

        $passport_serial = explode('-', $order->passport_serial);

        foreach ($passport_serial as $serial => $value) {
            if (strlen($value) == 4)
                $passportSerial = $value;
            else
                $passportNumber = $value;
        }

        $regAddress = $this->Addresses->get_address($order->regaddress_id);
        $regAddress = $regAddress->adressfull;

        $faktAddress = $this->Addresses->get_address($order->faktaddress_id);
        $faktAddress = $faktAddress->adressfull;

        $params =
            [
                "last" => $order->lastname,
                "first" => $order->firstname,
                "middle" => $order->patronymic,
                "birthday" => date('d.m.Y', strtotime($order->birth)),
                "birthplace" => 'Россия',
                'gender' => 'неизвестно',
                "snils" => $order->snils,
                "reason" => "Контроль данных",
                "transfer" => "правоприемник",
                "period" => "на весь срок",
                "adm_inform" => "проинформирован",
                "doc" => [
                    "country" => "Россия",
                    "type" => "паспорт РФ",
                    "serial" => $passportSerial,
                    "number" => $passportNumber,
                    "date" => date('d.m.Y', strtotime($order->passport_date)),
                    "who" => $order->passport_issued
                ],
                "addr_reg" => [
                    "addr_total" => $regAddress
                ],
                "addr_fact" => [
                    "addr_total" => $faktAddress
                ]
            ];

        $response = $this->send_request($params);

        if ($response['history'] == false) {
            $update = [
                'status' => 'completed',
                'body' => null,
                'string_result' => 'Кредитная история клиента не найдена',
                'success' => 0
            ];
        } elseif ($response == null) {
            $update = [
                'status' => 'error',
                'body' => null,
                'string_result' => 'Ошибка скоринга',
                'success' => 0
            ];

        } else {

            if ($response['bkiscoring'] < 450)
                $reason = 'bkiscoring';

            $user = UsersORM::find($order->user_id);

            $pdn = round(($response['all_payment_active_credit_month'] / $user->income) * 100, 3);

            UsersORM::where('id', $user->id)->update(['pdn' => $pdn]);

            if(empty($reason))
            {
                if (in_array($order->client_status, ['nk', 'rep'])) {
                    if ($response['bkicountactivecredit'] >= 1 && $response['bkicountactivecredit'] <= 5)
                        $limit = 11000;
                    elseif ($response['bkicountactivecredit'] >= 6 && $response['bkicountactivecredit'] <= 10)
                        $limit = 9000;
                    elseif ($response['bkicountactivecredit'] >= 11 && $response['bkicountactivecredit'] <= 29)
                        $limit = 6000;
                    elseif ($response['bkicountactivecredit'] >= 30)
                        $reason = 'Отказ в лимите';
                    else
                        $reason = 'Отказ в лимите';
                } else {
                    $this->db->query("
                SELECT count(*) as `count`
                from s_contracts
                where user_id = ?
                and `status` = 3
                ", $order->user_id);

                    $countContracts = $this->db->result('count');

                    $this->db->query("
                SELECT *
                from s_contracts
                where user_id = ?
                and `status` = 3
                order by id desc
                limit 1
                ", $order->user_id);

                    $lastContract = $this->db->result();

                    $issuanceDate = new DateTime(date('Y-m-d', strtotime($lastContract->inssuance_date)));
                    $returnDate = new DateTime(date('Y-m-d', strtotime($lastContract->return_date)));

                    if ($countContracts >= 2) {
                        if (date_diff($issuanceDate, $returnDate)->days >= 35)
                            $limit = $lastContract->amount + 3000;
                        elseif (date_diff($issuanceDate, $returnDate)->days >= 15 && date_diff($issuanceDate, $returnDate)->days < 35)
                            $limit = $lastContract->amount + 1000;
                        elseif (date_diff($issuanceDate, $returnDate)->days >= 10 && date_diff($issuanceDate, $returnDate)->days < 15)
                            $limit = $lastContract->amount;
                        else
                            $reason = 'Отказ в лимите';
                    } else {
                        if (date_diff($issuanceDate, $returnDate)->days > 10)
                            $limit = $lastContract->amount;
                        else
                            $reason = 'Отказ в лимите';
                    }
                }
            }

            $update = [
                'status' => 'completed',
                'body' => json_encode($response),
                'string_result' => (isset($reason)) ? 'Отказ по переменной ' . $reason : 'Одобренный лимит: ' . $limit,
                'success' => (isset($reason)) ? 0 : 1
            ];
        }

        $this->scorings->update_scoring($scoring_id, $update);
        exit;
    }

    private function send_request($params)
    {
        $headers =
            [
                'Content-Type: application/json'
            ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://51.250.97.26/scoring/user/info',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 40,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_CUSTOMREQUEST => 'PUT'
        ]);


        $resp = curl_exec($curl);
        curl_close($curl);
        $resp = json_decode($resp, true);

        return $resp;
    }
}