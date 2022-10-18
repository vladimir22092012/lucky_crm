<?php

class Age_scoring extends Core
{
    private $user_id;
    private $order_id;
    private $audit_id;
    private $type;


    public function run_scoring($scoring_id)
    {
        $update = array();

        $scoring_type = $this->scorings->get_type('age');

        if ($scoring = $this->scorings->get_scoring($scoring_id))
        {
            if ($order = $this->orders->get_order((int)$scoring->order_id))
            {
                if (empty($order->birth))
                {
                    $update = array(
                        'status' => 'error',
                        'string_result' => 'в заявке не указан возраст'
                    );
                }
                else
                {
                    $d = date_diff(date_create(date('Y-m-d', strtotime($order->birth))), date_create(date('Y-m-d')));
                    $order->age = $d->format('%y');

                    $score = ($order->age >= $scoring_type->params['min_threshold_age']) &&
                             ($order->age < $scoring_type->params['max_threshold_age']);

                    $update = array(
                        'status' => 'completed',
                        'success' => $score
                    );
                    if ($score)
                        $update['string_result'] = 'Возраст удовлетворяет условиям';
                    else
                        $update['string_result'] = 'Возраст не удовлетворяет условиям';

                }

            }
            else
            {
                $update = array(
                    'status' => 'error',
                    'string_result' => 'не найдена заявка'
                );
            }

            if (!empty($update))
                $this->scorings->update_scoring($scoring_id, $update);

            return $update;
        }
        return null;
    }

}