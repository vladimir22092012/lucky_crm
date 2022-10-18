<?php
error_reporting(-1);
ini_set('display_errors', 'On');

/*
    Проверка транзакций сервиса коротких ссылок для юзеров из 1с
*/

chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class CheckShortPaymentsCron extends Core
{
    public function __construct()
    {
        parent::__construct();

        $this->run();
    }

    private function run()
    {
        $from_time = date('Y-m-d H:00:00', time() - 24 * 3600);
        $to_time = date('Y-m-d H:00:00', time() - 2 * 3600);

        //$from_time = '2021-07-30 06:00:00';
        //$to_time = '2021-07-31 06:00:00';

        $query = $this->db->placehold("
            SELECT *
            FROM __transactions_via_short_link
            WHERE (callback_response = '' OR callback_response is NULL)
            AND sended != 1
            AND sector != 7184
            AND sector != 8303
            AND created >= ?
            AND created <= ?
            ORDER BY id DESC
        ", $from_time, $to_time);
        echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($query);echo '</pre><hr />';

        $this->db->query($query);
        if ($transactions = $this->db->results()) {
            echo 'COUNT: ' . count($transactions) . '<br />';
            foreach ($transactions as $t) {
                if (!empty($t->register_id)) {
                    $this->payment_action($t->register_id);
                    usleep(100000);
                    echo __FILE__ . ' ' . __LINE__ . '<br /><pre>';
                    var_dump($t);
                    echo '</pre><hr />';
                }
            }
        }
    }

    public function payment_action($register_id)
    {
        $operation = '';
        //$reference = $this->request->get('reference', 'integer');
        //$error = $this->request->get('error', 'integer');
        //$code = $this->request->get('code', 'integer');
        $sector = $this->best2pay->get_sector('PAYMENT');

        if (!empty($register_id)) {
            $query = $this->db->placehold("
                SELECT * 
                FROM __transactions_via_short_link
                WHERE register_id = ?
            ", (int)$register_id);
            
            $this->db->query($query);
            $transaction = $this->db->result();

            if ($transaction) {
                // TODO: сделать запрос в бест2пей и получить успешную операцию
                if (empty($operation)) {
                    $register_info = $this->best2pay->get_register_info($transaction->sector, $register_id);
                    $xml = simplexml_load_string($register_info);

                    foreach ($xml->operations as $xml_operation) {
                        if ($xml_operation->operation->state == 'APPROVED') {
                            $operation = (string)$xml_operation->operation->id;
                        }
                    }
                }

                if (!empty($operation)) {
                    $operation_info = $this->best2pay->get_operation_info($transaction->sector, $register_id, $operation);
                    $xml = simplexml_load_string($operation_info);
                    $operation_reference = (string)$xml->reference;
                    $reason_code = (string)$xml->reason_code;
                    $payment_amount = strval($xml->amount) / 100;
                    $amount = $xml->amount;
                    $operation_date = date('Y-m-d H:i:s', strtotime(str_replace('.', '-', (string)$xml->date)));
                    //echo __FILE__.' '.__LINE__.'<br /><pre>';echo(htmlspecialchars($operation_info));echo '</pre><hr />';

                    if ($reason_code == 1) {
                        $query = $this->db->placehold("
                            SELECT * 
                            FROM __users_from_one_s
                            WHERE id = ?
                        ", (int)$transaction->user_id);

                        $this->db->query($query);
                        $user_from_one_s = $this->db->result();
                    
                        $amount = $user_from_one_s->amount - $payment_amount;

                        //отправка в 1с оплаты
                        $request = [
                            'uid' => $user_from_one_s->uid,
                            'number_of_contract' => $user_from_one_s->number_of_contract,
                            'date' => (string)$xml->date,
                            'register_id' => $register_id,
                            'operation_id' => $operation,
                            'organisation' => $user_from_one_s->organisation,
                            'amount' => $xml->amount,
                        ];

                        $result = $this->soap1c->_send_payment_($request);

                        /*
                            $query = $this->db->placehold("
                                UPDATE __users_from_one_s SET ?% WHERE id = ?
                            ", array(
                                'amount' => $amount
                            ), (int)$transaction->user_id);

                            $this->db->query($query);
                        */
                        
                        $meta_title = 'Оплата прошла успешно';

                        if ($result->return == 'Оплата зафиксирована') {
                            $query = $this->db->placehold("
                                UPDATE __transactions_via_short_link SET ?% WHERE id = ?
                            ", array(
                                'sended' => 1,
                                'sended_date' => date('Y-m-d H:i:s'),
                            ), (int)$transaction->id);

                            $this->db->query($query);
                        }
                    } else {
                        $reason_code_description = $this->best2pay->get_reason_code_description($reason_code);

                        $meta_title = 'Не удалось оплатить';
                    }

                    $query = $this->db->placehold("
                        UPDATE __transactions_via_short_link SET ?% WHERE id = ?
                    ", array(
                        'operation' => $operation,
                        'callback_response' => $operation_info,
                        'reason_code' => $reason_code
                    ), (int)$transaction->id);

                    $this->db->query($query);
                } else {
                    $callback_response = $this->best2pay->get_register_info($transaction->sector, $register_id, $operation);

                    $query = $this->db->placehold("
                        UPDATE __transactions_via_short_link SET ?% WHERE id = ?
                    ", array(
                        'operation' => 0,
                        'callback_response' => $callback_response
                    ), (int)$transaction->id);

                    $this->db->query($query);

                    //echo __FILE__.' '.__LINE__.'<br /><pre>';echo(htmlspecialchars($callback_response));echo '</pre><hr />';
                    $meta_title = 'Не удалось оплатить';
                }
            } else {
                $meta_title = 'Ошибка: Транзакция не найдена';
            }
        } else {
            $meta_title = 'Ошибка запроса';
        }
        //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($_GET);echo '</pre><hr />';
    }
}

new CheckShortPaymentsCron();
