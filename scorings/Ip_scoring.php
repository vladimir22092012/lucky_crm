<?php

class Ip_scoring extends Core
{
    private $user_id;
    private $order_id;
    private $audit_id;
    private $type;
    private $exception_regions;
    
    public function run_scoring($scoring_id)
    {
        if ($scoring = $this->scorings->get_scoring($scoring_id))
        {
            if ($order = $this->orders->get_order((int)$scoring->order_id))
            {
                if (empty($order->ip))
                {
                    $update = array(
                        'status' => 'error',
                        'string_result' => 'в заявке не сохранен ip'
                    );
                }
                else
                {
                    $location = json_decode($this->dadata->get_city_from_ip($order->ip), true);

                    $score = !empty($location['location']);

                    $update = array(
                        'status' => 'completed',
                        'body' => serialize(array('ip' => $order->ip)),
                        'success' => $score
                    );
                    if ($score)
                        $update['string_result'] = 'Допустимый регион: '. $location['location']['unrestricted_value'];
                    else
                        $update['string_result'] = 'Заявка поступает не из РФ';

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
    
    
//    public function run($audit_id, $user_id, $order_id)
//    {
//        $this->user_id = $user_id;
//        $this->audit_id = $audit_id;
//        $this->order_id = $order_id;
//
//        $this->type = $this->scorings->get_type('ip');
//
//        $order = $this->orders->get_order($order_id);
//
//        return $this->scoring($order->ip);
//    }
//
//    private function scoring($ip)
//    {
//        $location = json_decode($this->dadata->get_city_from_ip($ip), true);
//
//        $score = !empty($location['location']);
//
//        $add_scoring = array(
//            'user_id' => $this->user_id,
//            'audit_id' => $this->audit_id,
//            'type' => 'ip',
//            'body' => $ip,
//            'success' => (int)$score
//        );
//
//        if ($score)
//            $add_scoring['string_result'] = 'Допустимый регион: '. $location;
//        else
//            $add_scoring['string_result'] = 'Заявка поступает не из РФ';
//
//        $this->scorings->add_scoring($add_scoring);
//
//        return $score;
//    }

}