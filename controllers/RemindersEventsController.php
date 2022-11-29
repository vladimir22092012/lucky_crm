<?php

class RemindersEventsController extends Core
{
    public function fetch()
    {
        return $this->design->fetch('reminders_events.tpl');
    }
}