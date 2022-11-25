<?php

class TestController extends Controller
{
    public function fetch()
    {
        $order = $this->orders->get_order(3167);
        $phone = preg_replace('/[^0-9]/', '', $order->phone_mobile);

        $params =
            [
                'UserID' => 'barvil',
                'Password' => 'KsetM+H5',
                'sources' => 'viber, whatsapp',
                'PhoneReq' => [
                    'phone' => '79966208002'
                ]
            ];

        $request = $this->send_request($params);

        $update = array(
            'status' => 'completed',
            'body' => 'null',
            'string_result' => ''
        );

        if (isset($request['Source'])) {
            $viber = $request['Source'][1];
            $whatsApp = $request['Source'][0];

            if ($viber['ResultsCount'] == 0)
                $update['string_result'] .= 'Viber: Клиент не найден';
            else {
                foreach ($viber['Record'] as $records)
                    foreach ($records as $record)
                        if ($record['FieldName'] == 'name')
                            $update['string_result'] .= 'Viber Имя: ' . $record['FieldValue'];
            }

            if ($whatsApp['ResultsCount'] == 0)
                $update['string_result'] .= '<br>Whatsapp: Клиент не найден';
            else {
                foreach ($whatsApp['Record'] as $records)
                    foreach ($records as $record) {
                        if ($record['FieldName'] == 'StatusText')
                            $update['string_result'] .= '<br>WhatsApp Статус: ' . $record['FieldValue'];

                        if ($record['FieldName'] == 'StatusDate')
                            $update['string_result'] .= '<br>WhatsApp Дата установки статуса: ' . date('d.m.Y', strtotime($record['FieldValue']));

                        if ($record['FieldName'] == 'FullPhoto')
                            $update['string_result'] .= '<br>WhatsApp Ссылка на фото: <a href='.$record['FieldValue'].'></a>';

                        if ($record['FieldName'] == 'AvatarHidden')
                            $update['string_result'] .= '<br>WhatsApp Ссылка на фото: Аватар скрыт';

                        if ($record['FieldName'] == 'StatusHidden')
                            $update['string_result'] .= '<br>WhatsApp Статус: Скрыт';
                    }
            }
        } else {
            $update['body'] = null;
            $update['string_result'] = 'Отсутствуют мессенджеры';
        }

        echo '<pre>';
        var_dump($update);
        //var_dump($viber);
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