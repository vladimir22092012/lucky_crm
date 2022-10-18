<?php

class OfflinePointController extends Controller
{
    public function fetch()
    {
    	if ($this->request->method('post'))
        {
            $point_id = $this->request->post('id', 'integer');

            $point = new StdClass();

            $point->organization_id = $this->request->post('organization_id');
            $point->code = $this->request->post('code', 'string');
            $point->city = $this->request->post('city');
            $point->address = $this->request->post('address');
            $point->timezone = $this->request->post('timezone');
            $point->open_time = $this->request->post('open_time');
            $point->close_time = $this->request->post('close_time');
            $point->tariff = $this->request->post('tariff');
            $point->ip = $this->request->post('ip');
            
            if (empty($point->organization_id))
            {
                $this->design->assign('error', 'Укажите наименование организации');
            }
            else
            {
                if (empty($point_id))
                {
                    $point->id = $this->offline->add_point($point);
                    $this->design->assign('success', 'Оффлайн-отделение добавлено');
                }
                else
                {
                    $point->id = $this->offline->update_point($point_id, $point);
                    $this->design->assign('success', 'Оффлайн-отделение изменено');
                }
                
            }
        }
        else
        {
            if ($id = $this->request->get('id', 'integer'))
            {
                $point = $this->offline->get_point($id);
            }
        }
        
        if (!empty($point))
            $this->design->assign('point', $point);
        
        $organizations = $this->offline->get_organizations();
        $this->design->assign('organizations', $organizations);
        
        return $this->design->fetch('offline/point.tpl');
    }
    
}