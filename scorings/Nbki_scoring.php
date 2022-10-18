<?php

class Nbki_scoring extends Core
{
    private $scoring_id;
    private $error = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function run_scoring($scoring_id)
    {
        if ($scoring = $this->scorings->get_scoring($scoring_id)) {
            $this->scoring_id = $scoring_id;

            if ($user = $this->users->get_user((int)$scoring->user_id)) {
                if ($user->Regcity) {
                    $city = $user->Regcity;
                } elseif ($user->Reglocality) {
                    $city = $user->Reglocality;
                } else {
                    $city = $user->Regcity;
                }

                return $this->scoring(
                    $user->firstname,
                    $user->patronymic,
                    $user->lastname,
                    $city,
                    $user->Regstreet,
                    $user->birth,
                    $user->birth_place,
                    $user->passport_serial,
                    $user->passport_date,
                    $user->passport_issued,
                    $user->gender,
                    $user->client_status
                );
            } else {
                $update = array(
                    'status' => 'error',
                    'string_result' => 'не найден пользователь'
                );
                $this->scorings->update_scoring($scoring_id, $update);
                return $update;
            }
        }
    }

    public function scoring(
        $firstname,
        $patronymic,
        $lastname,
        $Regcity,
        $Regstreet,
        $birth,
        $birth_place,
        $passport_serial,
        $passport_date,
        $passport_issued,
        $gender,
        $client_status
    )
    {
        $genderArr = [
            'male' => 1,
            'female' => 2
        ];

        $json = '{
    "user": {
        "passport": {
            "series": "' . substr($passport_serial, 0, 4) . '",
            "number": "' . substr($passport_serial, 5) . '",
            "issued_date": "' . date('Y-m-d', strtotime($passport_date)) . '",
            "issued_by": "' . addslashes($passport_issued) . '",
            "issued_city": "' . addslashes($Regcity) . '"
        },
        "person": {
            "last_name": "' . addslashes($lastname) . '",
            "first_name": "' . addslashes($firstname) . '",
            "middle_name": "' . addslashes($patronymic) . '",
            "birthday": "' . date('Y-m-d', strtotime($birth)) . '",
            "birthday_city": "' . addslashes($birth_place) . '",
            "gender": ' . $genderArr[$gender] . '
        },
        "registration_address": {
            "city": "' . addslashes($Regcity) . '",
            "street": "' . addslashes($Regstreet) . '"
        }
    },
    "requisites": {
        "member_code": "VK01RR000000",
        "user_id": "VK01RR000002",
        "password": "Qe1kdjf1"
    }
}';
//var_dump($json);
//exit;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://'.$this->settings->nbki_ip.'/api/nbki_test',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        //var_dump($response);
        //exit;

        curl_close($curl);
        $result = json_decode($response, true);


        if (!$result) {
            $add_scoring = array(
                'status' => 'error',
                'body' => var_export($response),
                'success' => 0,
                'string_result' => 'Ошибка запроса'
            );

            $this->scorings->update_scoring($this->scoring_id, $add_scoring);

            return $add_scoring;
        }

        if ($result['status'] == 'error') {
            if (json_encode($result['data']) == "No subject found for this inquiry") {
                $add_scoring = array(
                    'body' => '',
                    'status' => 'error',
                    'success' => 0,
                    'string_result' => 'Неуспешный ответ: ' . 'субъект не найден',
                );
            } else {
                $add_scoring = array(
                    'body' => '',
                    'status' => 'error',
                    'success' => 0,
                    'string_result' => 'Неуспешный ответ: ' . json_encode($result['data'], JSON_UNESCAPED_UNICODE)
                );
            }


            $this->scorings->update_scoring($this->scoring_id, $add_scoring);

            return $add_scoring;
        }

        switch ($client_status) {
            case 'nk':
            case 'rep':
                $number_of_active_max = $this->settings->nbki_number_of_active_max_nk;
                $number_of_active = $this->settings->nbki_number_of_active_nk;
                $share_of_unknown = $this->settings->nbki_share_of_unknown_nk;
                $share_of_overdue = $this->settings->nbki_share_of_overdue_nk;
                break;

            case 'pk':
            case 'crm':
                $number_of_active_max = $this->settings->nbki_number_of_active_max_pk;
                $number_of_active = $this->settings->nbki_number_of_active_pk;
                $share_of_unknown = $this->settings->nbki_share_of_unknown_pk;
                $share_of_overdue = $this->settings->nbki_share_of_overdue_pk;
                break;

            default:
                $number_of_active_max = $this->settings->nbki_number_of_active_max_nk;
                $number_of_active = $this->settings->nbki_number_of_active_nk;
                $share_of_unknown = $this->settings->nbki_share_of_unknown_nk;
                $share_of_overdue = $this->settings->nbki_share_of_overdue_nk;
                break;
        }

        //для НБКИ с 0 значением - выставлять как не пройденное_0,5ч https://trello.com/c/usvOm2IY
        if (
            $result['number_of_active'] == 0 &&
            $result['share_of_overdue'] == 0 &&
            $result['share_of_unknown'] == 0 &&
            $result['share_of_overdue'] == 0
            ) {
            $add_scoring = array(
                'status' => 'completed',
                'body' => serialize($result['data']),
                'success' => 0,
                'string_result' => 'все 0'
            );
    
            $this->scorings->update_scoring($this->scoring_id, $add_scoring);
    
            return $add_scoring;
        }
        

        if ($result['number_of_active'] >= $number_of_active_max) {
            $add_scoring = array(
                'status' => 'completed',
                'body' => serialize($result['data']),
                'success' => 0,
                'string_result' => 'превышен допустимый порог активных займов'
            );

            $this->scorings->update_scoring($this->scoring_id, $add_scoring);

            return $add_scoring;
        }

        if ($result['number_of_active'] >= $number_of_active) {
            if ($result['share_of_overdue'] >= $share_of_overdue || $result['share_of_unknown'] >= $share_of_unknown) {
                $add_scoring = array(
                    'status' => 'completed',
                    'body' => serialize($result['data']),
                    'success' => 0,
                    'string_result' => 'превышен допустимый порог доли просроченных или неизвестных займов'
                );

                $this->scorings->update_scoring($this->scoring_id, $add_scoring);

                return $add_scoring;
            }
        }

        if ($result['share_of_unknown'] > $share_of_unknown) {
            $add_scoring = array(
                'status' => 'completed',
                'body' => serialize($result['data']),
                'success' => 0,
                'string_result' => 'превышен допустимый порог доли неизвестных займов'
            );

            $this->scorings->update_scoring($this->scoring_id, $add_scoring);

            return $add_scoring;
        }

        $add_scoring = array(
            'status' => 'completed',
            'body' => serialize($result['data']),
            'success' => 1,
            'string_result' => 'Проверки пройдены'
        );

        $this->scorings->update_scoring($this->scoring_id, $add_scoring);

        return $add_scoring;
    }
}