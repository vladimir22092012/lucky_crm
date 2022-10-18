<?php

class ReportKassirController extends Controller
{
    public function fetch()
    {
    	if ($this->request->method('post'))
        {
            
        }
        
        return $this->design->fetch('offline/report_kassir.tpl');
    }
    
}