<?php

class Reminders extends Core
{
    public function get_list_until_due_date($days, $limit = 1000) {
        $query = $this->db->placehold("
            SELECT * FROM __contracts
            WHERE status = 2
            and sold = 0
            and premier = 0
            AND prolongation < 1
            AND (days_until_due_date_reminded > ? OR days_until_due_date_reminded is NULL OR days_until_due_date_reminded = 0)
            AND date(return_date) = CURDATE() + INTERVAL ? day
            LIMIT ?
        ", (int)$days, (int)$days, $limit);
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function get_list_since_approval($days, $limit = 1000) {
        //            and (days_since_approval < ? or days_since_approval is NULL)
        $query = $this->db->placehold("
            SELECT id, user_id, date, status ,approve_date, amount FROM `s_orders` where status = 2 

            AND approve_date > DATE_SUB(CURDATE(), INTERVAL ? day)
            AND approve_date < DATE_SUB(CURDATE(), INTERVAL ? - 1  day)
            LIMIT ?
        ", (int)$days, (int)$days, $limit);
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function get_list_without_a_loan($days, $limit = 1000) {
        $query = $this->db->placehold("
            SELECT o1.id, o1.amount, o1.user_id, o1.status, c.number, c.close_date FROM s_orders o1
            LEFT JOIN s_orders o2 ON (o1.user_id = o2.user_id AND o1.date < o2.date)
            LEFT JOIN s_contracts c ON (o1.contract_id = c.id)
            WHERE o2.id IS NULL
            and o1.status = 7
            and (o1.days_without_a_loan < ? or o1.days_without_a_loan is NULL)
            AND c.close_date > DATE_SUB(CURDATE(), INTERVAL ? day)
            AND c.close_date < DATE_SUB(CURDATE(), INTERVAL ? - 1  day)
            LIMIT ?
        ", (int)$days, (int)$days, (int)$days, $limit);
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function get_list_abandoned_orders($amount_of_time, $measure_of_time = 'minutes', $limit = 1000) {
        if ($measure_of_time == 'minutes') {
            $query = $this->db->placehold("
                SELECT * FROM `s_users`
                where stage_card != 1
                AND stage_personal != 0
                AND stage_personal_date != 0
                and (minutes_abandoned_order < ? or minutes_abandoned_order is NULL)
                and days_abandoned_order is NULL
                AND last_activity < UNIX_TIMESTAMP() - ?
                AND last_activity > UNIX_TIMESTAMP() - ? - 600
                LIMIT ?
            ", $amount_of_time, (int)$amount_of_time * 60, (int)$amount_of_time * 60, $limit);
            $this->db->query($query);
            $result = $this->db->results();

            return $result;
        } elseif ($measure_of_time == 'days') {
            $query = $this->db->placehold("
                SELECT * FROM `s_users`
                where stage_card != 1
                AND stage_personal != 0
                AND stage_personal_date != 0
                and (days_abandoned_order < ? or days_abandoned_order is NULL)
                AND FROM_UNIXTIME(last_activity) > DATE_SUB(CURDATE(), INTERVAL ? day)
                AND FROM_UNIXTIME(last_activity) < DATE_SUB(CURDATE(), INTERVAL ? - 1  day)
                LIMIT ?
            ", (int)$amount_of_time, (int)$amount_of_time, (int)$amount_of_time, $limit);
            $this->db->query($query);
            $result = $this->db->results();

            return $result;
        }
    }

    

    public function moment_of_redemption($order_id) {
        $order = $this->orders->get_order($order_id);
        //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($order);echo '</pre><hr />';
        //exit;
        $data['имя'] = $order->firstname;
        $data['номер'] = '';
        $data['сумма'] = $order->amount;
        $data['days_or_minutes'] = 0;
        $data['user_id'] = $order->user_id;
        $data['type'] = 'moment_of_redemption';

        $data['firstname'] = $order->firstname;
        $data['amount'] = $order->amount;
        $data['credit'] = $order->amount;

        $contract = $this->contracts->get_contract($order->contract_id);

        if (!empty($contract)) {
            $data['payment'] = $contract->loan_body_summ + $contract->loan_percents_summ + $contract->loan_charge_summ + $contract->loan_peni_summ;
            $data['percent'] = $contract->loan_percents_summ;
            $data['payday'] =  date("d-m-Y", strtotime($contract->return_date));
            $data['contract'] = $contract->number;
        }

        $data['crd+'] = $order->amount;

        $data['loanid'] = $order_id;

        $days_without_a_loan = $this->settings->days_without_a_loan;
        if(isset($days_without_a_loan['sms']['0'])) {
            $this->send_sms($order->phone_mobile, $days_without_a_loan['sms']['0'], $data);
        }
    }

    public function send_sms($phone, $template, $data, $test = 0) {
        $message =  preg_replace('/{имя}/',   $data['имя'], $template, -1, $count);//из шаблонов
        $message =  preg_replace('/{номер}/', $data['номер'], $message, -1, $count);//из шаблонов
        $message = preg_replace('/{сумма}/',  (int) $data['сумма'], $message, -1, $count);//из шаблонов

        if (isset($data['accept_code'])) {
            $message = preg_replace('/{accept_code}/',  (int) $data['accept_code'], $message, -1, $count);//из шаблонов
        }

        $message = strtr($message, [
            '{$firstname}' => isset($data['firstname']) ? $data['firstname'] : '',
        
            '{$amount}' => isset($data['amount']) ? $data['amount'] : '',
            '{$credit}' => isset($data['credit']) ? $data['credit'] : '',
    
            '{$payment}' => isset($data['payment']) ? $data['payment'] : '',
            '{$percent}' => isset($data['percent']) ? $data['percent'] : '',
            '{$payday}' => isset($data['payday']) ? $data['payday'] : '',
            '{$contract}' => isset($data['contract']) ? $data['contract'] : '',
            '{$loanid}' => isset($data['loanid']) ? $data['loanid'] : '',
        
            '{$crd1000}' => isset($data['crd+']) ? $data['crd+'] + 1000 : '',
            '{$crd2000}' => isset($data['crd+']) ? $data['crd+'] + 2000 : '',
            '{$crd3000}' => isset($data['crd+']) ? $data['crd+'] + 3000 : '',
            '{$crd4000}' => isset($data['crd+']) ? $data['crd+'] + 4000 : '',
            '{$crd5000}' => isset($data['crd+']) ? $data['crd+'] + 5000 : '',
            '{$crd6000}' => isset($data['crd+']) ? $data['crd+'] + 6000 : '',
            '{$crd7000}' => isset($data['crd+']) ? $data['crd+'] + 7000 : '',
            '{$crd8000}' => isset($data['crd+']) ? $data['crd+'] + 8000 : '',
            '{$crd9000}' => isset($data['crd+']) ? $data['crd+'] + 9000 : '',
            '{$crd10000}' => isset($data['crd+']) ? $data['crd+'] + 10000 : '',
        ]);

        //$result = $this->sms->send($phone, $message, 0, 'FINFIVE');

        if ($test === 'test') {
            return $this->test_save_sms(
                [
                    'phone' => $phone,
                    'template' => $template,
                    'days_or_minutes' => $data['days_or_minutes'],
                    'type' => $data['type'],
                    'firstname' => $data['имя'],
                    'number' => $data['номер'],
                    'amount' => $data['сумма'],
                    'user_id' => $data['user_id']
                ]
            );
        } elseif($test === 0) {
            $id = $this->save_sms(
                [
                    'phone' => $phone,
                    'template' => $template,
                    'days_or_minutes' => $data['days_or_minutes'],
                    'type' => $data['type'],
                    'firstname' => $data['имя'],
                    'number' => $data['номер'],
                    'amount' => $data['сумма'],
                    'user_id' => $data['user_id']
                ]);

            $result = $this->sms->send($phone, $message, 0, 'FINFIVE');

            return $id;
        }
    }

    private function save_sms($item)
    {
        $item = (array)$item;

        if (empty($item['created_at'])) {
            $item['created_at'] = date('Y-m-d H:i:s');
            //$item['updated_at'] = date('Y-m-d H:i:s');
        }

        $query = $this->db->placehold("
            INSERT INTO reminders_logs SET ?%
        ", $item);
        $this->db->query($query);
        $id = $this->db->insert_id();

        return $id;
    }

    private function test_save_sms($item)
    {
        $item = (array)$item;

        if (empty($item['created_at'])) {
            $item['created_at'] = date('Y-m-d H:i:s');
            //$item['updated_at'] = date('Y-m-d H:i:s');
        }

        $query = $this->db->placehold("
            INSERT INTO test_reminders_logs SET ?%
        ", $item);
        $this->db->query($query);
        $id = $this->db->insert_id();

        return $id;
    }

    public function get_users_days_abandoned_order() {
        $query = $this->db->placehold("
            SELECT * FROM `s_users` where days_abandoned_order is not null
        ");
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function get_users_minutes_abandoned_order() {
        $query = $this->db->placehold("
            SELECT * FROM `s_users` where minutes_abandoned_order is not null
        ");
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function get_orders_days_without_a_loan() {
        $query = $this->db->placehold("
            SELECT * FROM `s_orders` WHERE days_without_a_loan is not null
        ");
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function get_contracts_days_until_due_date_reminded() {
        $query = $this->db->placehold("
            SELECT * FROM `s_contracts` WHERE `days_until_due_date_reminded` is not NULL
        ");
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }

    public function get_reminders($filter = array())
    {
        $date_filter = '';

        if(isset($filter['date_from']))
            $date_filter = $this->db->placehold("AND created_at BETWEEN ? AND ?", $filter['date_from'], $filter['date_to']);

        $query = $this->db->placehold("
            SELECT `type`, days_or_minutes,
            COUNT(case when `type` = 'due_date_reminder' then `type` ELSE NULL END) due_date_reminder,
            COUNT(case when `type` = 'days_until_due_date_remin' then `type` ELSE NULL END) days_until_due_date_remin,
            COUNT(case when `type` = 'days_without_a_loan' then `type` ELSE NULL END) days_without_a_loan,
            COUNT(case when `type` = 'moment_of_redemption' then `type` ELSE NULL END) moment_of_redemption,
            COUNT(case when `type` = 'days_since_approval' then `type` ELSE NULL END) days_since_approval
            FROM reminders_logs
            WHERE 1
            $date_filter
            GROUP BY `type`, days_or_minutes
        ");
        $this->db->query($query);
        $result = $this->db->results();

        return $result;
    }
}