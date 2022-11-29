<?php

class TestController extends Controller
{
    public function fetch(){
        $order = $this->orders->get_order(3534);
        $phone = preg_replace('/[^0-9]/', '', $order->phone_mobile);

        $params =
            [
                'UserID' => 'barvil',
                'Password' => 'KsetM+H5',
                'sources' => 'viber, whatsapp',
                'PhoneReq' => [
                    'phone' => $phone
                ]
            ];

        $request = $this->send_request($params);

        echo '<pre>';
        var_dump($request);
        exit;
    }

    private function send_request($params)
    {
        $request = $this->XMLSerializer->serialize($params);

        $ch = curl_init('https://i-sphere.ru/2.00/');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        $html = simplexml_load_string($html);
        $json = json_encode($html);
        $array = json_decode($json, TRUE);
        curl_close($ch);

        return $array;
    }
}