<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class MinutesAbandonedOrderReminderCron extends Core
{
    public function __construct()
    {
        parent::__construct();
        
        $this->run();
    }
    
    private function run()
    {
        $templatesSms = array_filter($this->settings->days_since_approval['sms'][0], function ($item, $key) {
            return $key != 0 & !empty($item);
        }, ARRAY_FILTER_USE_BOTH);

        $templatesZvonobot = array_filter($this->settings->days_since_approval['zvonobot'][0], function ($item, $key) {
            return $key != 0 & !empty($item);
        }, ARRAY_FILTER_USE_BOTH);

        $templatesKeys = array_keys($templatesSms) + array_keys($templatesZvonobot);

        //??
        rsort($templatesKeys);

        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($templatesKeys);echo '</pre><hr />';

        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($templatesSms);echo '</pre><hr />';
        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($templatesZvonobot);echo '</pre><hr />';
        //exit;
        foreach ($templatesKeys as $minutes) {
            $reminderCollection = $this->Reminders->get_list_abandoned_orders($minutes, 'minutes');
            //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($reminderCollection);echo '</pre><hr />';
            foreach ($reminderCollection as $reminder) {
                //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($minutes, $reminder);echo '</pre><hr />';
                $user = $this->users->get_user($reminder->id);
                
                $client_time = $this->helpers->get_regional_time($user->Regregion);
                $client_time_warning = $this->users->get_time_warning($client_time); 

                if (empty($client_time_warning))
                {
                    $data['имя'] = $user->firstname;
                    $data['номер'] = $reminder->number;
                    $data['сумма'] = $reminder->first_loan_amount;
                    $data['days_or_minutes'] = $minutes;
                    $data['user_id'] = $reminder->id;
                    $data['type'] = 'minutes_abandoned_order';

                    if (isset($templatesSms[$minutes])) {
                        $sent_result = $this->Reminders->send_sms($user->phone_mobile, $templatesSms[$minutes], $data);
                        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($user->phone_mobile, $templatesSms[$minutes], $data);echo '</pre><hr />';
                        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($sent_result);echo '</pre><hr />';
                    } elseif (isset($templatesZvonobot[$minutes])) {
                        # code...
                    }

                    $this->users->update_user($reminder->id, ['minutes_abandoned_order' => $minutes]);
                }
            }
        }
    }
}
new MinutesAbandonedOrderReminderCron();