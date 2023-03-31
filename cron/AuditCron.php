<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class AuditCron extends Core
{
    public function __construct()
    {
    	parent::__construct();
        
        file_put_contents($this->config->root_dir.'cron/log.txt', date('d-m-Y H:i:s').' AUDIT RUN'.PHP_EOL, FILE_APPEND);
    }
    
    
    public function run()
    {
        $datetime = date('Y-m-d H:i:s', time() - 300);
        
        $overtime_scorings = $this->scorings->get_overtime_scorings($datetime);
        if (!empty($overtime_scorings))
        {
            foreach ($overtime_scorings as $overtime_scoring)
            {
                if (in_array($overtime_scoring->type, array('fms', 'fns', 'fssp')) && $overtime_scoring->repeat_count < 2)
                {
                    $this->scorings->update_scoring($overtime_scoring->id, array(
                        'status' => 'repeat',
                        'body' => 'Истекло время ожидания',
                        'string_result' => 'Повторный запрос',
                        'repeat_count' => $overtime_scoring->repeat_count + 1,
                    ));
                    
                }
                else
                {
                    $this->scorings->update_scoring($overtime_scoring->id, array(
                        'status' => 'error',
                        'string_result' => 'Истекло время ожидания'
                    ));
                }
            }
        }
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($overtime_scorings);echo '</pre><hr />';

        $i = 30;
        while ($i > 0)
        {
            if ($scoring = $this->scorings->get_repeat_scoring())
            {
                $this->scorings->update_scoring($scoring->id, array(
                    'status' => 'process',
                    'start_date' => date('Y-m-d H:i:s')
                ));
                
                $classname = $scoring->type."_scoring";
                
                $scoring_result = $this->{$classname}->run_scoring($scoring->id);
                
                $this->handling_result($scoring, $scoring_result);
            }
            $i--;
        }

        $i = 30;
        while ($i > 0)
        {
            if ($scoring = $this->scorings->get_new_scoring())
            {
                $this->scorings->update_scoring($scoring->id, array(
                    'status' => 'process',
                    'start_date' => date('Y-m-d H:i:s')
                ));
                
                $classname = $scoring->type."_scoring";
                $scoring_result = $this->{$classname}->run_scoring($scoring->id);

                $this->handling_result($scoring, $scoring_result);
            }
            $i--;
        }
        
    }
    
    private function handling_result($scoring, $result)
    {
        $scoring_type = $this->scorings->get_type($scoring->type);
        if ($result['status'] == 'completed' && $result['success'] == 0)
        {
            if ($scoring_type->negative_action == 'stop' || $scoring_type->negative_action == 'reject')
            {
                // останавливаем незаконченные скоринги
                if ($order_scorings = $this->scorings->get_scorings(array('order_id'=>$scoring->order_id)))
                {
                    foreach ($order_scorings as $os)
                    {
                        if (in_array($os->status, ['new', 'process', 'repeat']))
                        {
                            $this->scorings->update_scoring($os->id, array('status'=>'stopped'));
                        }
                    }
                }
            }

            if ($scoring_type->negative_action == 'reject')
            {
                if (!empty($scoring_type->reason_id))
                {
                    $order = $this->orders->get_order($scoring->order_id);
                    $reason = $this->reasons->get_reason($scoring_type->reason_id);
                    
                    $update = array(
                        'autoretry' => 0,
                        'autoretry_result' => 'Отказ по скорингу '.$scoring_type->title,
                        'status' => 3,
                        'reason_id' => $reason->id,
                        'reject_reason' => $reason->client_name,
                        'reject_date' => date('Y-m-d H:i:s'),
                        'manager_id' => 1, // System
                    );
                    
                    // ставим отказ по заявке 
                    $this->orders->update_order($scoring->order_id, $update);
                    
                    $this->changelogs->add_changelog(array(
                        'manager_id' => 1,
                        'created' => date('Y-m-d H:i:s'),
                        'type' => 'order_status',
                        'old_values' => serialize(array()),
                        'new_values' => serialize($update),
                        'order_id' => $order->order_id,
                        'user_id' => $order->user_id,
                    ));

                    if($order->utm_source == 'guruleads')
                        Guruleads::sendRequest(['orderId' => $order->order_id, 'method' => 'sendCancelledPostback']);
                }
            }
        }
    }

}

$cron = new AuditCron();
$cron->run();
