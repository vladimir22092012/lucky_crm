<?php

class ReportSaldoController extends Controller
{
    public function fetch()
    {
    	if ($this->request->method('post'))
        {
            
        }
        
        return $this->design->fetch('offline/report_saldo.tpl');
    }
    
}