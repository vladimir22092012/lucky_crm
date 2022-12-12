<?php

class EquifaxExpired_scoring extends Core
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
        ", $scoring->order_id);

        $equifax = $this->db->result();

        $params = json_decode($equifax->body, true);

        if ($params['credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60'] > 1) {

            if ($params['credit_count_active_overdue_11_12_13_sum_1000'] > 2) {
                $reason = 'credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60';
            }
            if ($params['credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60'] > 2) {
                $reason = 'credit_count_with_active_not_0_3_20_deliqfrom_30_deliqto_60';
            }
            if ($params['credit_avg_paid_for_type_19_days_90'] < 3000) {
                $reason = 'credit_avg_paid_for_type_19_days_90';
            }
            if ($params['credit_count_delay_5'] < 5) {
                $reason = 'credit_count_delay_5';
            }
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