<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class DebugCron extends Core
{
    public function __construct()
    {
        parent::__construct();

        $this->run();
    }

    private function run()
    {
        $query = $this->db->placehold("
        SELECT `number` as contract_number
        FROM s_contracts
        WHERE collection_manager_id = 105
        ");

        $this->db->query($query);
        $contracts = $this->db->results();

        foreach ($contracts as $contract)
        {
            $this->soap1c->PreparationForTrial($contract->contract_number);
        }
    }
}

new DebugCron();