<?php

class Adspire implements ApiInterface
{

    public static function sendRequest($order)
    {
        $key = $order->id;
        $id = '';

        $atm_marketing = '';
        $atm_remarketing = '';
        $atm_closer = '';

        if ($order->utm_content == 'marketing')
            $atm_marketing = $order->utm_content;

        if ($order->utm_content == 'remarketing')
            $atm_remarketing = $order->utm_content;

        if ($order->utm_content == 'closer')
            $atm_closer = $order->utm_content;

        $link = 'https://postback.adspire.io/event?key=' . $key . '&id=' . $id . '&atm_marketing=' . $atm_marketing . '&atm_remarketing=' . $atm_remarketing . '&atm_closer=' . $atm_closer;

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_exec($ch);
        curl_close($ch);

        $insert =
            [
                'order_id' => $order->id,
                'status' => 'issued',
                'link' => $link
            ];

        PostBacks::insert($insert);

        return 1;
    }
}