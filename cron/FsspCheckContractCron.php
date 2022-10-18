<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class FsspCheckContractCron extends Core
{
    public function __construct()
    {
        parent::__construct();

        $this->run();
    }

    private function run()
    {
        $filter['status'] = 5;

        $contracts_to_check = $this->sudblock->get_contracts($filter);
    }
}

new FsspCheckContractCron();