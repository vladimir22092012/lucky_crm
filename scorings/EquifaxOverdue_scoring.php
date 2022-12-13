<?php

class EquifaxOverdue_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);

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

        $params = json_decode($equifax->body, true);

        if ($params['credit_count_active_overdue_11_12_13_sum_1000'] > 3) {
            $reason = 'credit_count_active_overdue_11_12_13_sum_1000';
        }

        $update = [
            'status' => 'completed',
            'body' => json_encode($params),
            'string_result' => (isset($reason)) ? 'Отказ по переменной ' . $reason: 'Проверка пройдена',
            'success' => (isset($reason)) ? 0 : 1
        ];

        $this->scorings->update_scoring($scoring_id, $update);

        return $update;
    }
}