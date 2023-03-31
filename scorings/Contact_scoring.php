<?php

class Contact_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $scoring_type = $this->scorings->get_type('contact');
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
            'body' => ''
        );


        if (isset($request['Source']) && $request['Source']['ResultsCount'] > 0) {
            foreach ($request['Source'] as $source) {
                if(is_array($source) && array_key_exists('Field', $source)){
                    foreach ($source['Field'] as $field) {
                        if ($field['FieldName'] == 'Name')
                            $name = 'Имя: ' . $field['FieldValue'];

                        if ($field['FieldName'] == 'TagsCount') 
                        {
                            $tags = 'Количество тегов: ' . $field['FieldValue'];

                            if($field['FieldValue'] < $scoring_type->params['tegs_count'])
                                $update['success'] = 0;
                            else
                                $update['success'] = 1;
                        }
                    }
                }
            }
            $update['string_result'] = 'Клиент найден';
            $update['body'] = serialize(['name' => $name, 'tags' => $tags]);
        } else {
            $update['body'] = null;
            $update['success'] = 0;
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