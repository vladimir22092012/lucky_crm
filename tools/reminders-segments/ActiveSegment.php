<?php

class ActiveSegment extends SegmentsAbstract
{

    public static function processing($reminder)
    {
        $reminders = RemindersORM::where('segmentId', 3)->where('is_on', 1)->get();

        foreach ($reminders as $reminder) {

            switch ($reminder->id) {
                case 4:
                    self::toDayReminder($reminder);
                    break;

                case 6:
                    self::beforeDayReminder($reminder);
                    break;
            }
        }
    }

    private static function toDayReminder($reminder)
    {
        $nowHour = date('H');

        if ($nowHour == $reminder->countTime) {
            $startTime = date('Y-m-d 00:00:00');
            $endTime = date('Y-m-d 23:59:59');

            $contracts = ContractsORM::whereBetween('return_date', [$startTime, $endTime])->where('status', 2)->get();

            foreach ($contracts as $contract) {

                $user = UsersORM::where('id', $contract->user_id)->first();

                $isSent = RemindersCronORM::where('userId', $user->id)->whereBetween('created', [$startTime, $endTime])->first();

                if (!empty($isSent))
                    continue;

                $reminderLog =
                    [
                        'reminderId' => $reminder->id,
                        'userId' => $user->id,
                        'message' => $reminder->msgSms,
                        'phone' => $user->phone_mobile
                    ];

                RemindersCronORM::insert($reminderLog);
                $send =
                    [
                        'phone' => $user->phone_mobile,
                        'msg' => $reminder->msgSms
                    ];

                self::send($send);

            }
        }
    }

    private static function beforeDayReminder($reminder)
    {
        $returnStartTime = date('Y-m-d 00:00:00', strtotime('+' . $reminder->countTime . ' days'));
        $returnEndTime = date('Y-m-d 23:59:59', strtotime('+' . $reminder->countTime . ' days'));

        $contracts = ContractsORM::whereBetween('return_date', [$returnStartTime, $returnEndTime])->where('status', 2)->get();

        foreach ($contracts as $contract) {
            $user = UsersORM::where('id', $contract->user_id)->first();

            $isSent = RemindersCronORM::where('userId', $user->id)->where('reminderId', $reminder->id)->first();

            if (!empty($isSent))
                continue;


            $reminderLog =
                [
                    'reminderId' => $reminder->id,
                    'userId' => $user->id,
                    'message' => $reminder->msgSms,
                    'phone' => $user->phone_mobile
                ];

            RemindersCronORM::insert($reminderLog);

            $send =
                [
                    'phone' => $user->phone_mobile,
                    'msg' => $reminder->msgSms
                ];

            self::send($send);

        }
    }
}