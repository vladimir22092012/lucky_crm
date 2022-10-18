<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class DaysUntilDueDateReminderCron extends Core
{
    public function __construct()
    {
        parent::__construct();

        $this->run();
    }

    private function run()
    {
        $templatesSms = array_filter($this->settings->days_until_due_date['sms'], function ($item, $key) {
            return $key != 0 & !empty($item);
        }, ARRAY_FILTER_USE_BOTH);

        $templatesZvonobot = array_filter($this->settings->days_until_due_date['zvonobot'], function ($item, $key) {
            return $key != 0 & !empty($item);
        }, ARRAY_FILTER_USE_BOTH);

        $templatesKeys = array_keys($templatesSms) + array_keys($templatesZvonobot);
        sort($templatesKeys);

        echo __FILE__ . ' ' . __LINE__ . '<br /><pre>';
        var_dump($templatesKeys);
        echo '</pre><hr />';
        echo __FILE__ . ' ' . __LINE__ . '<br /><pre>';
        var_dump($templatesSms);
        echo '</pre><hr />';
        echo __FILE__ . ' ' . __LINE__ . '<br /><pre>';
        var_dump($templatesZvonobot);
        echo '</pre><hr />';
        //exit;

        foreach ($templatesKeys as $days) {
            $reminderCollection = $this->Reminders->get_list_until_due_date($days);

            echo __FILE__ . ' ' . __LINE__ . '<br /><pre>';
            var_dump($reminderCollection);
            echo '</pre><hr />';
            //exit;

            foreach ($reminderCollection as $reminder) {
                //echo __FILE__ . ' ' . __LINE__ . '<br /><pre>';
                //var_dump($days, $reminder);
                //echo '</pre><hr />';
                //exit;

                $user = $this->users->get_user($reminder->user_id);

                $client_time = $this->helpers->get_regional_time($user->Regregion);
                $client_time_warning = $this->users->get_time_warning($client_time);

                if (empty($client_time_warning)) {
                    $data['имя'] = $user->firstname;
                    $data['номер'] = $reminder->number;
                    $data['сумма'] = $reminder->amount;
                    $data['days_or_minutes'] = $days;
                    $data['user_id'] = $reminder->user_id;
                    $data['type'] = 'days_until_due_date_reminder';

                    $data['accept_code'] = $reminder->accept_code;

                    $data['amount'] = $reminder->amount;
                    $data['credit'] = $reminder->amount;
                    $data['payment'] = $reminder->loan_body_summ + $reminder->loan_percents_summ + $reminder->loan_charge_summ + $reminder->loan_peni_summ;
                    $data['percent'] = $reminder->loan_percents_summ;
                    $data['payday'] = date("d-m-Y", strtotime($reminder->return_date));
                    $data['contract'] = $reminder->number;
                    $data['loanid'] = $reminder->order_id;
                    $data['crd+'] = $reminder->amount;

                    if (isset($templatesSms[$days])) {
                        $sent_result = $this->Reminders->send_sms($user->phone_mobile, $templatesSms[$days], $data);
                        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($user->phone_mobile, $templatesSms[$days], $data);echo '</pre><hr />';
                    } elseif (isset($templatesZvonobot[$days])) {
                        # code...
                    }

                    $this->contracts->update_contract($reminder->id, ['days_until_due_date_reminded' => $days]);
                }
            }
        }
    }
}
new DaysUntilDueDateReminderCron();
