<?php

error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('memory_limit', '1024M');

chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class test extends Core
{

    public function __construct()
    {
        parent::__construct();
    }
}

new test();