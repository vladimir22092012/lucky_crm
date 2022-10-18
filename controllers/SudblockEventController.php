<?php

class SudblockEventController extends Controller
{
    public function fetch()
    {
        if ($this->request->method('post')) {
            switch ($this->request->post('action', 'string')):

                case 'add':

                    $name = trim($this->request->post('name'));
                    $count_days = trim($this->request->post('count_days', 'integer'));

                    $event = ['name' => $name, 'count_days' => $count_days];

                    if ($id = $this->EventTypes->add_event($event)) {
                        $this->json_output(array(
                            'success' => 'Событие успешно добавлено',
                            'id' => $id,
                            'name' => $name,
                            'count_days' => $count_days,
                            ));
                    } else {
                        $this->json_output(array('error' => 'Не удалось добавить событие'));
                    }

                    break;

                case 'delete':

                    $event_id = $this->request->post('id');

                    if ($this->EventTypes->delete_event($event_id)) {
                        $this->json_output(array(
                            'success' => 'Событие успешно удалено',
                            'id' => $event_id
                            ));
                    } else {
                        $this->json_output(array('error' => 'Не удалось удалить событие'));
                    }
                    break;

                case 'update':

                    $id = $this->request->post('id', 'integer');
                    $name = trim($this->request->post('name'));
                    $count_days = trim($this->request->post('count_days', 'integer'));

                    $event = ['name' => $name, 'count_days' => $count_days];

                    if ($this->EventTypes->update_event($event, $id)) {
                        $this->json_output(array(
                            'id' => $id,
                            'name' => $name,
                            'count_days' => $count_days,
                            'success' => 'Документ обновлен'
                        ));
                    }
                    else
                    {
                        $this->json_output(array('error' => 'Не удалось обновить событие'));
                    }


                    break;

            endswitch;
        }

        $events = $this->EventTypes->get_events();
        $this->design->assign('events', $events);

        return $this->design->fetch('sudblock_event_types.tpl');
    }
}