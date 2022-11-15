<?php

class TestController extends Controller
{
    public function fetch()
    {
<<<<<<< HEAD
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
=======
        $scoring_types = $this->scorings->get_types();
        foreach ($scoring_types as $scoring_type)
        {
            if ($scoring_type->active && empty($scoring_type->is_paid))
            {
                $add_scoring = array(
                    'user_id' => 684,
                    'order_id' => 683,
                    'type' => $scoring_type->name,
                    'status' => 'new',
                    'created' => date('Y-m-d H:i:s')
                );

                $this->scorings->add_scoring($add_scoring);
>>>>>>> e48f334e4354912d016fec678709bbdc00a26ada
            }
        }
    }
}