<?php

set_time_limit(300);

class TestController extends Controller
{
    public function fetch()
    {

        $request =
            [
                'UserID'   => 'barvil',
                'Password' => 'KsetM+H5',
                'sources'  => 'whatsapp, getcontact',
                'PhoneReq' => [
                        'phone' => 79276928586
                    ]
            ];

        $request = $this->XMLSerializer->serialize($request);

        $ch = curl_init('https://i-sphere.ru/2.00/');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        $html = simplexml_load_string($html);
        $json = json_encode($html);
        $array = json_decode($json,TRUE);
        curl_close($ch);

        echo '<pre>';
        var_dump($array);
        exit;
    }
}