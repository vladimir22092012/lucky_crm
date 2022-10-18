<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class DaysAbandonedOrderReminderCron extends Core
{
    public function __construct()
    {
        parent::__construct();
        
        $this->run();
    }
    
    private function run()
    {
        $templatesSms = array_filter($this->settings->days_since_approval['sms'], function ($item, $key) {
            return $key != 0 & !empty($item);
        }, ARRAY_FILTER_USE_BOTH);

        $templatesZvonobot = array_filter($this->settings->days_since_approval['zvonobot'], function ($item, $key) {
            return $key != 0 & !empty($item);
        }, ARRAY_FILTER_USE_BOTH);

        $templatesKeys = array_keys($templatesSms) + array_keys($templatesZvonobot);
        
        //??
        rsort($templatesKeys);

        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($templatesKeys);echo '</pre><hr />';

        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($templatesSms);echo '</pre><hr />';
        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($templatesZvonobot);echo '</pre><hr />';
        //exit;
        foreach ($templatesKeys as $days) {
            $reminderCollection = $this->Reminders->get_list_abandoned_orders($days, 'days');
            echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($days, $reminderCollection);echo '</pre><hr />';
            //exit;
            foreach ($reminderCollection as $reminder) {
                //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($days, $reminder);echo '</pre><hr />';

                $user = $this->users->get_user($reminder->id);
                
                $client_time = $this->helpers->get_regional_time($user->Regregion);
                $client_time_warning = $this->users->get_time_warning($client_time); 

                if (empty($client_time_warning))
                {
                    $data['имя'] = $user->firstname;
                    $data['номер'] = $reminder->number;
                    $data['сумма'] = $reminder->first_loan_amount;
                    $data['days_or_minutes'] = $days;
                    $data['user_id'] = $reminder->id;
                    $data['type'] = 'days_abandoned_order';

                    if (isset($templatesSms[$days])) {
                        $sent_result = $this->Reminders->send_sms($user->phone_mobile, $templatesSms[$days], $data);
                        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($user->phone_mobile, $templatesSms[$days], $data);echo '</pre><hr />';
                        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($sent_result);echo '</pre><hr />';
                    } elseif (isset($templatesZvonobot[$days])) {
                        # code...
                    }

                    $this->users->update_user($reminder->id, ['days_abandoned_order' => $days]);
                }
            }
        }
    }
}
new DaysAbandonedOrderReminderCron();