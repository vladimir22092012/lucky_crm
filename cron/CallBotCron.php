<?php

error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class CallBotCron extends Core
{
    public function __construct()
    {
        parent::__construct();
        $this->run();
    }

    private function run()
    {
        $callBotSettings = CallBotSettingsORM::find(1);

        $thisDayFrom = date('Y-m-d 00:00:00');
        $thisDayTo = date('Y-m-d 23:59:59');

        $thisWeekFrom = date('Y-m-d 00:00:00', strtotime('monday this week'));
        $thisWeekTo = date('Y-m-d 23:59:59', strtotime('sunday this week'));

        $thisMonthFrom = date('Y-m-01 00:00:00', strtotime('monday this week'));
        $thisMonthTo = date('Y-m-t 23:59:59', strtotime('monday this week'));

        if (date('H:i', strtotime($callBotSettings->time)) != date('H:i'))
            exit;

        switch ($callBotSettings->periods) {
            case 'twiceDay':
                $startTime = date('Y-m-d 00:00:00', strtotime('-1 day'));
                $endTime = date('Y-m-d 23:59:59');
                $isSent = CallBotCron::whereBetween('created', [$startTime, $endTime])->first();
                break;

            case 'thriceDay':
                $startTime = date('Y-m-d 00:00:00', strtotime('-2 day'));
                $endTime = date('Y-m-d 23:59:59');
                $isSent = CallBotCron::whereBetween('created', [$startTime, $endTime])->first();
                break;

            case 'oneToWeek':
                $startTime = date('Y-m-d 00:00:00', strtotime('-7 day'));
                $endTime = date('Y-m-d 23:59:59');
                $isSent = CallBotCron::whereBetween('created', [$startTime, $endTime])->first();
                break;
        }

        if(!empty($isSent))
            exit;

        $limitCommunications = $this->settings->limit_communications;
        $contracts = ContractsORM::where('status', 4)->get();


        foreach ($contracts as $contract) {
            $limitDays = 0;
            $limitWeek = 0;
            $limitMonth = 0;


            $communications = CallBotCron::where('userId', $contract->user_id);
            $canSend = 1;

            if (!empty($communications)) {
                foreach ($communications as $communication) {
                    $created = date('Y-m-d H:i:s', strtotime($communication->created));

                    if ($created >= $thisDayFrom && $created <= $thisDayTo)
                        $limitDays++;

                    if ($created >= $thisWeekFrom && $created <= $thisWeekTo)
                        $limitWeek++;

                    if ($created >= $thisMonthFrom && $created <= $thisMonthTo)
                        $limitMonth++;
                }

                if (
                    $limitDays >= $limitCommunications['day']
                    || $limitWeek >= $limitCommunications['week']
                    || $limitMonth >= $limitCommunications['month']
                ) {
                    $canSend = 0;
                }
            }

            $user = UsersORM::where('id', $contract->user_id)->fisrt();

            if (empty($user->time_zone))
                continue;

            $clientTime = gmdate('Y-m-d H:i:s', strtotime($user->time_zone));

            $isHoliday = WeekendCalendarORM::where('date', date('Y-m-d'))->first();
            $settings = new Settings();

            if (!empty($isHoliday) && date('G', strtotime($clientTime)) < $settings->holiday_worktime['from'] && date('G', strtotime($clientTime)) > $settings->holiday_worktime['to'])
                $canSend = 0;

            if (empty($isHoliday) && date('G', strtotime($clientTime)) < $settings->workday_worktime['from'] && date('G', strtotime($clientTime)) > $settings->workday_worktime['to'])
                $canSend = 0;


            if ($canSend == 1) {
                $data = new stdClass();
                $data->orderId = $contract->order_id;
                $data->text = $callBotSettings->textCallBot;
                CallBot::sendRequest($data);
            }
        }
    }
}

new CallBotCron();