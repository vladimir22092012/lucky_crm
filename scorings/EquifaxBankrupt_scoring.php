<?php

class EquifaxBankrupt_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $scoring_type = $this->scorings->get_type('EquifaxBankrupt');

        $order = $this->orders->get_order($scoring->order_id);

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

            if (in_array($order->client_status, ['nk', 'rep']) && $params['bkicountactivecredit'] > $scoring_type->params['bkicountactivecredit_new'] || in_array($order->client_status, ['pk', 'crm']) && $params['bkicountactivecredit'] > $scoring_type->params['bkicountactivecredit_old']) {
                if ($params['bkicountactivecredit'] > $scoring_type->params['bkicountactivecredit_new']) {
                    $reason = 'bkicountactivecredit';
                }
            }
            else{
                if ($params['bkicountactivecredit'] > $scoring_type->params['bkicountactivecredit_old']) {
                    $reason = 'bkicountactivecredit';
                }
            }

            if(!isset($reason)){
                if ($params['creditsCreatedlast7day'] > $scoring_type->params['creditsCreatedlast7day']) {
                    $reason = 'creditsCreatedlast7day';
                }
            }

            if(!isset($reason)){
                if ($params['bkiscoring'] < $scoring_type->params['bkiscoring_min'] || $params['bkiscoring'] > $scoring_type->params['bkiscoring_max']) {
                    $reason = 'bkiscoring';
                }
            }

            if(!isset($reason)){
                if ($params['interestForLastMonth'] > $scoring_type->params['interestForLastMonth']) {
                    $reason = 'interestForLastMonth';
                }
            }

            if(!isset($reason)){
                if ($params['credit_prolongation_count_contracts_with_age_180_type_19'] < $scoring_type->params['credit_prolongation_count_contracts_with_age_180_type_19']) {
                    $reason = 'credit_prolongation_count_contracts_with_age_180_type_19';
                }
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