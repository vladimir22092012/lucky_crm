<?php

class SectorsSettingsController extends Controller
{
    public function fetch()
    {
        if ($this->request->method('post'))
        {
            $this->settings->sectors = $this->request->post('sectors');
        }
        
        return $this->design->fetch('sectors_settings.tpl');
    
    }
}