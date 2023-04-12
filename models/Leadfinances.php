<?php

class Leadfinances extends Core
{
    private $log_dir  = 'logs/';
    private $teamwin_token = 'df59f0bb43e5d3604e14a6022fc26c03723b9826';

    public function send_lead_to_leadfinances($order) {
        $id = $this->save_lead([
            'order_id' => $order->order_id
        ]);

        $this->logging_(__METHOD__, 'save_lead', ['order_id' => $order->order_id], ['id' => $id], 'leadfinances.txt');
        $this->logging_(__METHOD__, 'save_lead', ['order_id' => $order->order_id], ['id' => $id], 'guruleads.txt');
        //$this->logging_(__METHOD__, 'save_lead', ['order_id' => $order->order_id], ['id' => $id], 'teamwin.txt');
        //$this->logging_(__METHOD__, 'save_lead', ['order_id' => $order->order_id], ['id' => $id], 'leadgid.txt');
        //$this->logging_(__METHOD__, 'save_lead', ['order_id' => $order->order_id], ['id' => $id], 'leadia.txt');
        $this->logging_(__METHOD__, 'save_lead', ['order_id' => $order->order_id], ['id' => $id], '123reject.txt');
    }

    public function get_queue_for_sending_via_api($limit = 13) {
        //SELECT * FROM `sales_via_api` WHERE created_at < NOW() - INTERVAL 30 MINUTE LIMIT 13
        $query = $this->db->placehold("
            SELECT * FROM `sales_via_api` WHERE sent IS NULL AND created_at < NOW() - INTERVAL 60 MINUTE LIMIT ?
        ", (int)$limit);
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function get_queue_for_sending_via_api_with_delay($limit = 13) {
        // Интервал в 7 дней для 123reject
        $query = $this->db->placehold("
            SELECT * FROM `sales_via_api` WHERE sent = 2 AND created_at < NOW() - INTERVAL 7 DAY LIMIT ?
        ", (int)$limit);
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function send_lead($order_id) {
        $order = $this->orders->get_order($order_id);

        $this->send_lead_to_leadfinance($order);
        //$this->add_lead_to_teamwin($order);
        // $this->guruleads($order);
        //$this->leadgid($order);
        //$this->leadea($order);
        //$this->reject_ru($order); //из-за делея в 7 дней отправляется отдельным методом
    }

    public function send_lead_reject($order_id) {
        $order = $this->orders->get_order($order_id);

        $this->reject_ru($order); //из-за делея в 7 дней отправляется отдельным методом
    }


    public function save_lead($item)
    {
        $item = (array)$item;

        if (empty($item['created_at'])) {
            $item['created_at'] = date('Y-m-d H:i:s');
        }

        $query = $this->db->placehold("
            INSERT INTO sales_via_api SET ?%
        ", $item);

        $this->db->query($query);
        $id = $this->db->insert_id();

        return $id;
    }

    public function update_lead($id, $item)
    {
        $query = $this->db->placehold("
            UPDATE sales_via_api SET ?% WHERE id = ?
        ", (array)$item, (int)$id);
        $this->db->query($query);

        return $id;
    }

    public function reject_ru($order) {
        $curl = curl_init();

        $city_name = '';
        if ($order->Reglocality) {
            $city_name = $order->Reglocality;
        }

        if ($order->Regcity) {
            $city_name = $order->Regcity;
        }

        if (empty($city_name)) {
            if ($order->Faktlocality) {
                $city_name = $order->Faktlocality;
            }

            if ($order->Faktcity) {
                $city_name = $order->Faktcity;
            }
        }

        $region_name = '';
        if ($order->Faktregion) {
            $region_name = $order->Faktregion;
        }

        if (empty($region_name)) {
            if ($order->Regregion) {
                $region_name = $order->Regregion;
            }
        }

        $data = array(
            'first_name' => $order->firstname,
            'last_name' => $order->lastname,
            'middle_name' => $order->patronymic,
            'phone' => $order->phone_mobile,
            'region' => $region_name,
            'city' => $city_name,
            'birthdate' => date("Y-m-d", strtotime($order->birth))
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.123reject.ru/reject/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 1,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'X-AUTH: 2380272389126408'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        $this->logging_(__METHOD__, 'send_lead', (array)$data, json_decode($response), '123reject.txt');
    }

    public function send_lead_to_leadfinance($order) {
        $token = '97d5488adca24070b182b441e4295dc3';

        $phone = $order->phone_mobile;
        $name = $order->firstname;
        $lastName = $order->lastname;
        $patronymic = $order->patronymic;
        $amount = $order->amount;
        $period = $order->period;

        $birthday = date("Y-m-d", strtotime($order->birth));

        $data = [
            'token' => $token,
            'phone' => '+'.$phone,
            'type' => 1,
            'policy_accept' => 1,
            'mailings_accept' => 1,
            'first_name' => $name,
            'middle_name' => $patronymic,
            'last_name' => $lastName,
            'amount' => $amount,
            'term' => $period,
        ];

        $data['birthday'] = $birthday;//"Y-m-d"

        if (!empty($order->Faktregion)) {
            $data['region_fact'] = $order->Faktregion;
        }

        if (!empty($order->Faktcity)) {
            $data['city_fact'] = $order->Faktcity;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.gate.leadfinances.com/v1/lead/add',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));
        $response = curl_exec($curl);

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        $this->logging_(__METHOD__, 'send_lead', (array)$data, json_decode($response), 'leadfinances.txt');
    }

    public function logging_($local_method, $service, $request, $response, $filename)
    {
        $log_filename = $this->log_dir.$filename;

        if (date('d', filemtime($log_filename)) != date('d'))
        {
            $archive_filename = $this->log_dir.'archive/'.date('ymd', filemtime($log_filename)).'.'.$filename;
            rename($log_filename, $archive_filename);
            file_put_contents($log_filename, "\xEF\xBB\xBF");
        }

        if (isset($request['TextJson']))
            $request['TextJson'] = json_decode($request['TextJson']);
        if (isset($request['ArrayContracts']))
            $request['ArrayContracts'] = json_decode($request['ArrayContracts']);
        if (isset($request['ArrayOplata']))
            $request['ArrayOplata'] = json_decode($request['ArrayOplata']);

        $str = PHP_EOL.'==================================================================='.PHP_EOL;
        $str .= date('d.m.Y H:i:s').PHP_EOL;
        $str .= $service.PHP_EOL;
        $str .= var_export($request, true).PHP_EOL;
        $str .= var_export($response, true).PHP_EOL;
        $str .= 'END'.PHP_EOL;

//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($str);echo '</pre><hr />';

        file_put_contents($this->log_dir.$filename, $str, FILE_APPEND);
    }


    public function add_lead_to_teamwin($order) {
        $firstname = $order->firstname;

        if ($order->passport_serial) {
            $passport = str_replace(array('-', ' '), '', $order->passport_serial);
            $passport_serial = substr($passport, 0, 4);
            $passport_number = substr($passport, 4, 6);
        } else {
            $passport = '';
            $passport_serial = '';
            $passport_number = '';
        }

        if ($order->passport_date) {
            $issued_date = date('Y-m-d', strtotime($order->passport_date));
        } else {
            $issued_date = '';
        }

        $birth = date("Y-m-d", strtotime($order->birth));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ldr.13evl.com/api/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
    "method": "leads.add",
    "params": {
        "phone": "'.$order->phone_mobile.'",
        "api_type_id": 1,
        "data": {
            "site": "finfive.ru",
            "client_ip": "'.$order->ip.'",
            "user_id": "'.$order->user_id.'",
            "product": "PDL",
            "cell_phone": "'.$order->phone_mobile.'",
            "first_name": "'.$firstname.'",
            "last_name": "'.$order->lastname.'",
            "middle_name": "'.$order->patronymic.'",
            "birth_date": "'.$birth.'",
            "agree_with_terms": "Есть согласие",
            "city_fact": "'.$order->Faktcity.'",
            "passport_code": "'.$order->subdivision_code.'",
            "passport_seria": "'.$passport_serial.'",
            "passport_num": "'.$passport_number.'",
            "passport_issued": "'.$order->passport_issued.'",
            "passport_date": "'.$issued_date.'",
            "amount": "'.$order->amount.'",
            "period_days": "'.$order->period.'"

        }
    }
}',
            CURLOPT_HTTPHEADER => array(
                'content-type: application/json',
                'token: '.$this->teamwin_token.''
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        //$this->logging_(__METHOD__, 'send_lead', (array)$data, json_decode($response), 'leadfinances.txt');
        $this->logging_(__METHOD__, 'send_lead', [(array)$order, 'json' => '{
            "method": "leads.add",
            "params": {
                "phone": "'.$order->phone_mobile.'",
                "api_type_id": 1,
                "data": {
                    "site": "finfive.ru",
                    "client_ip": "'.$order->ip.'",
                    "user_id": "'.$order->user_id.'",
                    "product": "PDL",
                    "cell_phone": "'.$order->phone_mobile.'",
                    "first_name": "'.$firstname.'",
                    "last_name": "'.$order->lastname.'",
                    "middle_name": "'.$order->patronymic.'",
                    "birth_date": "'.$birth.'",
                    "agree_with_terms": "Есть согласие",
                    "city_fact": "'.$order->Faktcity.'",
                    "passport_code": "'.$order->subdivision_code.'",
                    "passport_seria": "'.$passport_serial.'",
                    "passport_num": "'.$passport_number.'",
                    "passport_issued": "'.$order->passport_issued.'",
                    "passport_date": "'.$issued_date.'"
                }
            }
        }'], json_decode($response), 'teamwin.txt');

        return [];
    }

    public function guruleads($order) {
        $phone = $order->phone_mobile;
        $name = $order->firstname;
        $lastName = $order->lastname;
        $patronymic = $order->patronymic;

        $birthday = date("Y-m-d", strtotime($order->birth));

        if ($order->passport_serial) {
            $passport = str_replace(array('-', ' '), '', $order->passport_serial);
            $passport_serial = substr($passport, 0, 4);
            $passport_number = substr($passport, 4, 6);
        } else {
            $passport = '';
            $passport_serial = '';
            $passport_number = '';
        }

        if ($order->passport_date) {
            $issued_date = date('Y-m-d', strtotime($order->passport_date));
        } else {
            $issued_date = '';
        }

        $registration_city_name = '';
        if ($order->Reglocality) {
            $registration_city_name = $order->Reglocality;
        }

        if ($order->Regcity) {
            $registration_city_name = $order->Regcity;
        }

        if (empty($registration_city)) {
            if ($order->Faktlocality) {
                $registration_city_name = $order->Faktlocality;
            }

            if ($order->Faktcity) {
                $registration_city_name = $order->Faktcity;
            }
        }

        $data = [
            'email' => $order->email,
            'last_name' => $lastName,
            'first_name' => $name,
            'middle_name' => $patronymic,
            'gender' => $order->gender,
            'phone' => $phone,
            'birthday' => $birthday,
            'birthplace' => $order->birth_place,
            'passport_series' => $passport_serial,
            'passport_number' => $passport_number,
            'passport_issued_by' => $order->passport_issued,
            'passport_issued_date' => $issued_date,
            'passport_unit_code' => $order->subdivision_code,
            'registration_region_name' => $order->Regregion,
            'registration_city_name' => $registration_city_name,//$order->Regcity,
            'registration_street_name' => $order->Regstreet,
            'registration_house' => $order->Reghousing,

            'credit_amount' => $order->amount,
            'credit_duration' => $order->period,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.guruleads.ru/1.0/leads/multi?access-token=7d72be4196e659a20752a181820aab06',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));
        $response = curl_exec($curl);

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        $this->logging_(__METHOD__, 'send_lead', (array)$data, json_decode($response), 'guruleads.txt');
    }

    public function leadgid($order) {
        $phone = $order->phone_mobile;
        $name = $order->firstname;
        $lastName = $order->lastname;
        $patronymic = $order->patronymic;

        $birthday = date("Y-m-d", strtotime($order->birth));

        if ($order->passport_serial) {
            $passport = str_replace(array('-', ' '), '', $order->passport_serial);
            $passport_serial = substr($passport, 0, 4);
            $passport_number = substr($passport, 4, 6);
        } else {
            $passport = '';
            $passport_serial = '';
            $passport_number = '';
        }

        if ($order->passport_date) {
            $issued_date = date('Y-m-d', strtotime($order->passport_date));
        } else {
            $issued_date = '';
        }

        $phone = substr($phone, 1);

        $data = [
            'email' => $order->email,
            'last_name' => $lastName,
            'first_name' => $name,
            'patronymic' => $patronymic,
            'gender' => $order->gender,
            'phone' => $phone,
            'passport' => $passport_serial.$passport_number,
            'amount' => $order->amount,
            'term' => $order->period,
            'birth_date' => $birthday,
            'passport_issued_by' => $order->passport_issued,
            'passport_issue_date' => $issued_date,
            'passport_unit_code' => $order->subdivision_code,


            //'birthplace' => $order->birth_place,
            //'passport_series' => $passport_serial,
            //'passport_number' => $passport_number,


            //'registration_region_name' => $order->Regregion,
            //'registration_city_name' => isset($order->Regcity) ? $order->Regcity : $order->Reglocality,//$order->Regcity,
            //'registration_street_name' => $order->Regstreet,
            //'registration_house' => $order->Reghousing,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.leadgid.com/universal/v1/ru/applications',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                'X-ACCOUNT-TOKEN: '.'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJpc3MiOiJhdXRoLmxlYWRnaWQiLCJpYXQiOjE2NDI0MTkwMTMsImV4cCI6MjkwNDcyMzAxMywidXNlcl9pZCI6NDk1MzAsInVzZXJfZW1haWwiOiJwcml6bWF6YWltQHlhbmRleC5ydSIsImFjY291bnRfdHlwZSI6ImFmZmlsaWF0ZSIsImFjY291bnRfaWQiOjc3MjM4LCJmaXJzdF9uYW1lIjoiXHUwNDFkXHUwNDMwXHUwNDNiXHUwNDM4XHUwNDQ3XHUwNDNkXHUwNDNlXHUwNDM1IiwibGFzdF9uYW1lIjoiXHUwNDFmXHUwNDNiXHUwNDRlXHUwNDQxIn0.oY4eLCL1ZgOA0cZbpSpasU9uFnoXLLWb5Q3Fjaz_e0fMucUcsJzDEx1EhTf7rJ3LZCtZBwmDK93GBcSUXsvsD8R1HFrJ8D4JklsZzkeILbxh2Cp5ebz24uWyvLe1xf2i1NaZgyUvymUdkPwX_2MHteCbcz3WkZFNSWw71lWyCsM246Par_-EZOA4Nhkk0q46imp820pYCgmf6DfbTL_DZETCACWRD0MDSBUOrtVfxtVDo6oii3Lpue2r9jUEuVDWCA8rqstgirAXtNdQwrvJ4P3loigyAT5rwuwasi7d7j5IAMGXKa5Pup_XeUK4gTx7XBrdQ5kyeluMUpg1y7M8aw'
              ),
        ));
        $response = curl_exec($curl);

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        $this->logging_(__METHOD__, 'send_lead', (array)$data, json_decode($response), 'leadgid.txt');
    }

    public function leadea($order) {
        $phone = $order->phone_mobile;
        $name = $order->firstname;
        $lastName = $order->lastname;
        $patronymic = $order->patronymic;

        $birthday = date("Y-m-d", strtotime($order->birth));

        if ($order->passport_serial) {
            $passport = str_replace(array('-', ' '), '', $order->passport_serial);
            $passport_serial = substr($passport, 0, 4);
            $passport_number = substr($passport, 4, 6);
        } else {
            $passport = '';
            $passport_serial = '';
            $passport_number = '';
        }

        if ($order->passport_date) {
            $issued_date = date('Y-m-d', strtotime($order->passport_date));
        } else {
            $issued_date = '';
        }

        $curl = curl_init();

        $registration_city = '';
        if ($order->Reglocality) {
            $registration_city = $order->Reglocality;
        }

        if ($order->Regcity) {
            $registration_city = $order->Regcity;
        }

        if (empty($registration_city)) {
            if ($order->Faktlocality) {
                $registration_city = $order->Faktlocality;
            }

            if ($order->Faktcity) {
                $registration_city = $order->Faktcity;
            }
        }

        $form_data = [
            "amount" => $order->amount,
            "term_days" => $order->period,
            "first_name" => $name,
            "last_name" => $lastName,
            "patronymic" => $patronymic,
            "birth_date" => $birthday,
            "cell_phone" => '+7 (' .$phone[1].$phone[2].$phone[3]. ') ' .$phone[4].$phone[5].$phone[6]. '-' .$phone[7].$phone[8].$phone[9].$phone[10],//"+7 (978) 890-9514",
            "email" => $order->email,
            "argee_with_terms" => 1,
            "passport_date" => $issued_date,
            "income_type" => "ШТАТНЫЙ СОТРУДНИК",
            "registration_city" => $registration_city,
            "passport_seria" => $passport_serial,
            "passport_num" => $passport_number,
            "passport_issued" => $order->passport_issued,
            "passport_date" => $issued_date,
            "passport_kod" => $order->subdivision_code,
            "registration_region" => isset($order->Regregion) ? $order->Regregion : $order->Faktregion,
            "registration_street" => isset($order->Regstreet) ? $order->Regstreet : '',
            "registration_housenum" => isset($order->Reghousing) ? $order->Reghousing : ''
         ];

        $data = array(
            'form_page' => 'http://finfive.ru/',
            'client_ip' => $order->ip,
            'userid' => '15243',
            'product' => 'paydayru',
            'template' => 'default',
            'key' => '',

            'form_data_json' => json_encode($form_data,  JSON_PRETTY_PRINT),

            'first_last_name' => "{$name} {$lastName}",
            'phone' => '+'. $phone,
            'email' => $order->email,
            'region' => isset($order->Faktregion) ? $order->Faktregion : $order->Regregion,
            'question' => "{$name} {$lastName} Сумма: {$order->amount} р. Срок: {$order->period} дней."
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://cloud1.leadia.org/lead.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            )
        );

        $response = curl_exec($curl);


        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        $this->logging_(__METHOD__, 'send_lead', (array)$data, json_decode($response), 'leadia.txt');
    }
}