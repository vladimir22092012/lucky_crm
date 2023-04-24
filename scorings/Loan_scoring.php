<?php

class Loan_scoring extends Core
{
    private $user_id;
    private $order_id;
    private $audit_id;
    private $type;


    public function run_scoring($scoring_id)
    {
        $update = array();

        $scoring_type = $this->scorings->get_type('loan');
        $scoring = $this->scorings->get_scoring($scoring_id);
        $contracts = $this->contracts->get_contracts(array('user_id'=>$scoring->user_id));
        $now = date('Y-m-d H:i:s');

        foreach ($contracts as $contract) {
            $dateDiff = 3000;
            if (isset($contract->accept_date)) {
                $dateDiff = date_diff(new DateTime($now), new DateTime($contract->accept_date))->days;
                    
                if($dateDiff < $scoring_type->params['prew_loan']){
                    $update = array(
                        'status' => 'completed',
                        'string_result' => 'Предыдущий займ был менее ' . $scoring_type->params['prew_loan'] . ' дней назад',
                        'success' => 0
                    );
                }
                else{
                    $update = array(
                        'status' => 'completed',
                        'success' => 1
                    );
                }
                
                if (!empty($update))
                    $this->scorings->update_scoring($scoring_id, $update);
            }
            
        }        
        return $update;

       return null;
    }

}