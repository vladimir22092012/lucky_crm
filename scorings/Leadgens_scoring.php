<?php

class Leadgens_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $order = $this->orders->get_order($scoring->order_id);

        if(!empty($order->utm_source) && $order->amount <= 4000 && $order->utm_source != 'organic'){
            $update = [
                'status' => 'completed',
                'body' => null,
                'string_result' => 'Отказ по скорингу',
                'success' => 0
            ];
        } else {
            $update = [
                'status' => 'completed',
                'body' => null,
                'string_result' => 'Скоринг пройден',
                'success' => 1
            ];
        }

        $this->scorings->update_scoring($scoring_id, $update);

    }
}