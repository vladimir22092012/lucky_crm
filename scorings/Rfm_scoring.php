<?php

class Rfm_scoring extends Core
{
    private $user_id;
    private $order_id;
    private $audit_id;
    private $type;


    public function run_scoring($scoring_id)
    {
        $update = array();

        $scoring_type = $this->scorings->get_type('rfm');

        if ($scoring = $this->scorings->get_scoring($scoring_id))
        {
            if ($order = $this->orders->get_order((int)$scoring->order_id))
            {
                if (empty($order->lastname))
                {
                    $update = array(
                        'status' => 'error',
                        'string_result' => 'в заявке не указана фамилия'
                    );
                }
                elseif (empty($order->firstname))
                {
                    $update = array(
                        'status' => 'error',
                        'string_result' => 'в заявке не указано имя'
                    );
                }
                elseif (empty($order->patronymic))
                {
                    $update = array(
                        'status' => 'error',
                        'string_result' => 'в заявке не указано отчество'
                    );
                }
                elseif (empty($order->phone_mobile))
                {
                    $update = array(
                        'status' => 'error',
                        'string_result' => 'в заявке не указан телефон'
                    );
                }
                else
                {
                    $fio = $order->lastname.' '.$order->firstname.' '.$order->patronymic;
                    $score = $this->rfm->search($order->phone_mobile, $fio);

                    $update = array(
                        'status' => 'completed',
                        'body' => '',
                        'success' => empty($score) ? 1 : 0
                    );
                    if (!empty($score))
                    {
                        $person = $this->rfm->get_person((int)$score);
                        $update['body'] = serialize($person);
                        $update['string_result'] = 'Пользователь найден в списке: '.$person->fio.' '.$person->phone;
                    }
                    else
                        $update['string_result'] = 'Клиент не найден в списке';

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
    }


}