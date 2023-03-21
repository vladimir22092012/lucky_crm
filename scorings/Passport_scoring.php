<?php

class Passport_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $user = $this->users->get_user($scoring->user_id);

        $nowDate = new DateTime();
        $birthDate = new DateTime(date('Y-m-d', strtotime($user->birth)));
        $birthDay = new DateTime(date('Y-m-d', strtotime(date('Y') . '-' . $birthDate->format('m') . '-' . $birthDate->format('d'))));
        $passportIssued = new DateTime(date('Y-m-d', strtotime($user->passport_date)));
        $rejectScoring = 0;

        if ($birthDay < $nowDate)
            $birthDay->add(new DateInterval('P1Y'));

        $yearsOld = date_diff($nowDate, $birthDate)->y;

        if($yearsOld < 20){
            $rejectScoring = 1;
        }

        $daysBeforeBirthday = date_diff($nowDate, $birthDate)->days;

        if ($yearsOld == 44 && $daysBeforeBirthday < 30) {
            $rejectScoring = 1;
        }


        $changePassport = clone $birthDate;

        if ($yearsOld >= 20 && $yearsOld < 45) {
            $changePassport->add(new DateInterval('P20Y'));
        }


        if ($yearsOld >= 45) {
            $changePassport->add(new DateInterval('P45Y'));
        }

        if ($passportIssued < $changePassport)
            $rejectScoring = 1;

        if ($rejectScoring == 1) {
            $update = [
                'status' => 'completed',
                'body' => null,
                'string_result' => 'Отказ по скорингу',
                'success' => 0
            ];
        } else {
            $update = [
                'status' => 'completed',
                'body' => null,
                'string_result' => 'Скоринг пройден',
                'success' => 1
            ];
        }

        if (!empty($update)){
            $this->scorings->update_scoring($scoring_id, $update);
            return $update;
        }
        
        return null;
    }
}