<?php

class Efrsb_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $order = $this->orders->get_order($scoring->order_id);

        $params =
            [
                'UserID' => 'barvil',
                'Password' => 'KsetM+H5',
                'sources' => 'bankrot',
                'PersonReq' => [
                    'first' => $order->firstname,
                    'middle' => $order->patronymic,
                    'paternal' => $order->lastname,
                    'birthDt' => date('Y-m-d', strtotime($order->birth))
                ],
                'driver_number' => $order->passport_serial
            ];

        $request = $this->send_request($params);

        $update = array(
            'status' => 'completed',
            'success' => (isset($request['Source']) && $request['Source']['ResultsCount'] > 0) ? 1 : 0,
            'body' => null,
            'string_result' => (isset($request['Source']) && $request['Source']['ResultsCount'] > 0) ? 'Банкротства не найдены' : 'Найдены банкротства',
        );


        $this->scorings->update_scoring($scoring_id, $update);

        return $update;
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