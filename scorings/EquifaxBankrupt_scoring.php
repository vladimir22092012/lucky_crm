<?php

class EquifaxBankrupt_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);

        $order = $this->orders->get_order($scoring->order_id);

        $this->db->query("
        SELECT *
        FROM s_scorings
        WHERE order_id = ?
        and `type` = 'equifax'
        and `status` = 'completed'
        ", $scoring->order_id);

        $equifax = $this->db->result();

        $params = json_decode($equifax->body, true);

        if (in_array($order->client_status, ['nk', 'rep']) && $params['bkicountactivecredit'] > 22 || in_array($order->client_status, ['pk', 'crm']) && $params['bkicountactivecredit'] > 25) {

            if ($params['creditsCreatedlast7day'] == 0) {
                $reason = 'creditsCreatedlast7day';
            }
            if ($params['bkiscoring'] < 550 || $params['bkiscoring'] > 690) {
                $reason = 'bkiscoring';
            }
            if ($params['interestForLastMonth'] > 20) {
                $reason = 'interestForLastMonth';
            }
            if ($params['credit_prolongation_count_contracts_with_age_180_type_19'] < 2) {
                $reason = 'credit_prolongation_count_contracts_with_age_180_type_19';
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