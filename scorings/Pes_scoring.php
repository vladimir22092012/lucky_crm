<?php

class Pes_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $update = [];

        $scoring_type = $this->scorings->get_type('pes');

        if ($scoring = $this->scorings->get_scoring($scoring_id)) {
            if ($order = $this->orders->get_order((int)$scoring->order_id)) {
                if (
                    empty($order->lastname)
                    && empty($order->firstname)
                    && empty($order->patronymic)
                    && empty($order->birth)
                ) {
                    $update = array(
                        'status' => 'error',
                        'string_result' => 'в заявке не достаточно данных'
                    );
                } else {
                    $fields = [];
                    $fields['lastname'] = $order->lastname;
                    $fields['firstname'] = $order->firstname;
                    $fields['patronymic'] = $order->patronymic;
                    $fields['birth'] = $order->birth;

                    $score = $this->soap1c->is_signed_with_PES($fields);

                    $update = array(
                        'status' => 'completed',
                        'body' => $score,
                        'success' => (int) !$score
                    );

                    if (!$score)
                        $update['string_result'] = 'Не нашли ПЭП';
                    else
                        $update['string_result'] = 'Есть ПЭП';
                }
            } else {
                $update = array(
                    'status' => 'error',
                    'string_result' => 'не найдена заявка'
                );
            }

            if (!empty($update))
                $this->scorings->update_scoring($scoring_id, $update);

            return $update;
        }
    }
}
