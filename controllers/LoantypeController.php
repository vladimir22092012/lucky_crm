<?php

class LoantypeController extends Controller
{
    public function fetch()
    {
    	if ($this->request->method('post'))
        {
            $loantype_id = $this->request->post('id', 'integer');

            $loantype = new StdClass();

            $loantype->name = $this->request->post('name');
            $loantype->organization_id = $this->request->post('organization_id', 'integer');
            $loantype->percent = $this->request->post('percent');
            $loantype->charge = $this->request->post('charge');
//            $loantype->insure = $this->request->post('insure');
            $loantype->max_amount = $this->request->post('max_amount', 'integer');
            $loantype->max_period = $this->request->post('max_period', 'integer');
            $loantype->prolongation_period = $this->request->post('prolongation_period', 'integer');

            $loantype->bot_inform = $this->request->post('bot_inform', 'integer');
            $loantype->sms_inform = $this->request->post('sms_inform', 'integer');
            
            if (empty($loantype->name))
            {
                $this->design->assign('error', 'Укажите наименование вида кредита');
            }
            elseif (empty($loantype->organization_id))
            {
                $this->design->assign('error', 'Выберите организацию');
            }
            elseif (empty($loantype->percent))
            {
                $this->design->assign('error', 'Выберите процентную ставку');
            }
            elseif (empty($loantype->charge))
            {
                $this->design->assign('error', 'Выберите ставку ответственности');
            }
            elseif (empty($loantype->max_amount))
            {
                $this->design->assign('error', 'Укажите максимальную сумму кредита');
            }
            elseif (empty($loantype->max_period))
            {
                $this->design->assign('error', 'Укажите максимальный срок кредита');
            }
            else
            {
                if (empty($loantype_id))
                {
                    $loantype->id = $this->loantypes->add_loantype($loantype);
                    $this->design->assign('success', 'Вид кредитования добавлен');
                }
                else
                {
                    $loantype->id = $this->loantypes->update_loantype($loantype_id, $loantype);
                    $this->design->assign('success', 'Вид кредитования изменен');
                }
                
            }
        }
        else
        {
            if ($id = $this->request->get('id', 'integer'))
            {
                $loantype = $this->loantypes->get_loantype($id);
            }
        }
        
        if (!empty($loantype))
            $this->design->assign('loantype', $loantype);
        
        $organizations = array();
        foreach ($this->offline->get_organizations() as $org)
            $organizations[$org->id] = $org;
        $this->design->assign('organizations', $organizations);
        
        $percents = array(
            0,
            0.2, 
            0.6, 
            0.7, 
            0.8, 
            0.9,
            1,
        );
        $this->design->assign('percents', $percents);
        
        $charges = array(
            0.3,
            1, 
            1.5, 
        );
        $this->design->assign('charges', $charges);
        
        $insures = array(
            9,
            11, 
            10, 
            12, 
            14, 
            16, 
            18, 
            20,
        );
        $this->design->assign('insures', $insures);
        
        
        
        return $this->design->fetch('offline/loantype.tpl');
    }
    
}