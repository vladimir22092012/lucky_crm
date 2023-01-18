<?php

error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__) . '/../');

require 'autoload.php';

class CheckCallCron extends Core
{
    protected static $apiKey = "HiyTXk4pKBiOdJ9K93C5zwOWhs9M5EepowzCZQBJNZDmopjK0rnHJOUU2ZCy";

    public function __construct()
    {
        parent::__construct();
        $this->run();
    }

    private function run()
    {
        $callBotSettings = CallBotSettingsORM::find(1);
        $time = new DateTime(date('H:i', strtotime($callBotSettings->time)));
        $nowTime = new DateTime(date('H:i'));

        if ($nowTime > $time && date_diff($time, $nowTime)->h >= 1) {
            $callBotCron = CallBotCronORM::whereBetween('created', [date('2023-01-17 00:00:00'), date('2023-01-17 23:59:59')])->where('status_sent_sms', null)->get();

            $requestArray = array(
                'apiKey' => self::$apiKey
            );

            $json = json_encode($requestArray);

            foreach ($callBotCron as $callBot) {
                $callBotResp = json_decode($callBot->resp, true);

                if ($callBotResp['status'] != 'success')
                    CallBotCronORM::where('id', $callBot->id)->update(['status_sent_sms' => 'errorCallbot']);

                $id = $callBotResp['data'][0]['id'];

                $contract = ContractsORM::where('order_id', $callBot->orderId)->first();

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://lk.zvonobot.ru/apiCalls/get?apiCallIdList[]=' . $id);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'accept: application/json'));
                curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                $resp = curl_exec($curl);
                $resp = json_decode($resp, true);
                curl_close($curl);

                if ($resp['status'] == 'success') {
                    $answeredAt = new DateTime(date("H:i:s", $resp['data'][0]['calls'][0]['answeredAt']));
                    $finishedAt = new DateTime(date("H:i:s", $resp['data'][0]['calls'][0]['finishedAt']));

                    if (date_diff($answeredAt, $finishedAt)->s >= 6) {
                        $api_code = 'CEC47EEB-DA21-5CDB-9431-7E53B513FAA5';

                        $callBotSettings = CallBotSettingsORM::find(1);

                        $code = $this->helpers->c2o_encode($contract->id);

                        $shortLink = 'https://mkk-barvil.ru/p/' . $code;

                        $message = $callBotSettings->textSms;
                        $message .= ' ' . $shortLink;

                        $smsru = new Smsru($api_code);

                        $data = new stdClass();
                        $data->to = $resp['data'][0]['calls'][0]['phone'];
                        $data->text = $message;

                        $sms = $smsru->send_one($data);

                        $insert =
                            [
                                'className' => self::class,
                                'log' => json_encode($sms),
                                'params' => $message
                            ];

                        LogsORM::insert($insert);

                        CallBotCronORM::where('id', $callBot->id)->update(['status_sent_sms' => 'success', 'is_sent_sms' => 1]);
                    }
                } else {
                    CallBotCronORM::where('id', $callBot->id)->update(['status_sent_sms' => 'errorSendSms', 'resp_sent_sms' => json_encode($resp, JSON_UNESCAPED_UNICODE)]);
                }
            }
        }
    }
}

new CheckCallCron();