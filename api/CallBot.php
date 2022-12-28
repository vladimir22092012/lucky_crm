<?php

class CallBot implements ApiInterface
{
    protected static $apiKey = "HiyTXk4pKBiOdJ9K93C5zwOWhs9M5EepowzCZQBJNZDmopjK0rnHJOUU2ZCy";

    public static function sendRequest($data)
    {
        $order = OrdersORM::find($data->orderId);
        $user = UsersORM::find($order->user_id);

        $curl = curl_init();

        $params =
            [
                'apiKey' => self::$apiKey,
                'phone' => $user->phone_mobile,
                'outgoingPhone' => '78126042878',
                'record' => [
                    'text' => $data->text
                ]
            ];

        curl_setopt($curl, CURLOPT_URL, 'https://lk.zvonobot.ru/apiCalls/create');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'accept: application/json'));
        $resp = curl_exec($curl);
        curl_close($curl);

        $insert =
            [
                'className' => self::class,
                'log' => $resp,
                'params' => json_encode($params)
            ];

        LogsORM::insert($insert);

        $insert =
            [
                'userId' => $order->user_id,
                'orderId' => $order->id,
                'text' => $data->text,
                'resp' => $resp,
                'status' => 'sent'
            ];

        CallBotCronORM::insert($insert);

        return 1;
    }

    public static function getInfo($id)
    {
        $requestArray = array(
            'apiKey' => self::$apiKey
        );

        $json = json_encode($requestArray);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://lk.zvonobot.ru/apiCalls/get?apiCallIdList[]=' . $id);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'accept: application/json'));
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resp = curl_exec($curl);
        $resp = json_decode($resp, true);
        curl_close($curl);

        if ($resp['status'] == 'success') {
            $answeredAt = new DateTime(date("H:i:s", $resp['data'][0]['calls'][0]['answeredAt']));
            $finishedAt = new DateTime(date("H:i:s", $resp['data'][0]['calls'][0]['finishedAt']));
        }

        return 1;
    }
}