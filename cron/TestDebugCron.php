<?php
error_reporting(-1);
ini_set('display_errors', 'On');


//chdir('/home/v/vse4etkoy2/nalic_eva-p_ru/public_html/');
chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class TestDebugCron extends Core
{
    public function __construct()
    {
        parent::__construct();
        var_dump('test');
        //$this->run();
    }

    private function run()
    {
        $query = $this->db->placehold("
                  SELECT `number`,
                  sold_date
                  FROM s_contracts
                  WHERE sold_date BETWEEN '2022-03-29 00:00:00' AND '2022-03-30 23:59:59'");

        $this->db->query($query);
        $results = $this->db->results();

        $users = array();

        foreach ($results as $result) {
            $key = date('Ymd', strtotime($result->sold_date));

            if (!isset($users[$key]))
                $users[$key][] = $result->number;
            else
                $users[$key][] = $result->number;
        }

        foreach ($users as $date => $user) {

            $this->Soap1c->send_cessions(
                [
                    'Contracts' => $user,
                    'Date' => date('YmdHis', strtotime($date))
                ]
            );

            sleep(10);

        }
    }
}

new TestDebugCron();