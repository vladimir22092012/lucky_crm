<?php

class Contact_scoring extends Core
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
                'sources' => 'getcontact',
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
            foreach ($request['Source'] as $source) {
                foreach ($source['Field'] as $field) {
                    if ($field['FieldName'] == 'Name')
                        $update['body']['status'] = 'Имя: ' . $field['FieldValue'];

                    if ($field['FieldName'] == 'TagsCount')
                        $update['body']['image'] = 'Количество тегов: ' . $field['FieldValue'];
                }
            }
            $update['string_result'] = 'Клиент найден';
            $update['body'] = serialize($update['body']);
        } else {
            $update['body'] = null;
            $update['string_result'] = 'Клиент не найден';
        }


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