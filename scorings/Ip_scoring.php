<?php

class Ip_scoring extends Core
{
    private $order_id;
    protected $token = "222e191767518127bcf15cc4d2a23c131404fdf2";
    protected $secret = "6b90de07e9974eba848ac174b3eed2829a35ec5e";

    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $user = UsersORM::find($scoring->user_id);
        $order = OrdersORM::find($scoring->order_id);

        $dadata = new \Dadata\DadataClient($this->token, $this->secret);
        $result = $dadata->iplocate($user->last_ip);

        if (empty($order->last_ip)) {
            $update = array(
                'status' => 'error',
                'string_result' => 'в заявке не сохранен ip'
            );
        } else {

            if(isset($result['value']))
                $score = 1;
            else
                $score = 0;

            $update = array(
                'status' => 'completed',
                'body' => serialize(array('ip' => $order->ip)),
                'success' => $score
            );
            if ($score)
                $update['string_result'] = 'Допустимый регион: ' . $result['value'];
            else
                $update['string_result'] = 'Заявка поступает не из РФ';

        }


        if (!empty($update))
            $this->scorings->update_scoring($scoring_id, $update);

        return $update;

    }
}