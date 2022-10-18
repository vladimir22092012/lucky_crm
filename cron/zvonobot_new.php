<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class ZvonobotNewCron extends Core
{
    private $sms_texts;
    private $records;
    private $records_texts;

    public function __construct()
    {
        parent::__construct();

        $this->sms_texts = [
            1 => [
                0 => "Уважаемый клиент, напоминаем, что сегодня дата оплаты по вашему договору займа. ООО «ЮК №1». 88002225973",
                1 => "Срочно погасите просроченную задолженность! Вся информация в личном кабинете: yk1.{\$payment_link} ООО \"ЮК №1\" 88002225973",
                2 => "Срочно погасите просроченную задолженность! Вся информация в личном кабинете: yk1.{\$payment_link} ООО \"ЮК №1\" 88002225973",
            ],
            0 => [
                0 => "Уважаемый клиент, напоминаем, что сегодня дата оплаты по вашему договору займа. finfive.ru/go/pay ООО МКК «Наличное +» 88003331360",
                1 => "Срочно погасите просроченную задолженность! Вся информация в личном кабинете: {\$payment_link} ООО МКК \"На личное +\" 88003331360",
                2 => "Срочно погасите просроченную задолженность! Вся информация в личном кабинете: {\$payment_link} ООО МКК \"На личное +\" 88003331360",
            ],
        ];

        $this->records = [
            1 => [
                0 => 812860,
                1 => 1290123,
                2 => 812868,
            ],
            0 => [
                0 => 812862,
                1 => 1283472,
                2 => 812870,
            ],
        ];

        $this->records_texts = [
            812860 => 'Здравствуйте, Юридическая компания №1. Напоминаем, сегодня дата оплаты по вашему договору займа. По имеющимся вопросам звоните 8 800 222 60 91',
            1290123 => 'Здравствуйте, Юридическая компания №1. Уведомляем о наличии просроченной задолженности по вашему договору займа. Не нарушайте принятые вами условия договора. По всем имеющимся вопросам звоните 8 800 222 59 73',
            812868 => 'Здравствуйте, Юридическая компания №1.  Уведомляем о наличии просроченной задолженности по вашему договору займа. Не нарушайте принятые вами условия договора. По всем имеющимся вопросам звоните 8 800 222 60 91',
            812862 => 'Здравствуйте, Микрокредитная компания Наличное плюс. Напоминаем, сегодня дата оплаты по вашему договору займа. По имеющимся вопросам звоните 8 800 333 24 84',
            1283472 => 'Здравствуйте, Микрокредитная компания Наличное плюс. Уведомляем о наличии просроченной задолженности по вашему договору займа. Не нарушайте принятые вами условия договора. По всем имеющимся вопросам звоните 800 333 13 60',
            812870 => 'Здравствуйте, Микрокредитная компания Наличное плюс. Уведомляем о наличии просроченной задолженности по вашему договору займа.  Не нарушайте принятые вами условия договора. По всем имеющимся вопросам звоните 800 333 24 84',
        ];

        $code = $this->helpers->c2o_encode(106503);
        $payment_link = parse_url($this->config->front_url, PHP_URL_HOST).'/pay/'.$code;
        $sms = str_replace('{$payment_link}', $payment_link, $this->sms_texts[1][1]);

        echo $sms;

        $this->run_calls();
    }

    private function run_calls()
    {
        if ($contracts = $this->contracts->get_contracts(['collection_status' => 2])) {
            foreach ($contracts as $contract) {
                $contract->user = $this->users->get_user($contract->user_id);
                $contract->calls = $this->zvonobot->get_zvonobots(['contract_id' => $contract->id, 'create_date' => date('Y-m-d')]);
                $contract->messages = $this->get_automatic_sms(['contract_id' => $contract->id, 'create_date' => date('Y-m-d')]);

                $check_communications = $this->communications->check_user($contract->user_id);

                $client_time = $this->helpers->get_regional_time($contract->user->Regregion);
                $client_time_warning = $this->users->get_time_warning($client_time);

                if (empty($contract->premier) && $check_communications && empty($client_time_warning)) {
                    //TODO
                    $sms_texts = $this->sms_texts;
                    $records = $this->records;

                    $now = new DateTime('today');

                    $date = DateTime::createFromFormat("Y-m-d H:i:s", $contract->return_date);
                    $date->setTime(0, 0, 0);

                    $interval = $now->diff($date);
                    $days = abs((integer) $interval->format("%R%a"));

                    switch ($days) {
                        case 0:
                            $is_wait_sms = 0;
                            $is_wait_zvonobot = 0;

                            $sms = $sms_texts[$contract->sold][$days];
                            $record_id = $records[$contract->sold][$days];
                            break;
                        case 1:
                            $is_wait_sms = 0;
                            $is_wait_zvonobot = 1;

                            $sms = $sms_texts[$contract->sold][$days];
                            $record_id = $records[$contract->sold][$days];
                            break;
                        case 2:
                            $is_wait_sms = 1;
                            $is_wait_zvonobot = 0;

                            $sms = $sms_texts[$contract->sold][$days];
                            $record_id = $records[$contract->sold][$days];
                            break;

                        default:
                            $is_wait_sms = 0;
                            $is_wait_zvonobot = 0;

                            $sms = $sms_texts[$contract->sold][1];
                            $record_id = $records[$contract->sold][1];
                            break;
                    }

                    echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contract->id);echo '</pre><hr />';
                    echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contract->return_date, $days);echo '</pre><hr />';
                    echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($is_wait_sms, $is_wait_zvonobot);echo '</pre><hr />';
                    
                    //exit;

                    if ($is_wait_sms && empty($contract->messages)) {
                        $code = $this->helpers->c2o_encode($contract->id);
                        $payment_link = parse_url($this->config->front_url, PHP_URL_HOST).'/pay/'.$code;

                        $sms = str_replace('{$payment_link}', $payment_link, $sms);

                        $this->notify_by_sms($contract, $sms);
                        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($sms);echo '</pre><hr />';
                    }

                    if ($is_wait_zvonobot && empty($contract->calls)) {
                        $this->notify_by_zvonobot($contract, $record_id);
                        $this->set_count_calls($contract);
                        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($record_id);echo '</pre><hr />';
                    }

                    sleep(1);
                }
            }
        }
    }

    private function notify_by_sms($contract, $sms)
    {
        $sms_result = $this->sms->send($contract->user->phone_mobile, $sms, $contract->sold);

        $sms_id = $this->add_automatic_sms([
            'user_id' => $contract->user->id,
            'contract_id' => $contract->id,
            'yuk' => $contract->sold,
            'zvonobot_id' => null,
            'status' => 'create',
            'body' => serialize($sms_result),
            'create_date' => date('Y-m-d H:i:s'),
            'phone' => $contract->user->phone_mobile,
        ]);

        $this->communications->add_communication([
            'user_id' => $contract->user->id,
            'order_id' => $contract->order_id,
            'manager_id' => 100,
            'type' => 'sms',
            'from_number' => $this->sms->get_originator($contract->sold),
            'to_number' => $contract->user->phone_mobile,
            'created' => date('Y-m-d H:i:s'),
            'outer_id' => $sms_id,
            'content' => $sms,
            'yuk' => $contract->sold,
            'result' => serialize($sms_result),
        ]);

        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contract, $sms_result);echo '</pre><hr />';
    }

    private function notify_by_zvonobot($contract, $record_id)
    {
        $resp = $this->zvonobot->call(
            $contract->user->phone_mobile,
            $record_id,
            $contract->sold
        );

        $zvonobot_id = $this->zvonobot->add_zvonobot([
            'user_id' => $contract->user->id,
            'contract_id' => $contract->id,
            'yuk' => $contract->sold,
            'zvonobot_id' => isset($resp['data'][0]['id']) ? $resp['data'][0]['id'] : null,
            'status' => isset($resp['data'][0]['status']) ? $resp['data'][0]['status'] : 'new',
            'body' => serialize($resp),
            'create_date' => date('Y-m-d H:i:s'),
            'phone' => $contract->user->phone_mobile,
        ]);


        $this->communications->add_communication([
            'user_id' => $contract->user->id,
            'order_id' => $contract->order_id,
            'manager_id' => 100,
            'created' => date('Y-m-d H:i:s'),
            'type' => 'zvonobot',
            'content' => $this->records_texts[$record_id],
            'outer_id' => $zvonobot_id,
            'from_number' => $contract->sold ? $this->settings->apikeys['zvonobot_yuk']['outgoingPhone'] : $this->settings->apikeys['zvonobot']['outgoingPhone'],
            'to_number' => $contract->user->phone_mobile,
            'yuk' => $contract->sold,
            'result' => serialize($resp),
        ]);

        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($contract, $resp);echo '</pre><hr />';
    }

    private function set_count_calls($contract)
    {
        /**
         * Фиксируем дату звонка без увеличения счетчика
         */

        $counter = $contract->user->notify_counter;
        $now = new DateTime(); // текущее время на сервере

        //первый запуск счетчика
        if (is_null($counter)) {
            $counter = ['zvonobot' => [
                'month' => ['number' => $now->format('m'), 'count' => 0],
                'week' => ['number' => $now->format('W'), 'count' => 0],
                'day' => ['number' => $now->format('z'), 'count' => 0],
                'last_call' => $now->format('Y-m-d H:i:s')
            ]];
        } else {
            $counter = json_decode($counter, true);

            $counter['zvonobot']['last_call'] = $now->format('Y-m-d H:i:s');
        }


        //преобразуем в json перед сохранением в бд
        $counter = json_encode($counter);

        $this->users->update_user($contract->user_id, array('notify_counter' => $counter));
    }

    private function add_automatic_sms($sms)
    {
        $query = $this->db->placehold("
            INSERT INTO __automatic_sms SET ?%
        ", (array)$sms);
        $this->db->query($query);
        $id = $this->db->insert_id();
        
        return $id;
    }

    private function get_automatic_sms($filter = array())
    {
		$id_filter = '';
		$contract_id_filter = '';
        $status_filter = '';
        $create_date_filter = '';
        $keyword_filter = '';
        $limit = 1000;
		$page = 1;
        $sort = 'z.id ASC';
        
        if (!empty($filter['sort']))
        {
            switch ($filter['sort']):
                
                case 'date_desc':
                    $sort = 'z.create_date DESC';
                break;
                
                case 'date_asc':
                    $sort = 'z.create_date ASC';
                break;
                
                case '':
                    $sort = '';
                break;
                
                case '':
                    $sort = '';
                break;
                
            endswitch;
        }
        
        if (!empty($filter['id']))
            $id_filter = $this->db->placehold("AND z.id IN (?@)", array_map('intval', (array)$filter['id']));
        
        if (!empty($filter['contract_id']))
            $contract_id_filter = $this->db->placehold("AND z.contract_id IN (?@)", array_map('intval', (array)$filter['contract_id']));
        
        if (!empty($filter['status']))
            $status_filter = $this->db->placehold("AND z.status IN (?@)", array_map('strval', (array)$filter['status']));
        
		if (!empty($filter['create_date']))
            $create_date_filter = $this->db->placehold("AND DATE(z.create_date) = ?", $filter['create_date']);
        
        if(isset($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND (z.name LIKE "%'.$this->db->escape(trim($keyword)).'%" )');
		}
        
		if(isset($filter['limit']))
			$limit = max(1, intval($filter['limit']));

		if(isset($filter['page']))
			$page = max(1, intval($filter['page']));
            
        $sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);

        $query = $this->db->placehold("
            SELECT * 
            FROM __automatic_sms AS z
            WHERE 1
                $id_filter
                $contract_id_filter
				$create_date_filter
                $status_filter
                $keyword_filter
            ORDER BY $sort
            $sql_limit
        ");
        $this->db->query($query);
        $results = $this->db->results();
        
        return $results;
	}
}
new ZvonobotNewCron();
