<?php

class TestController extends Controller
{
    public function fetch(){
        $order = $this->orders->get_order(3534);

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

        echo '<pre>';
        var_dump($response);
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