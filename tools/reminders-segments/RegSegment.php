<?php

class RegSegment extends SegmentsAbastract
{

    public static function sendReminder($request)
    {
        $reminders = RemindersORM::where('segmentId', 1)->get();

        foreach ($reminders as $reminder) {
            $startTime = date('Y-m-d H:i:s', strtotime('-' . $reminder->countTime . ' ' . $reminder->timeType));
            $users = UsersORM::whereRaw('lastUpdate', '<=', $startTime)->where('stage_card', 0)->get();

            foreach ($users as $user) {
                $isSent = RemindersCronORM::where('userId', $user->id)->where('reminderId', $reminder->id)->get();

                if (!empty($isSent))
                    continue;

                if (empty($user->time_zone))
                    continue;

                $clientTime = gmdate('Y-m-d H:i:s', strtotime("UTC+3"));

                $isHoliday = WeekendCalendarORM::where('date', date('Y-m-d'))->first();
                $settings = new Settings();
                $sent = 0;

                if (!empty($isHoliday) && date('G', strtotime($clientTime)) >= $settings->holiday_worktime['from'] && date('G', strtotime($clientTime)) < $settings->holiday_worktime['to'])
                    $sent = 1;

                if (empty($isHoliday) && date('G', strtotime($clientTime)) >= $settings->workday_worktime['from'] && date('G', strtotime($clientTime)) < $settings->workday_worktime['to'])
                    $sent = 1;

                if ($sent == 1) {
                    $send =
                        [
                            'phone' => 'phone_mobile',
                            'msg' => $reminder->msgSms
                        ];

                    self::send($send);
                }
            }
        }
    }
}