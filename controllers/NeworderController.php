<?php

class NeworderController extends Controller
{
    public function fetch()
    {
    	if ($this->request->method('post'))
        {
            $order = new StdClass();
            
            $amount = intval($this->request->post('amount'));
            $period = intval($this->request->post('period'));
            $percent = floatval($this->request->post('percent'));
            $charge = floatval($this->request->post('charge'));
//            $insure = floatval($this->request->post('insure'));
            $peni = floatval($this->request->post('peni'));
            $bot_inform = floatval($this->request->post('bot_inform'));
            $sms_inform = floatval($this->request->post('sms_inform'));
            $organization_id = $this->request->post('organization_id');
            $offline_point_id = $this->request->post('offline_point_id');
            
            $loantype_id = $this->request->post('loantype_id', 'integer');
            
            $this->design->assign('percent', $percent);
            $this->design->assign('charge', $charge);
            $this->design->assign('peni', $peni);
            $this->design->assign('amount', $amount);
            $this->design->assign('period', $period);
            $this->design->assign('organization_id', $organization_id);

            $user = array();
            
            $user['user_id'] = intval($this->request->post('user_id'));
            
            $user['firstname'] = trim($this->request->post('firstname'));
            $user['lastname'] = trim($this->request->post('lastname'));
            $user['patronymic'] = trim($this->request->post('patronymic'));
            
            $user['phone_mobile'] = trim((string)$this->request->post('phone'));
            $user['email'] = trim((string)$this->request->post('email'));
            $user['gender'] = trim((string)$this->request->post('gender'));
            $user['birth'] = trim((string)$this->request->post('birth'));
            $user['birth_place'] = trim((string)$this->request->post('birth_place'));

            $user['passport_serial'] = (string)$this->request->post('passport_serial');
            $user['passport_date'] = (string)$this->request->post('passport_date');
            $user['passport_issued'] = (string)$this->request->post('passport_issued');
            $user['subdivision_code'] = (string)$this->request->post('subdivision_code');
            
            $user['workplace'] = (string)$this->request->post('workplace');
            $user['workaddress'] = (string)$this->request->post('workaddress');
            $user['profession'] = (string)$this->request->post('profession');
            $user['workphone'] = (string)$this->request->post('workphone');
            $user['income'] = (string)$this->request->post('income');
            $user['expenses'] = (string)$this->request->post('expenses');
            $user['chief_name'] = (string)$this->request->post('chief_name');
            $user['chief_position'] = (string)$this->request->post('chief_position');
            $user['chief_phone'] = (string)$this->request->post('chief_phone');

            $user['contact_person_name'] = (string)$this->request->post('contact_person_name');
            $user['contact_person_relation'] = (string)$this->request->post('contact_person_relation');
            $user['contact_person_phone'] = (string)$this->request->post('contact_person_phone');
            $user['contact_person2_name'] = (string)$this->request->post('contact_person2_name');
            $user['contact_person2_relation'] = (string)$this->request->post('contact_person2_relation');
            $user['contact_person2_phone'] = (string)$this->request->post('contact_person2_phone');

            $user['Faktindex'] = (string)$this->request->post('Faktindex');
            $user['Faktregion'] = (string)$this->request->post('Faktregion');
            $user['Faktregion_shorttype'] = (string)$this->request->post('Faktregion_shorttype');
            $user['Faktdistrict'] = (string)$this->request->post('Faktdistrict');
            $user['Faktdistrict_shorttype'] = (string)$this->request->post('Faktdistrict_shorttype');
            $user['Faktcity'] = (string)$this->request->post('Faktcity');
            $user['Faktcity_shorttype'] = (string)$this->request->post('Faktcity_shorttype');
            $user['Faktlocality'] = (string)$this->request->post('Faktlocality');
            $user['Faktlocality_shorttype'] = (string)$this->request->post('Faktlocality_shorttype');
            $user['Faktstreet'] = (string)$this->request->post('Faktstreet');
            $user['Faktstreet_shorttype'] = (string)$this->request->post('Faktstreet_shorttype');
            $user['Fakthousing'] = (string)$this->request->post('Fakthousing');
            $user['Faktbuilding'] = (string)$this->request->post('Faktbuilding');
            $user['Faktroom'] = (string)$this->request->post('Faktroom');
            
            if ($this->request->post('clone_address', 'integer'))
            {
                $user['Regindex'] = $user['Faktindex'];
                $user['Regregion'] = $user['Faktregion'];
                $user['Regregion_shorttype'] = $user['Faktregion_shorttype'];
                $user['Regcity'] = $user['Faktcity'];
                $user['Regcity_shorttype'] = $user['Faktcity_shorttype'];
                $user['Regdistrict'] = $user['Faktdistrict'];
                $user['Regdistrict_shorttype'] = $user['Faktdistrict_shorttype'];
                $user['Reglocality'] = $user['Faktlocality'];
                $user['Reglocality_shorttype'] = $user['Faktlocality_shorttype'];
                $user['Regstreet'] = $user['Faktstreet'];
                $user['Regstreet_shorttype'] = $user['Faktstreet_shorttype'];
                $user['Reghousing'] = $user['Fakthousing'];
                $user['Regbuilding'] = $user['Faktbuilding'];
                $user['Regroom'] = $user['Faktroom'];
            }
            else
            {
                $user['Regindex'] = (string)$this->request->post('Regindex');
                $user['Regregion'] = (string)$this->request->post('Regregion');
                $user['Regregion_shorttype'] = (string)$this->request->post('Regregion_shorttype');
                $user['Regcity'] = (string)$this->request->post('Regcity');
                $user['Regcity_shorttype'] = (string)$this->request->post('Regcity_shorttype');
                $user['Regdistrict'] = (string)$this->request->post('Regdistrict');
                $user['Regdistrict_shorttype'] = (string)$this->request->post('Regdistrict_shorttype');
                $user['Reglocality'] = (string)$this->request->post('Reglocality');
                $user['Reglocality_shorttype'] = (string)$this->request->post('Reglocality_shorttype');
                $user['Regstreet'] = (string)$this->request->post('Regstreet');
                $user['Regstreet_shorttype'] = (string)$this->request->post('Regstreet_shorttype');                
                $user['Reghousing'] = (string)$this->request->post('Reghousing');
                $user['Regbuilding'] = (string)$this->request->post('Regbuilding');
                $user['Regroom'] = (string)$this->request->post('Regroom');
            }

            if (empty($user['user_id']))
            {
                $user['stage_personal'] = 1;
                $user['stage_passport'] = 1;
                $user['stage_address'] = 1;
                $user['stage_work'] = 1;
                $user['stage_files'] = 1;
                $user['stage_card'] = 1;

                $userUID = $this->soap1c->generate_uid_client($user);
                if (!empty($userUID)) {
                    $user['UID'] = $userUID;
                }

                unset($user['user_id']);
                if (!($user['user_id'] = $this->users->add_user($user)))
                {
                    $this->design->assign('error', 'Не удалось создать клиента');
                }
                $client_status = 'nk';
            }
            else
            {
                $client_contracts = $this->contracts->get_contracts(['user_id'=>$user['user_id'], 'status'=>3]);
                $client_status = empty($client_contracts) ? 'rep' : 'crm';
            }
            
            if (!empty($user['user_id']))
            {
                $loantype = $this->loantypes->get_loantype($loantype_id);
                
                $order = array(
                    'type' => 'offline',
                    'user_id' => $user['user_id'],
                    'amount' => $amount,
                    'period' => $period,
                    'date' => date('Y-m-d H:i:s'),
                    'manager_id' => $this->manager->id,
                    'status' => 1,
                    'offline' => 1,
                    'offline_point_id' => $offline_point_id,
                    'percent' => $loantype->percent,
                    'charge' => $loantype->charge,
//                    'insure' => $loantype->insure,
                    'prolongation_period' => $loantype->prolongation_period,
                    'bot_inform' => $bot_inform,
                    'sms_inform' => $sms_inform,
                    'organization_id' => $organization_id,
                    'client_status' => $client_status,
                );
                
                if ($order_id = $this->orders->add_order($order))
                {
                    //TODO: добавляем лог о создании заявки
                    
                    header("Location: ".$this->config->root_url.'/offline_order/'.$order_id);
                    exit;
                }
                else
                {
                    $this->design->assign('error', 'Не удалось создать заявку');
                }
            }
            
            
            
            $this->design->assign('order', (object)$user);

            



        }
        else
        {
            $this->design->assign('percent', 1);
            $this->design->assign('charge', 1);
            $this->design->assign('peni', 320);
        }
        
        $organizations = array();
        foreach ($this->offline->get_organizations() as $org)
            $organizations[$org->id] = $org;
        $this->design->assign('organizations', $organizations);
        
        $offline_points = array();
        foreach ($this->offline->get_points() as $point)
            $offline_points[$point->id] = $point;
        $this->design->assign('offline_points', $offline_points);

        if (!empty($_SESSION['offline_point_id']))
        {
            $current_offline_point = $this->offline->get_point($_SESSION['offline_point_id']);
            $this->design->assign('current_offline_point', $current_offline_point);
        }
         
        $loantypes = array();
        foreach ($this->loantypes->get_loantypes() as $lt)
            $loantypes[$lt->id] = $lt;
        $this->design->assign('loantypes', $loantypes);
        
        return $this->design->fetch('offline/neworder.tpl');
    }
}