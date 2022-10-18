
<?php

chdir('..');

require 'autoload.php';

class Get39 extends Core
{
    private $response = array();
    
    private $password = 'AX6878EK';
    
    public function __construct()
    {
    	$this->run();
    }
    
    private function run()
    {
        //var_dump($operation_id, $register_id, $password);
        $password = $this->request->get('password');
        if ($password != $this->password)
        {
            echo 'p!';
            exit; 
        }

        $operations = $this->operations->get_operations(['id' => ['7538522'], 'type' => 'REJECT_REASON', 'limit' => 1000]);
        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($operations);echo '</pre><hr />';
        //exit;

        foreach ($operations as $operation) {
            $operation = $this->operations->get_operation($operation->id);
            $operation->transaction = $this->transactions->get_transaction($operation->transaction_id);

            //if ($operation->transaction_id == '359022') {
                $resp = $this->soap1c->send_reject_reason($operation);

                echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($resp);echo '</pre><hr />';
                $this->logging_('run', '39', $operation->id, $resp, 'logs/Get39.txt');
            //}
        }
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

new Get39();