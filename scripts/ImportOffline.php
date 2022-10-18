<?php

error_reporting(-1);
ini_set('display_errors', 'On');

chdir('..');

require 'autoload.php';
require_once "PHPExcel/Classes/PHPExcel.php";

$response = array();

class ImportOfflineScript extends Core
{
    public function __construct()
    {
    	$action = $this->request->get('action');
        switch ($action):
            
            case 'organizations':
                $this->import_organizations();
            break;
            
            case 'points':
                $this->import_points();
            break;
            
            default:
                exit('UNDEFINED ACTION');
            
        endswitch;
    }
    
    private function import_organizations()
    {
        if ($resp = $this->soap1c->get_organization())
        {
            foreach ($resp as $item)
            {
                $code = $item['Код'];
                $name = $item['Наименование'];
                if (!$this->offline->get_organization_by_bode($code))
                {
                    $this->offline->add_organization([
                        'name' => $name,
                        'full_name' => $name,
                        'code' => $code
                    ]);
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($item);echo '</pre><hr />';                
                    
                }
            }
        }
        else
        {
            exit('ERROR: EMPTY RESPONSE');
        }
    }
    
    private function import_points()
    {
        if ($orgs = $this->offline->get_organizations())
        {
            foreach ($orgs as $org)
            {
                $branches = $this->soap1c->get_branches($org->code);
                if (!empty($branches))
                {
                    foreach ($branches as $branch)
                    {
                        if (!empty($branch['Филалы']))
                        {
                            foreach ($branch['Филалы'] as $filial)
                            {
                                if (!$this->offline->get_point_by_code($filial['Код']))
                                {
                                    $this->offline->add_point([
                                        'organization_id' => $org->id,
                                        'code' => $filial['Код'],
                                        'city' => $branch['Город'],
                                        'address' => $filial['Филиал']
                                    ]);
                        
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($org, $filial);echo '</pre><hr />';
                                }
                            }
                            
                        }
                    }
                    
                }
            }
        }
        else
        {
            exit('ERROR: ORGANIZATIONS NOT FOUND');
        }
    }
}

new ImportOfflineScript();
 