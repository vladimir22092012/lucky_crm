<?php

class EquifaxAvgPaid_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $scoring_type = $this->scorings->get_type('EquifaxAvgPaid');

        $this->db->query("
        SELECT *
        FROM s_scorings
        WHERE order_id = ?
        and `type` = 'equifax'
        and `status` = 'completed'
        order by id desc
        limit 1
        ", $scoring->order_id);

        $equifax = $this->db->result();

        if (!empty($equifax)) {

            $params = json_decode($equifax->body, true);

            if ($params['credit_avg_paid_for_type_19_days_90'] < $scoring_type->params['credit_avg_paid_for_type_19_days_90']) {
                $reason = 'credit_avg_paid_for_type_19_days_90';
            }

            $update = [
                'status' => 'completed',
                'body' => json_encode($params),
                'string_result' => (isset($reason)) ? 'Отказ по переменной ' . $reason : 'Проверка пройдена',
                'success' => (isset($reason)) ? 0 : 1
            ];

            $this->scorings->update_scoring($scoring_id, $update);

            return $update;
        }
    }
}