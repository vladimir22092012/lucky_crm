<?php

class CallbotController extends Controller
{
    public function fetch()
    {
        if ($this->request->post()) {
            $textCallBot = $this->request->post('textCallBot');
            $time = $this->request->post('time');
            $periods = $this->request->post('periods');
            $textSms = $this->request->post('textSms');

            $update =
                [
                    'textCallBot' => $textCallBot,
                    'time' => $time,
                    'periods' => $periods,
                    'textSms' => $textSms
                ];

            CallBotSettingsORM::where('id', 1)->update($update);
        }

        $callBotSettings = CallBotSettingsORM::find(1);
        $this->design->assign('callBotSettings', $callBotSettings);

        return $this->design->fetch('callbot.tpl');
    }
}