<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class ApiQueueForSales extends Core
{

    public function __construct()
    {
    	parent::__construct();

        $this->run();
    }

    private function run()
    {
        $ordersCollection = $this->Leadfinances->get_queue_for_sending_via_api(9);
        $ordersCollectionForReject = $this->Leadfinances->get_queue_for_sending_via_api_with_delay(9);

        foreach ($ordersCollection as $apiOrder) {
            $this->Leadfinances->send_lead($apiOrder->order_id);
            //ставим sent = 2 вместо 1 из-за делея в 7 дней для 123reject
            //после отправки в 123reject sent будет обновлен до 1
            $this->Leadfinances->update_lead($apiOrder->id, [
                'sent' => 2,
                'sent_at' => date('Y-m-d H:i:s'),
                'result' => ''
            ]);
        }

        foreach ($ordersCollectionForReject as $apiOrder) {
            $this->Leadfinances->send_lead_reject($apiOrder->order_id);

            $this->Leadfinances->update_lead($apiOrder->id, [
                'sent' => 1,
                'sent_at' => date('Y-m-d H:i:s'),
                'result' => ''
            ]);
        }
    }
}

new ApiQueueForSales();
