<?php

class CallBot implements ApiInterface
{
    private static $params;

    public static function sendRequest($request)
    {
        // TODO: Implement sendRequest() method.
    }

    public static function curl($params)
    {
        $curl = curl_init();
        self::$params =
            [
                'apiKey'        => "HiyTXk4pKBiOdJ9K93C5zwOWhs9M5EepowzCZQBJNZDmopjK0rnHJOUU2ZCy",
                'phone'         => '99999999999',
                'outgoingPhone' => '99999999997',
                'record'        => [
                                     'text' => 'Текст для генерации аудиоролика'
                                                                                ]
            ];

        curl_setopt($curl, CURLOPT_URL, 'https://lk.zvonobot.ru/apiCalls/create');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(self::$params));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'accept: application/json'));
        $resp = curl_exec($curl);
        curl_close($curl);

        return self::response(json_decode($resp));
    }

    public static function response($response)
    {
        self::toLogs($response);
        return $response;
    }

    public static function toLogs($log)
    {
        $insert =
            [
                'className' => self::class,
                'log' => $log,
                'params' => json_encode(self::$params)
            ];

        LogsORM::insert($insert);
    }
}