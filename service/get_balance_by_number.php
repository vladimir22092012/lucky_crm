
<?php

chdir('..');

require 'autoload.php';

class GetBalanceByNumber extends Core
{
    private $response = array();
    
    private $password = 'AX6878EK';
    
    public function __construct()
    {
    	$this->run();
    }
    
    private function run()
    {
        $password = $this->request->get('password');
        if ($password != $this->password)
        {
            echo 'p!';
            exit; 
        }

        $number = $this->request->get('number');
        if (!$number)
        {
            echo 'n!';
            exit; 
        }

        $request = new stdClass();
        $request->Number = $number;
    
        $service = 'WebCRM';
        $method = 'GetDebt';
    
        try {
            $service_url = "http://192.168.3.16:80/work/ws/".$service.".1cws?wsdl";
            $client = new SoapClient($service_url);
    
            $response = $client->__soapCall($method, array($request));
        } catch (Exception $fault) {
            $response = $fault;
        }

        sleep(3);
        header('Content-type:application/json');
        echo json_encode($response);

       // echo $response;
    
        //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($response);echo '</pre><hr />';
        $this->logging_('get_balance_for_short_link', '', $number, $response, 'logs/get_balance_for_short_link.txt');
    }
    
    public function logging_($local_method, $service, $request, $response, $filename)
    {
        $log_filename = $this->log_dir.$filename;

        if (date('d', filemtime($log_filename)) != date('d'))
        {
            $archive_filename = $this->log_dir.'archive/'.date('ymd', filemtime($log_filename)).'.'.$filename;
            rename($log_filename, $archive_filename);
            file_put_contents($log_filename, "\xEF\xBB\xBF");            
        }

        if (isset($request['TextJson']))        
            $request['TextJson'] = json_decode($request['TextJson']);
        if (isset($request['ArrayContracts']))        
            $request['ArrayContracts'] = json_decode($request['ArrayContracts']);
        if (isset($request['ArrayOplata']))        
            $request['ArrayOplata'] = json_decode($request['ArrayOplata']);

        $str = PHP_EOL.'==================================================================='.PHP_EOL;
        $str .= date('d.m.Y H:i:s').PHP_EOL;
        $str .= $service.PHP_EOL;
        $str .= var_export($request, true).PHP_EOL;
        $str .= var_export($response, true).PHP_EOL;
        $str .= 'END'.PHP_EOL;

        //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($str);echo '</pre><hr />';

        file_put_contents($this->log_dir.$filename, $str, FILE_APPEND);
    }
}

new GetBalanceByNumber();