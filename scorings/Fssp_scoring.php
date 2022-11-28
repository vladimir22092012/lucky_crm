<?php

class Fssp_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $order = $this->orders->get_order($scoring->order_id);

        $params =
            [
                'UserID' => 'barvil',
                'Password' => 'KsetM+H5',
                'sources' => 'fssp',
                'PersonReq' => [
                    'first' => $order->firstname,
                    'middle' => $order->patronymic,
                    'paternal' => $order->lastname,
                    'birthDt' => date('Y-m-d', strtotime($order->birth))
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

            $this->scorings->update_scoring($scoring_id, $update);
            return $update;
        }

        $expSum = 0;
        $badArticle = [];

        if ($request['Source']['ResultsCount'] > 0) {
            foreach ($request['Source']['Record'] as $source) {
                foreach ($source as $key => $fields) {
                    foreach ($fields as $field)
                    {
                        if ($field['FieldName'] == 'Total')
                            $expSum += $field['FieldValue'];

                        if ($field['FieldName'] == 'CloseReason1' && in_array($field['FieldValue'], [46, 47]))
                            $badArticle[] = $field['FieldValue'];
                    }
                }
            }

            $maxExp = $this->scorings->get_type(3);
            $maxExp = $maxExp->params;

            if(in_array($order->status, ['nk', 'rep']))
                $maxExp = $maxExp['amount_nk'];
            else
                $maxExp = $maxExp['amount'];

            if ($expSum > 0)
                $update['string_result'] = 'Сумма долга: ' . $expSum;
            else
                $update['string_result'] = 'Долгов нет';

            $update['body'] = null;

            if ($expSum > $maxExp || !empty($badArticle)) {

                if (!empty($badArticle)) {
                    $articles = implode(',', $badArticle);
                    $update['string_result'] .= '<br>Обнаружены статьи: ' . $articles;
                }

                $update['success'] = 0;
            } else {
                $update['success'] = 1;
            }
        } else {
            $update['success'] = 1;
            $update['string_result'] = 'Долгов нет';
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