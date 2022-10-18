<?php

error_reporting(-1);
ini_set('display_errors', 'On');

chdir('..');

require 'autoload.php';

$response = array();

class SendCardsScript extends Core
{
    private $list = '

463359413


    ';
    
    
    public function __construct()
    {
        $this->run();
    }
    
    private function run()
    {
        $regs = array_filter(array_map('trim', explode("\n", $this->list)));

        if (!empty($regs))
        {
            foreach ($regs as $reg)
            {
                $transaction = $this->transactions->get_register_id_transaction($reg);
                
                if ($card = $this->cards->get_transaction_card($transaction->id))
                {
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($card);echo '</pre><hr />';
                    if ($card->sent_status != 1)
                    {
                        if ($user = $this->users->get_user((int)$transaction->user_id))
                        {
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($user);echo '</pre><hr />';
                            $user_orders = $this->orders->get_orders(array('user_id'=>$user->id));
                            if (empty($user_orders))
                            {
                                $this->users->update_user($user->id, array('stage_card'=>1));
                                
                                // Не актуально 
                                $reason = $this->reasons->get_reason(2);
                                
                                $new_order = array(
                                    'user_id' => $user->id,
                                    'card_id' => $card->id,
                                    'ip' => '',
                                    'amount' => $user->first_loan_amount,
                                    'period' => $user->first_loan_period,
                                    'first_loan' => 1,
                                    'date' => date('Y-m-d H:i:s'),
                                    'accept_sms' => $user->sms,
                                    'client_status' => 'nk',
                                    'status' => 3,
                                    'reason_id' => $reason->id,
                                    'reject_reason' => $reason->client_name,
                                    'reject_date' => date('Y-m-d H:i:s'),
                                    'manager_id' => 100,
                                    
                                );
                                if ($order_id = $this->orders->add_order($new_order))
                                {
                                    $order = $this->orders->get_order((int)$order_id);
                                    if ($resp = $this->soap1c->send_order($order))
                                    {
                                        $this->orders->update_order($order_id, array('id_1c' => $resp->aid));
                                        $this->users->update_user($user->id, array('UID' => $resp->UID));

                                        $this->soap1c->send_order_status($resp->aid, 'Отказано');

                                        $this->cards->update_card($card->id, ['sent_status' => 0]);
                                    
                                        echo 'success: '.$card->id;
                                    }
                                    
                                    
                                    
                                    
                                }
                                

echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($order_id);echo '</pre><hr />';                                
                                

                            }
                            else
                            {
                                $this->cards->update_card($card->id, ['sent_status' => 0]);
                            }
                        }
                    }
                }
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($transaction);echo '</pre><hr />';    
            }
        }
    }
}

new SendCardsScript();
 