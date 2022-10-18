<?php

class OfflineOrganizationController extends Controller
{
    public function fetch()
    {
    	if ($this->request->method('post'))
        {
            $organization_id = $this->request->post('id', 'integer');

            $organization = new StdClass();

            $organization->name = $this->request->post('name');
            $organization->code = $this->request->post('code', 'string');
            $organization->full_name = $this->request->post('full_name');
            $organization->inn = $this->request->post('inn');
            $organization->ogrn = $this->request->post('ogrn');
            $organization->fakt_address = $this->request->post('fakt_address');
            $organization->yur_address = $this->request->post('yur_address');
            $organization->reg_number = $this->request->post('reg_number');
            $organization->director_name = $this->request->post('director_name');
            $organization->commission = $this->request->post('commission', 'integer');
            
            if (empty($organization->name))
            {
                $this->design->assign('error', 'Укажите наименование организации');
            }
            else
            {
                if (empty($organization_id))
                {
                    $organization->id = $this->offline->add_organization($organization);
                    $this->design->assign('success', 'Организация добавлен');
                }
                else
                {
                    $organization->id = $this->offline->update_organization($organization_id, $organization);
                    $this->design->assign('success', 'Организация изменена');
                }
                
            }
        }
        else
        {
            if ($id = $this->request->get('id', 'integer'))
            {
                $organization = $this->offline->get_organization($id);
            }
        }
        
        if (!empty($organization))
            $this->design->assign('organization', $organization);
        
        
        return $this->design->fetch('offline/organization.tpl');
    }
    
}