<?php
error_reporting(-1);
ini_set('display_errors', 'On');

//chdir('/home/v/vse4etkoy2/nalic_eva-p_ru/public_html/');
chdir(dirname(__FILE__).'/../');

require 'autoload.php';

/**
 * IssuanceCron
 * 
 * Скрипт производит распределения
 * 
 * @author Ruslan Kopyl
 * @copyright 2021
 * @version $Id$
 * @access public
 */
class DistributeCron extends Core
{
    public function run()
    {
        //$this->contracts->check_expiration_contracts();
        
        //$this->contracts->check_collection_contracts();
        
        //$this->contracts->check_sold_contracts();
        
        $this->contracts->distribute_contracts();
    }
}

(new DistributeCron)->run();