<?php

class RemindersController extends Controller
{
    public function fetch()
    {
        if ($this->request->method('post'))
        {
            $this->settings->days_without_a_loan = $this->request->post('days_without_a_loan');
            $this->settings->days_until_due_date = $this->request->post('days_until_due_date');

            $this->settings->days_since_approval = $this->request->post('days_since_approval');
            $this->settings->sales_by_sms = $this->request->post('sales_by_sms');
        }

        if ($this->request->get('version') === '2.0') {
            return $this->design->fetch('reminders2.tpl');
        } else {
            return $this->design->fetch('reminders.tpl');
        }
    }
}