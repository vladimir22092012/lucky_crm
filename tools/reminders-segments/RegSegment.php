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

                if(empty($user->time_zone))
                    continue;

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