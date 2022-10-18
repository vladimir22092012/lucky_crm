<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

class DaysSinceApprovalReminderCron extends Core
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
        rsort($templatesKeys);

        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($templatesKeys);echo '</pre><hr />';

        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($templatesSms);echo '</pre><hr />';
        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($templatesZvonobot);echo '</pre><hr />';
        //exit;

        foreach ($templatesKeys as $days) {
            $reminderCollection = $this->Reminders->get_list_since_approval($days);

            echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($days, $reminderCollection);echo '</pre><hr />';
            //continue;

            foreach ($reminderCollection as $reminder) {
                //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($days, $reminder);echo '</pre><hr />';

                $user = $this->users->get_user($reminder->user_id);
                
                //$client_time = $this->helpers->get_regional_time($user->Regregion);
                //$client_time_warning = $this->users->get_time_warning($client_time); 

                if (/*empty($client_time_warning)*/true)
                {
                    $contract = $this->contracts->get_order_contract($reminder->id);
                    
                    if (empty($contract)) {
                        continue;
                    }

                    $data['имя'] = $user->firstname;
                    $data['номер'] = $contract->number;
                    $data['сумма'] = $reminder->amount;
                    $data['days_or_minutes'] = $days;
                    $data['user_id'] = $reminder->user_id;
                    $data['type'] = 'days_since_approval';

                    $data['accept_code'] = $contract->accept_code;

                    $data['firstname'] = $user->firstname;
                    $data['amount'] = $reminder->amount;
                    $data['credit'] = $reminder->amount;
                    $data['payment'] = $contract->loan_body_summ + $contract->loan_percents_summ + $contract->loan_charge_summ + $contract->loan_peni_summ;
                    $data['percent'] = $contract->loan_percents_summ;
                    $data['payday'] =  date("d-m-Y", strtotime($contract->return_date));
                    $data['contract'] = $contract->number;
                    $data['loanid'] = $reminder->order_id;
                    $data['crd+'] = $reminder->amount;

                    if (isset($templatesSms[$days])) {
                        $sent_result = $this->Reminders->send_sms($user->phone_mobile, $templatesSms[$days], $data);
                        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($user->phone_mobile, $templatesSms[$days], $data);echo '</pre><hr />';
                        //exit;
                    } elseif (isset($templatesZvonobot[$days])) {
                        # code...
                    }

                    $this->orders->update_order($reminder->id, ['days_since_approval' => $days]);
                    //exit;
                }
            }
        }
    }
}
new DaysSinceApprovalReminderCron();