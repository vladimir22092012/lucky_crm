<?php

class BankSelectionController extends Controller
{
    public function fetch()
    {
        if ($this->request->method('post'))
        {
            $this->settings->bank = $this->request->post('bank');
        }
        $this->design->assign('sectors', $this->best2pay->get_sectors());
        
        return $this->design->fetch('bank_setting.tpl');
    }
}