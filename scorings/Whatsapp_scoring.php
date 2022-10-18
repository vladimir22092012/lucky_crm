<?php

class Whatsapp_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $order = $this->orders->get_order($scoring->order_id);
        $phone = preg_replace('/[^0-9]/', '', $order->phone_mobile);

        $params =
            [
                'UserID' => 'barvil',
                'Password' => 'KsetM+H5',
                'sources' => 'whatsapp',
                'PhoneReq' => [
                    'phone' => $phone
                ]
            ];

        $request = $this->send_request($params);

        $update = array(
            'status' => 'completed',
            'body' => '',
            'success' => !isset($request['Source']) ? 0 : 1
        );

        if (isset($request['Source'])) {
            if (isset($request['Source'])) {
                foreach ($request['Source'] as $source) {
                    foreach ($source['Field'] as $field) {
                        if ($field['FieldName'] == 'StatusText')
                            $update['array_result']['status'] = 'Статус: ' . $field['FieldValue'];

                        if ($field['FieldName'] == 'StatusDate')
                            $update['array_result']['statusDate'] = 'Дата установки статуса: ' . date('d.m.Y', strtotime($field['FieldValue']));

                        if ($field['FieldName'] == 'FullPhoto')
                            $update['array_result']['image'] = 'Ссылка на фото: ' . $field['FieldValue'];
                    }
                }
            }
        } else
            $update['string_result'] = 'Клиент не найден';


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