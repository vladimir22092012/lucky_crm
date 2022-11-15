<?php

class TestController extends Controller
{
    public function fetch()
    {
        $scoring = $this->scorings->get_scoring(23);
        $order = $this->orders->get_order($scoring->order_id);

        $params =
            [
                'UserID' => 'barvil',
                'Password' => 'KsetM+H5',
                'sources' => 'viber',
                'PhoneReq' => [
                    'phone' => '79276928586'
                ]
            ];

        $request = $this->send_request($params);

        if (!empty($request))
            $update = ['status' => 'completed'];
        else {
            $update = [
                'status' => 'error',
                'body' => null,
                'string_result' => 'Клиент не найден'
            ];

            $this->scorings->update_scoring(23, $update);
            return $update;
        }

        $expSum = 0;
        $badArticle = [];

        if ($request['Source']['ResultsCount'] > 0) {
            foreach ($request['Source']['Record'] as $source) {
                foreach ($source['Field'] as $field) {
                    if ($field['FieldName'] == 'Total')
                        $expSum += $field['FieldValue'];

                    if ($field['FieldName'] == 'CloseReason1' && in_array($field['FieldValue'], [46, 47]))
                        $badArticle[] = $field['FieldValue'];
                }
            }

            $maxExp = $this->scorings->get_type(3);
            $maxExp = $maxExp->params;
            $maxExp = $maxExp['amount'];

            if ($expSum > $maxExp || !empty($badArticle)) {
                $update['body']['amount'] = $expSum;

                if (!empty($badArticle)) {
                    $update['body']['badArticles'] = implode(',', $badArticle);
                    $update['body']['badArticles'] = 'Обнаружены статьи: ' . $update['body']['badArticles'];
                }

                $update['success'] = 0;
                $update['string_result'] = 'Клиент найден';
                $update['body'] = serialize($update['body']);
            } else {
                $update['body'] = null;
                $update['success'] = 1;
                $update['string_result'] = 'Сумма долга: ' . $expSum;
            }
        } else {
            $update['body'] = null;
            $update['success'] = 1;
            $update['string_result'] = 'Долгов нет';
        }

        $this->scorings->update_scoring(23, $update);

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