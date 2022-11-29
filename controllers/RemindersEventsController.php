<?php

class RemindersEventsController extends Core
{
    public function fetch()
    {
        if ($this->request->method('post')) {
            if ($this->request->post('action', 'string')) {
                $methodName = 'action_' . $this->request->post('action', 'string');
                if (method_exists($this, $methodName)) {
                    $this->$methodName();
                }
            }
        }

        $remindersEvents = RemindersEventsORM::get();
        $this->design->assign('remindersEvents', $remindersEvents);

        return $this->design->fetch('reminders_events.tpl');
    }

    private function action_addEvent()
    {
        $name = $this->request->post('name');

        RemindersEventsORM::insert(['name' => $name]);
        exit;
    }

    private function action_editEvent()
    {
        $name = $this->request->post('name');
        $id = $this->request->post('id');

        RemindersEventsORM::where('id', $id)->update(['name' => $name]);
        exit;
    }

    private function action_deleteEvent()
    {
        $id = $this->request->post('id');

        RemindersEventsORM::destroy($id);
        exit;
    }
}