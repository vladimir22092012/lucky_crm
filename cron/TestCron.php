<?php
error_reporting(-1);
ini_set('display_errors', 'On');
chdir(dirname(__FILE__).'/../');
require 'autoload.php';
class TestCron extends Core
{
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        $equifax = ScoringsORM::find(183916);
        $expire = ScoringsORM::find(183918);
        $type = ScoringTypesORM::find(29);
        print_r($expire);
    }

}
$cron = new TestCron();
$cron->run();