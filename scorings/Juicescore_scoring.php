<?php

class Juicescore_scoring extends Core
{
    private $user_id;
    private $order_id;
    private $audit_id;
    private $type;

    private $key = '';
    private $url = 'https://api.juicyscore.com/getscore/';

    public function __construct()
    {
        parent::__construct();

        $this->key = 'D0xu3UVNtj49KHioXv68r66bmCCXjb';
    }

    public function run_scoring($scoring_id)
    {
        $update = array();

        $scoring_type = $this->scorings->get_type('juicescore');

        if ($scoring = $this->scorings->get_scoring($scoring_id))
        {
            if ($order = $this->orders->get_order((int)$scoring->order_id))
            {
                if (empty($order->juicescore_session_id))
                {
                    $update = array(
                        'status' => 'error',
                        'string_result' => 'в заявке не найден идентификатор сессии juicescore'
                    );
                }
                else
                {

                    if ($json_result = $this->getscore($order->order_id))
                    {
                        $result = (array)json_decode($json_result);

                        if (!empty($result['Success']))
                        {
                            $reject = 0;

                            if($result['AntiFraud score'] < $scoring_type->params['scorebal']
                                || $result['Predictors']['IDX1 Stop Markers'] <= 2
                                || $result['Predictors']['IDX2 User Behaviour Markers'] <= 4 )
                                $reject = 1;

                            $update = array(
                                'status' => 'completed',
                                'body' => serialize($result),
                                'success' => $reject,
                                'string_result' => ($reject == 0) ? 'Проверка не пройдена' : 'Проверка пройдена',
                            );

                        }
                        else
                        {
                            $update = array(
                                'status' => 'error',
                                'string_result' => 'При запросе произошла ошибка',
                                'body' => serialize($result),
                                'success' => 0
                            );

                        }
                    }
                    else
                    {
                        $update = array(
                            'status' => 'error',
                            'string_result' => 'Не удалось выполнить запрос',
                            'success' => 0
                        );

                    }

                }

            }
            else
            {
                $update = array(
                    'status' => 'error',
                    'string_result' => 'не найдена заявка'
                );
            }

            if (!empty($update))
                $this->scorings->update_scoring($scoring_id, $update);

            return $update;

        }
    }



    public function run($audit_id, $user_id, $order_id)
    {
        $this->user_id = $user_id;
        $this->audit_id = $audit_id;
        $this->order_id = $order_id;

        $this->type = $this->scorings->get_type('juicescore');

        $response = $this->scoring($this->order_id);
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($response);echo '</pre><hr />';

        return $response;
    }

    public function scoring($order_id)
    {
        $order = $this->orders->get_order((int)$order_id);

        if (!($scoring = $this->getscore($order_id)))
        {
            $result = new StdClass();
            $result->error = 'undefined_order';
        }
        else
        {
            $scoring = (array)json_decode($scoring);
            if (isset($scoring['Predictors']))
                $scoring['Predictors'] = (array)$scoring['Predictors'];

            $result = $scoring;

            if (!empty($scoring['Success']))
            {
                $score = (int)$scoring['AntiFraud score'] < ($this->type->params['scorebal']);
                $add_scoring = array(
                    'user_id' => $order->user_id,
                    'audit_id' => $this->audit_id,
                    'type' => 'juicescore',
                    'body' => serialize($scoring),
                    'success' => $score,
                    'scorista_id' => '',
                );
                if ($score)
                {
                    $add_scoring['string_result'] = 'Проверка пройдена';
                }
                else
                {
                    $add_scoring['string_result'] = 'Проверка не пройдена';
                }

                $this->scorings->add_scoring($add_scoring);

            }

        }
        return $result;
    }

    public function getscore($order_id)
    {
        if (!($order = $this->orders->get_order((int)$order_id)))
            return false;

        $email_expls = explode('@', $order->email);
        $prepare_email = substr($email_expls[0], 0, -1);

        $params = array(
            'account_id' => 'MKK_Barvil_RU',
            'client_id' => $order->user_id,
            'session_id' => $order->juicescore_session_id,
            'channel' => 'SITE',
            'time_utc3' => date('d.m.Y H:i:s', strtotime($order->date)),
            'version' => 14,
            'referrer' => '',
            'tenor' => $order->period,
            'time_local' => '',
            'ip' => $order->ip,
            'useragent' => '',
            'ph_country' => '7',
            'phone' => substr($order->phone_mobile, 1, 6),
            'mail' => $prepare_email,
            'application_id' => $order->order_id,
            'time_zone' => '',
            'amount' => $order->amount,
            'mac_address' => '',
            'deviceid' => '',
            'zip_billing' => '',
            'country_code_billing' => 'RU',
            'zip_shipping' => '',
            'country_code_shipping' => 'RU',
            'card_number' => '',
            'card_expiration_date' => '',
            'response_content_type' => 'json',
        );
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($params);echo '</pre><hr />';
//exit;
        $url = $this->url.'?'.http_build_query($params);

        $headers = array(
            'session: '.$this->key
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $res = curl_exec($ch);

        curl_close($ch);

        return $res;

    }
}