<?php

class CallBot implements ApiInterface
{
    protected static $apiKey = "HiyTXk4pKBiOdJ9K93C5zwOWhs9M5EepowzCZQBJNZDmopjK0rnHJOUU2ZCy";

    public static function sendRequest($data)
    {
        $order = OrdersORM::find($data->orderId);
        $user = UsersORM::find($order->user_id);
        $contract = ContractsORM::where('order_id', $order->id)->first();

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

        $resp = json_decode($resp, true);

        //self::getInfo($resp['data'][0]['id'], $contract->id);

        return 1;
    }

    public static function getInfo($id, $contractId)
    {
        usleep(30000000);

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

            if (date_diff($answeredAt, $finishedAt)->s >= 6) {
                $api_code = 'CEC47EEB-DA21-5CDB-9431-7E53B513FAA5';

                $callBotSettings = CallBotSettingsORM::find(1);

                $code = '';

                $chars = str_split($contractId);

                for ($i = 0; $i < count($chars); $i++)
                    $code .= self::$c2o_codes[$i][$chars[$i]];

                $shortLink = 'https://mkk-barvil.ru/p/' . $code;

                $message = $callBotSettings->textSms;
                $message .= ' ' . $shortLink;

                $smsru = new SMSRU($api_code);

                $data = new stdClass();
                $data->to = $resp['data'][0]['calls'][0]['phone'];
                $data->text = $message;

                $sms = $smsru->send_one($data);

                $insert =
                    [
                        'className' => self::class,
                        'log' => json_encode($sms),
                        'params' => $message
                    ];

                LogsORM::insert($insert);
            }
        }

        return $resp;
    }
}