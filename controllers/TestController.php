<?php

class TestController extends Controller
{
    public function fetch()
    {
        $scoring_types = $this->scorings->get_types();
        foreach ($scoring_types as $scoring_type)
        {
            if ($scoring_type->active && empty($scoring_type->is_paid))
            {
                $add_scoring = array(
                    'user_id' => 684,
                    'order_id' => 683,
                    'type' => $scoring_type->name,
                    'status' => 'new',
                    'created' => date('Y-m-d H:i:s')
                );

                $this->scorings->add_scoring($add_scoring);
            }
        }
    }
}