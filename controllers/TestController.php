<?php

class TestController extends Controller
{
    public function fetch()
    {
        $order = $this->orders->get_order(20);
        list($passportSerial, $passportNumber) = explode('-', $order->passport_serial);

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
                    "serial" => $passportNumber,
                    "number" => $passportSerial,
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

            $reject = 0;

            if(in_array($order->client_status, ['nk', 'rep']))
            {
                if($response['credit_count_active_overdue_11_12_13_sum_1000'] > 3)
                    $reject = 1;

                if($response['credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60'] >= 1)
                {
                    if($response['credit_count_active_overdue_11_12_13_sum_1000'] > 2)
                        $reject = 1;
                    if($response['credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60'] > 2)
                        $reject = 1;
                    if($response['credit_avg_paid_for_type_19_days_90'] < 3000)
                        $reject = 1;
                    if($response['credit_count_delay_5'] < 5)
                        $reject = 1;
                }
                if($response['creditsCreatedlast7day'] == 0)
                {
                    if($response['credit_count_active_overdue_11_12_13_sum_1000'] > 2)
                        $reject = 1;
                    if($response['credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60'] > 2)
                        $reject = 1;
                    if($response['credit_avg_paid_for_type_19_days_90'] < 3000)
                        $reject = 1;
                    if($response['bkicountactivecredit'] > 25)
                        $reject = 1;
                    if($response['interestForLastMonth'] > 21)
                        $reject = 1;
                }
                if($response['bkicountactivecredit'] > 22)
                {
                    if($response['creditsCreatedlast7day'] == 0)
                        $reject = 1;
                    if($response['bkiscoring'] < 550 || $response['bkiscoring'] > 690)
                        $reject = 1;
                    if($response['interestForLastMonth'] > 20)
                        $reject = 1;
                    if($response['credit_prolongation_count_contracts_with_age_180_type_19'] < 2)
                        $reject = 1;
                    if($response['credit_avg_paid_for_type_19_days_90'] > 10000)
                        $reject = 1;
                }

                if($reject == 0)
                {
                    if($response['bkicountactivecredit'] >= 1 && $response['bkicountactivecredit'] <= 5)
                        $limit = 11000;
                    elseif($response['bkicountactivecredit'] >= 6 && $response['bkicountactivecredit'] <= 10)
                        $limit = 9000;
                    elseif($response['bkicountactivecredit'] >= 11 && $response['bkicountactivecredit'] <= 29)
                        $limit = 6000;
                    elseif($response['bkicountactivecredit'] >= 30)
                        $reject = 1;
                    else
                        $limit = 'Нет лимита';
                }else
                {
                    $limit = 'Отказано в лимите';
                }

            }else{
                if($response['credit_count_active_overdue_11_12_13_sum_1000'] > 3)
                    $reject = 1;

                if($response['credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60'] >= 1)
                {
                    if($response['credit_count_active_overdue_11_12_13_sum_1000'] > 2)
                        $reject = 1;
                    if($response['credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60'] > 2)
                        $reject = 1;
                    if($response['credit_avg_paid_for_type_19_days_90'] < 3000)
                        $reject = 1;
                    if($response['credit_count_delay_5'] < 5)
                        $reject = 1;
                }
                if($response['creditsCreatedlast7day'] == 0)
                {
                    if($response['credit_count_active_overdue_11_12_13_sum_1000'] > 2)
                        $reject = 1;
                    if($response['credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60'] >= 1)
                        $reject = 1;
                    if($response['credit_avg_paid_for_type_19_days_90'] < 4000)
                        $reject = 1;
                    if($response['bkicountactivecredit'] > 25)
                        $reject = 1;
                    if($response['interestForLastMonth'] > 21)
                        $reject = 1;
                }
                if($response['bkicountactivecredit'] > 22)
                {
                    if($response['creditsCreatedlast7day'] == 0)
                        $reject = 1;
                    if($response['bkiscoring'] < 550 || $response['bkiscoring'] > 690)
                        $reject = 1;
                    if($response['interestForLastMonth'] > 20)
                        $reject = 1;
                    if($response['credit_prolongation_count_contracts_with_age_180_type_19'] < 2)
                        $reject = 1;
                    if($response['credit_avg_paid_for_type_19_days_90'] > 10000)
                        $reject = 1;
                }

                $this->db->query("
                SELECT count(*) as `count`
                from s_contracts
                where user_id = ?
                and `status` = 3
                ");

                $countContracts = $this->db->results('count');

                $this->db->query("
                SELECT *
                from s_contracts
                where user_id = ?
                and `status` = 3
                order by id desc
                limit 1
                ");

                $lastContract = $this->db->result();

                $issuanceDate = new DateTime(date('Y-m-d', strtotime($lastContract->inssuance_date)));
                $returnDate = new DateTime(date('Y-m-d', strtotime($lastContract->return_date)));

                if($countContracts >= 2)
                {
                    if(date_diff($issuanceDate, $returnDate) >= 21)
                        $limit = $lastContract->amount + 6000;
                }else
                {
                    if(date_diff($issuanceDate, $returnDate) >= 6 && date_diff($issuanceDate, $returnDate) <= 14)
                        $limit = $lastContract->amount + 2000;

                    if(date_diff($issuanceDate, $returnDate) >= 15 && date_diff($issuanceDate, $returnDate) < 21)
                        $limit = $lastContract->amount + 4000;
                }


            }

            var_dump($limit);
            var_dump($reject);
            exit;
        }

        //$this->scorings->update_scoring($scoring_id, $update);
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