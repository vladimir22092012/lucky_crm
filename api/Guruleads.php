<?php

class Guruleads implements ApiInterface
{

    public static function sendRequest($request)
    {
        $orderId = $request['orderId'];
        $method  = $request['method'];

        self::$method($orderId);
        return 1;
    }

    public static function sendApprovePostback($orderId)
    {
        $order = OrdersORM::find($orderId);
        $click_id = $order->click_hash;
        $goal = 'loan';
        $status = 1;

        $link = "https://offers.guruleads.ru/postback?clickid=$click_id&goal=$goal&status=$status&action_id=$orderId";

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_exec($ch);
        curl_close($ch);

        $insert =
            [
                'order_id' => $orderId,
                'status'   => $status,
                'click_id' => $click_id,
                'goal'     => $goal,
                'link'     => $link
            ];

        Postbacks::insert($insert);

        return 1;
    }
}