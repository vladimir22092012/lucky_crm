<?php

ini_set('max_execution_time', 120);
error_reporting(0);
ini_set('display_errors', 'Off');
ini_set('html_errors', 'Off');

class StatisticsController extends Controller
{
    public function fetch()
    {
        if (in_array('statistics', $this->manager->permissions)) {
            switch ($this->request->get('action', 'string')):

                case 'main':
                    return $this->action_main();
                    break;

                case 'report':
                    return $this->action_report();
                    break;

                case 'conversion':
                    return $this->action_conversion();
                    break;

                case 'expired':
                    return $this->action_expired();
                    break;

                case 'free_pk':
                    return $this->action_free_pk();
                    break;

                case 'scorista_rejects':
                    return $this->action_scorista_rejects();
                    break;

                case 'contracts':
                    return $this->action_contracts();
                    break;

                case 'payments':
                    return $this->action_payments();
                    break;

                case 'eventlogs':
                    return $this->action_eventlogs();
                    break;

                case 'penalties':
                    return $this->action_penalties();
                    break;

                case 'adservices':
                    return $this->action_adservices();
                    break;

                case 'kpicollection':
                    return $this->action_kpicollection();
                    break;

                case 'leadcraft':
                    return $this->action_leadcraft();
                    break;

                case 'sudlogs':
                    return $this->action_sudlogs();
                    break;

                case 'sources':
                    return $this->action_sources();
                    break;

                case 'conversions':
                    return $this->action_conversions();
                    break;

                case 'reminders':
                    return $this->action_reminders();
                    break;

                case 'divisions':
                    return $this->action_divisions();
                    break;

                case 'active':
                    return $this->action_active();
                    break;

                case 'delay':
                    return $this->action_delay();
                    break;

                default:
                    return false;

            endswitch;
        }
    }

    private function action_main()
    {
        return $this->design->fetch('statistics/main.tpl');
    }

    private function action_report()
    {
        $this->statistics->get_operative_report('2021-05-01', '2021-05-30');

        return $this->design->fetch('statistics/report.tpl');
    }

    private function action_conversion()
    {
        return $this->design->fetch('statistics/conversions.tpl');
    }

    private function action_expired()
    {
        return $this->design->fetch('statistics/expired.tpl');
    }

    private function action_free_pk()
    {
        return $this->design->fetch('statistics/free_pk.tpl');
    }

    private function action_scorista_rejects()
    {
        $reasons = array();
        foreach ($this->reasons->get_reasons() as $reason)
            $reasons[$reason->id] = $reason;
        $this->design->assign('reasons', $reasons);


        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);

            $query_reason = '';
            if ($filter_reason = $this->request->get('reason_id')) {
                if ($filter_reason != 'all') {
                    $query_reason = $this->db->placehold("AND o.reason_id = ?", (int)$filter_reason);
                }

                $this->design->assign('filter_reason', $filter_reason);
            }

            $query = $this->db->placehold("
                SELECT
                    o.id AS order_id,
                    o.date,
                    o.reason_id,
                    o.reject_reason,
                    o.user_id,
                    o.manager_id,
                    o.utm_source,
                    o.client_status,
                    u.lastname,
                    u.firstname,
                    u.patronymic,
                    u.phone_mobile,
                    u.email
                FROM __orders AS o
                LEFT JOIN __users AS u
                ON u.id = o.user_id
                WHERE o.status IN (3, 8)
                $query_reason
                AND DATE(o.date) >= ?
                AND DATE(o.date) <= ?
                GROUP BY order_id
            ", $date_from, $date_to);
            $this->db->query($query);

            $orders = array();
            foreach ($this->db->results() as $o)
                $orders[$o->order_id] = $o;

            if (!empty($orders))
                if ($scorings = $this->scorings->get_scorings(array('order_id' => array_keys($orders), 'type' => 'scorista')))
                    foreach ($scorings as $scoring)
                        $orders[$scoring->order_id]->scoring = $scoring;


            switch ($this->request->get('scoring')):

                case '499-':
                    foreach ($orders as $key => $order)
                        if (empty($order->scoring->scorista_ball) || $order->scoring->scorista_ball > 499)
                            unset($orders[$key]);
                    break;

                case '500-549':
                    foreach ($orders as $key => $order)
                        if (empty($order->scoring->scorista_ball) || $order->scoring->scorista_ball < 500 || $order->scoring->scorista_ball > 549)
                            unset($orders[$key]);
                    break;

                case '550+':
                    foreach ($orders as $key => $order)
                        if (empty($order->scoring->scorista_ball) || $order->scoring->scorista_ball < 550)
                            unset($orders[$key]);
                    break;

            endswitch;
            $this->design->assign('filter_scoring', $this->request->get('scoring'));


            if ($this->request->get('download') == 'excel') {
                $managers = array();
                foreach ($this->managers->get_managers() as $m)
                    $managers[$m->id] = $m;

                //фикс расхожения данных в документе и на сайте
                $fix_managers = [];
                foreach ($managers as $manager) {
                    $fix_managers[$manager->id] = $manager;
                }

                $filename = 'files/reports/orders.xls';
                require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

                $excel = new PHPExcel();

                $excel->setActiveSheetIndex(0);
                $active_sheet = $excel->getActiveSheet();

                $active_sheet->setTitle("Выдачи " . $from . "-" . $to);

                $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
                $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $active_sheet->getColumnDimension('A')->setWidth(20);
                $active_sheet->getColumnDimension('B')->setWidth(15);
                $active_sheet->getColumnDimension('C')->setWidth(45);
                $active_sheet->getColumnDimension('D')->setWidth(20);
                $active_sheet->getColumnDimension('E')->setWidth(20);
                $active_sheet->getColumnDimension('F')->setWidth(10);
                $active_sheet->getColumnDimension('G')->setWidth(10);
                $active_sheet->getColumnDimension('H')->setWidth(30);
                $active_sheet->getColumnDimension('J')->setWidth(30);
                $active_sheet->getColumnDimension('K')->setWidth(20);

                $active_sheet->setCellValue('A1', 'Дата');
                $active_sheet->setCellValue('B1', 'Заявка');
                $active_sheet->setCellValue('C1', 'ФИО');
                $active_sheet->setCellValue('D1', 'Телефон');
                $active_sheet->setCellValue('E1', 'Email');
                $active_sheet->setCellValue('F1', 'Менеджер');//---
                $active_sheet->setCellValue('G1', 'Причина');
                $active_sheet->setCellValue('H1', 'Скориста');//---
                $active_sheet->setCellValue('J1', 'Источник');
                $active_sheet->setCellValue('K1', 'НК/ПК');

                $i = 2;
                foreach ($orders as $contract) {
                    $active_sheet->setCellValue('A' . $i, date('d.m.Y H:i:s', strtotime($contract->date)));
                    $active_sheet->setCellValue('B' . $i, $contract->order_id);
                    $active_sheet->setCellValue('C' . $i, $contract->lastname . ' ' . $contract->firstname . ' ' . $contract->patronymic);
                    $active_sheet->setCellValue('D' . $i, $contract->phone_mobile);
                    $active_sheet->setCellValue('E' . $i, $contract->email);
                    $active_sheet->setCellValue('F' . $i, $fix_managers[$contract->manager_id]->name);
                    $active_sheet->setCellValue('G' . $i, ($contract->reason_id ? $reasons[$contract->reason_id]->admin_name : $contract->reject_reason));
                    $active_sheet->setCellValue('H' . $i, isset($contract->scoring) ? $contract->scoring->scorista_ball : '');
                    $active_sheet->setCellValue('J' . $i, $contract->utm_source);
                    $active_sheet->setCellValue('K' . $i, $contract->client_status);


                    $i++;
                }

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

                $objWriter->save($this->config->root_dir . $filename);

                header('Location:' . $this->config->root_url . '/' . $filename);
                exit;
            }


            $this->design->assign('orders', $orders);
        }

        return $this->design->fetch('statistics/scorista_rejects.tpl');
    }

    private function action_contracts()
    {
        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);

            $query = $this->db->placehold("
                SELECT
                    c.id AS contract_id,
                    c.order_id AS order_id,
                    c.number,
                    c.inssuance_date AS date,
                    c.return_date,
                    c.close_date,
                    c.amount,
                    c.user_id,
                    c.status,
                    c.collection_status,
                    c.sold,
                    c.loan_percents_summ,
                    c.loan_peni_summ,
                    o.client_status,
                    o.date AS order_date,
                    o.manager_id,
                    o.utm_source,
                    u.lastname,
                    u.firstname,
                    u.patronymic,
                    u.phone_mobile,
                    u.email,
                    u.birth,
                    u.UID AS uid,
                    u.regaddress_id,
                    u.faktaddress_id,
                    u.birth_place,
                    u.passport_serial,
                    u.subdivision_code,
                    u.passport_date,
                    u.passport_issued,
                    u.contact_person_name,
                    u.contact_person_phone,
                    u.contact_person2_name,
                    u.contact_person2_phone,
                    u.workphone
                FROM __contracts AS c
                LEFT JOIN __users AS u
                ON u.id = c.user_id
                LEFT JOIN __orders AS o
                ON o.id = c.order_id
                WHERE c.status IN (2, 3, 4, 7)
                AND c.type = 'base'
                AND DATE(c.inssuance_date) >= ?
                AND DATE(c.inssuance_date) <= ?
                ORDER BY contract_id
            ", $date_from, $date_to);
            $this->db->query($query);

            $contracts = array();
            foreach ($this->db->results() as $c) {
                $c->collections = array();
                $c->operations = array();
                $c->total_paid = 0;
                $contracts[$c->contract_id] = $c;
            }

            if (!empty($contracts)) {
                foreach ($this->operations->get_operations(array('contract_id' => array_keys($contracts), 'type' => 'PAY')) as $op) {
                    $contracts[$op->contract_id]->operations[] = $op;
                    $contracts[$op->contract_id]->total_paid += $op->amount;
                }

                foreach ($this->collections->get_collections(array('contract_id' => array_keys($contracts))) as $col) {
                    $contracts[$col->contract_id]->collections[] = $col;
                }
            }

            foreach ($contracts as $c) {
                $c->expiration = 0;

                if ($c->status == 3) {
                    if (strtotime($c->close_date) > strtotime($c->return_date)) {
                        $datetime1 = date_create(date('Y-m-d 00:00:00', strtotime($c->close_date)));
                        $datetime2 = date_create(date('Y-m-d 00:00:00', strtotime($c->return_date)));
                        $interval = date_diff($datetime1, $datetime2);
                        //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($c->close_date, $c->return_date, $interval);echo '</pre><hr />';
                        $c->expiration = $interval->days;
                    }
                } else {
                    if (strtotime(date('Y-m-d H:i:s')) > strtotime($c->return_date)) {
                        $datetime1 = date_create(date('Y-m-d 00:00:00'));
                        $datetime2 = date_create(date('Y-m-d 00:00:00', strtotime($c->return_date)));
                        $interval = date_diff($datetime1, $datetime2);
                        //echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($c->close_date, $c->return_date, $interval);echo '</pre><hr />';
                        $c->expiration = $interval->days;
                    }
                }

                $regAddress = AdressesORM::find($c->regaddress_id);
                $c->Regregion = $regAddress->adressfull;

                $faktAddress = AdressesORM::find($c->faktaddress_id);
                $c->FaktRegion = $faktAddress->adressfull;
            }

            $statuses = $this->contracts->get_statuses();
            $this->design->assign('statuses', $statuses);

            $collection_statuses = $this->contracts->get_collection_statuses();
            $this->design->assign('collection_statuses', $collection_statuses);

            $managers = array();
            foreach ($this->managers->get_managers() as $m)
                $managers[$m->id] = $m;
            $this->design->assign('list_managers', $managers);

            if ($this->request->get('download') == 'excel') {

                $filename = 'files/reports/contracts.xls';
                require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

                $excel = new PHPExcel();

                $excel->setActiveSheetIndex(0);
                $active_sheet = $excel->getActiveSheet();

                $active_sheet->setTitle("Выдачи " . $from . "-" . $to);

                $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
                $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $active_sheet->getColumnDimension('A')->setWidth(15);
                $active_sheet->getColumnDimension('B')->setWidth(15);
                $active_sheet->getColumnDimension('C')->setWidth(45);
                $active_sheet->getColumnDimension('D')->setWidth(20);
                $active_sheet->getColumnDimension('E')->setWidth(35);
                $active_sheet->getColumnDimension('F')->setWidth(20);
                $active_sheet->getColumnDimension('G')->setWidth(10);
                $active_sheet->getColumnDimension('H')->setWidth(10);
                $active_sheet->getColumnDimension('I')->setWidth(30);
                $active_sheet->getColumnDimension('J')->setWidth(10);
                $active_sheet->getColumnDimension('K')->setWidth(10);
                $active_sheet->getColumnDimension('L')->setWidth(20);
                $active_sheet->getColumnDimension('M')->setWidth(20);
                $active_sheet->getColumnDimension('N')->setWidth(20);
                $active_sheet->getColumnDimension('O')->setWidth(20);
                $active_sheet->getColumnDimension('P')->setWidth(20);
                $active_sheet->getColumnDimension('Q')->setWidth(20);
                $active_sheet->getColumnDimension('R')->setWidth(20);
                $active_sheet->getColumnDimension('S')->setWidth(20);
                $active_sheet->getColumnDimension('T')->setWidth(20);
                $active_sheet->getColumnDimension('U')->setWidth(20);
                $active_sheet->getColumnDimension('V')->setWidth(20);

                $active_sheet->setCellValue('A1', 'Дата');
                $active_sheet->setCellValue('B1', 'Договор');
                $active_sheet->setCellValue('C1', 'ФИО');
                $active_sheet->setCellValue('D1', 'Дата рождения');
                $active_sheet->setCellValue('E1', 'Место рождения');
                $active_sheet->setCellValue('F1', 'Телефон');
                $active_sheet->setCellValue('G1', 'Адрес регистрации');
                $active_sheet->setCellValue('H1', 'Почта');
                $active_sheet->setCellValue('I1', 'Сумма');
                $active_sheet->setCellValue('J1', 'Проценты');
                $active_sheet->setCellValue('K1', 'Штрафы');
                $active_sheet->setCellValue('L1', 'ПК/НК');
                $active_sheet->setCellValue('M1', 'Менеджер');
                $active_sheet->setCellValue('N1', 'Статус');
                $active_sheet->setCellValue('O1', 'Источник');
                $active_sheet->setCellValue('P1', 'Поступление заявки');
                $active_sheet->setCellValue('Q1', 'Дата окончания договора');
                $active_sheet->setCellValue('R1', 'Паспортные данные');
                $active_sheet->setCellValue('S1', 'Контакты 3-х лиц');
                $active_sheet->setCellValue('T1', 'Адрес проживания');
                $active_sheet->setCellValue('U1', 'Рабочий телефон');
                $active_sheet->setCellValue('V1', 'Просрочка');

                $i = 2;
                foreach ($contracts as $contract) {
                    if ($contract->client_status == 'pk')
                        $client_status = 'ПК';
                    elseif ($contract->client_status == 'nk')
                        $client_status = 'НК';
                    elseif ($contract->client_status == 'crm')
                        $client_status = 'ПК CRM';
                    elseif ($contract->client_status == 'rep')
                        $client_status = 'Повтор';
                    else
                        $client_status = '';

                    if (!empty($contract->collection_status)) {
                        if (empty($contract->sold))
                            $status = 'МКК ';
                        else
                            $status = 'ЮК ';
                        $status .= $collection_statuses[$contract->collection_status];
                    } else {
                        $status = $statuses[$contract->status];
                    }

                    $passport = "Паспорт " . $contract->passport_serial
                        . " Выдан " . $contract->passport_issued
                        . " от " . $contract->passport_date
                        . " код подразделения код подразделения ".$contract->subdivision_code;

                    $contacts = $contract->contact_person_name.'/'.$contract->contact_person_phone
                        ." ".$contract->contact_person2_name.'/'.$contract->contact_person2_phone;

                    $active_sheet->setCellValue('A' . $i, date('d.m.Y', strtotime($contract->date)));
                    $active_sheet->setCellValue('B' . $i, $contract->number);
                    $active_sheet->setCellValue('C' . $i, $contract->lastname . ' ' . $contract->firstname . ' ' . $contract->patronymic);
                    $active_sheet->setCellValue('D' . $i, $contract->birth);
                    $active_sheet->setCellValue('E' . $i, $contract->birth_place);
                    $active_sheet->setCellValue('F' . $i, $contract->phone_mobile);
                    $active_sheet->setCellValue('G' . $i, $contract->Regregion . ' ' . $contract->Regregion_shorttype);
                    $active_sheet->setCellValue('H' . $i, $contract->email);
                    $active_sheet->setCellValue('I' . $i, $contract->amount * 1);
                    $active_sheet->setCellValue('J' . $i, $contract->loan_percents_summ);
                    $active_sheet->setCellValue('K' . $i, $contract->loan_peni_summ);
                    $active_sheet->setCellValue('L' . $i, $client_status);
                    $active_sheet->setCellValue('M' . $i, $managers[$contract->manager_id]->name);
                    $active_sheet->setCellValue('N' . $i, $status);
                    $active_sheet->setCellValue('O' . $i, $contract->utm_source);
                    $active_sheet->setCellValue('P' . $i, date('d.m.Y H:i:s', strtotime($contract->order_date)));
                    $active_sheet->setCellValue('Q' . $i, $contract->return_date);
                    $active_sheet->setCellValue('R' . $i, $passport);
                    $active_sheet->setCellValue('S' . $i, $contacts);
                    $active_sheet->setCellValue('T' . $i, $contract->FaktRegion);
                    $active_sheet->setCellValue('U' . $i, $contract->workphone);
                    $active_sheet->setCellValue('V' . $i, $contract->expiration);

                    $i++;
                }

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

                $objWriter->save($this->config->root_dir . $filename);

                header('Location:' . $this->config->root_url . '/' . $filename);
                exit;
            }

            $this->design->assign('contracts', $contracts);
        }

        return $this->design->fetch('statistics/contracts.tpl');
    }

    private function action_payments()
    {
        if ($operation_id = $this->request->get('operation_id', 'integer')) {
            if ($operation = $this->operations->get_operation($operation_id)) {
                $operation->contract = $this->contracts->get_contract($operation->contract_id);
                $operation->transaction = $this->transactions->get_transaction($operation->transaction_id);
                if ($operation->transaction->insurance_id)
                    $operation->transaction->insurance = $this->insurances->get_insurance($operation->transaction->insurance_id);

                if ($operation->type == 'REJECT_REASON') {
                    $result = $this->soap1c->send_reject_reason($operation);
                    if (!((isset($result->return) && $result->return == 'OK') || $result == 'OK')) {
                        $order = $this->orders->get_order($operation->order_id);

                        if ($resp = $this->soap1c->send_order($order)) {
                            $this->orders->update_order($order->order_id, array('id_1c' => $resp->aid));
                            $this->users->update_user($order->user_id, array('UID' => $resp->UID));
                        }
                        $result = $this->soap1c->send_reject_reason($operation);
                    }
                } else {
                    $result = $this->soap1c->send_payments(array($operation));
                }

                if ((isset($result->return) && $result->return == 'OK') || $result == 'OK') {
                    $this->operations->update_operation($operation->id, array(
                        'sent_date' => date('Y-m-d H:i:s'),
                        'sent_status' => 2
                    ));
                    $this->json_output(array('success' => 'Операция отправлена'));
                } else {
                    $this->json_output(array('error' => 'Ошибка при отправке'));
                }

            } else {
                $this->json_output(array('error' => 'Операция не найдена'));
            }
        } elseif ($daterange = $this->request->get('daterange')) {
            $search_filter = '';

            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);

            if ($search = $this->request->get('search')) {
                if (!empty($search['created']))
                    $search_filter .= $this->db->placehold(' AND DATE(t.created) = ?', date('Y-m-d', strtotime($search['created'])));
                if (!empty($search['number']))
                    $search_filter .= $this->db->placehold(' AND c.number LIKE "%' . $this->db->escape($search['number']) . '%"');
                if (!empty($search['fio']))
                    $search_filter .= $this->db->placehold(' AND (u.lastname LIKE "%' . $this->db->escape($search['fio']) . '%" OR u.firstname LIKE "%' . $this->db->escape($search['fio']) . '%" OR u.patronymic LIKE "%' . $this->db->escape($search['fio']) . '%")');
                if (!empty($search['amount']))
                    $search_filter .= $this->db->placehold(' AND t.amount = ?', $search['amount'] * 100);
                if (!empty($search['card']))
                    $search_filter .= $this->db->placehold(' AND t.callback_response LIKE "%' . $this->db->escape($search['card']) . '%"');
                if (!empty($search['register_id']))
                    $search_filter .= $this->db->placehold(' AND t.register_id LIKE "%' . $this->db->escape($search['register_id']) . '%"');
                if (!empty($search['operation']))
                    $search_filter .= $this->db->placehold(' AND t.operation LIKE "%' . $this->db->escape($search['operation']) . '%"');
                if (!empty($search['description']))
                    $search_filter .= $this->db->placehold(' AND t.description LIKE "%' . $this->db->escape($search['description']) . '%"');

            }

            $query = $this->db->placehold("
                SELECT
                    o.id,
                    o.user_id,
                    o.contract_id,
                    o.order_id,
                    o.transaction_id,
                    o.type,
                    o.amount,
                    o.created,
                    o.sent_date,
                    o.loan_body_summ,
                    o.loan_percents_summ,
                    o.loan_peni_summ,
                    c.id AS contract_id,
                    c.number AS contract_number,
                    u.id AS uder_id,
                    u.lastname,
                    u.firstname,
                    u.patronymic,
                    u.birth,
                    t.register_id,
                    t.operation,
                    t.prolongation,
                    t.insurance_id,
                    t.description,
                    t.callback_response,
                    i.number AS insurance_number,
                    i.amount AS insurance_amount,
                    t.sector
                FROM __operations AS o
                LEFT JOIN __contracts AS c
                ON c.id = o.contract_id
                LEFT JOIN __users AS u
                ON u.id = o.user_id
                LEFT JOIN __transactions AS t
                ON t.id = o.transaction_id
                LEFT JOIN __insurances AS i
                ON i.id = t.insurance_id
                WHERE o.type != 'INSURANCE'
                $search_filter
                AND DATE(o.created) >= ?
                AND DATE(o.created) <= ?
                AND (t.reason_code = 1 OR o.type = 'PAY-REC')
                ORDER BY o.id
            ", $date_from, $date_to);
            $this->db->query($query);
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($query);echo '</pre><hr />';
            $operations = array();
            // var_dump($this->db->results());
            // die;
            foreach ($this->db->results() as $op) {
                // if ($xml = simplexml_load_string($op->callback_response)) {
                //     $op->pan = (string)$xml->pan;
                // }
                $cards_array = $this->cards->get_cards(array('user_id' => $op->user_id));
                if(array_key_exists('0', $cards_array))
                    $op->pan = $cards_array[0]->pan;

                if($op->type == 'PAY-REC')
                    $op->description = 'Реккурентное списание по договору ' . $op->contract_number;

                $contract_operations = $this->operations->get_operations(array('contract_id'=>$op->contract_id));
                $contract = $this->contracts->get_contract($op->contract_id);

                $prepayment_body = 0;
                $prepayment_percents = 0;
                // foreach ($contract_operations as $key => $value) {
                    
                //     // if($value->type == 'PAY'){
                //     if($op->id == $value->id){
                        
                //         if ($key > 0) {
                //             $prepayment_body += $contract_operations[$key-1]->loan_body_summ - $value->loan_body_summ;
                //             $prepayment_percents += $contract_operations[$key-1]->loan_percents_summ - $value->loan_percents_summ;
                //             $prepayment_percents += $contract_operations[$key-1]->loan_peni_summ - $value->loan_peni_summ;
                //         }
                //         else{
                //             $prepayment_body = $value->amount;
                //         }
                //     }
                // }

                if($contract->amount > $op->amount){
                    $prepayment_percents = $op->amount;
                }
                else{
                    $prepayment_body = $contract->amount;
                    $prepayment_percents = $op->amount - $contract->amount;
                }

                $op->prepayment_body = $prepayment_body;
                $op->prepayment_percents = $prepayment_percents;

                $operations[$op->id] = $op;
            }


            $statuses = $this->contracts->get_statuses();
            $this->design->assign('statuses', $statuses);

            $collection_statuses = $this->contracts->get_collection_statuses();
            $this->design->assign('collection_statuses', $collection_statuses);


            if ($this->request->get('download') == 'excel') {
                $managers = array();
                foreach ($this->managers->get_managers() as $m)
                    $managers[$m->id] = $m;

                $filename = 'files/reports/payments.xls';
                require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

                $excel = new PHPExcel();

                $excel->setActiveSheetIndex(0);
                $active_sheet = $excel->getActiveSheet();

                $active_sheet->setTitle("Выдачи " . $from . "-" . $to);

                $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
                $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $active_sheet->getColumnDimension('A')->setWidth(15);
                $active_sheet->getColumnDimension('B')->setWidth(15);
                $active_sheet->getColumnDimension('C')->setWidth(45);
                $active_sheet->getColumnDimension('D')->setWidth(20);
                $active_sheet->getColumnDimension('E')->setWidth(20);
                $active_sheet->getColumnDimension('F')->setWidth(10);
                $active_sheet->getColumnDimension('G')->setWidth(10);
                $active_sheet->getColumnDimension('H')->setWidth(30);
                $active_sheet->getColumnDimension('I')->setWidth(10);

                $active_sheet->setCellValue('A1', 'Дата');
                $active_sheet->setCellValue('B1', 'Договор');
                $active_sheet->setCellValue('C1', 'ФИО');
                $active_sheet->setCellValue('D1', 'Сумма');
                $active_sheet->setCellValue('E1', 'Карта');
                $active_sheet->setCellValue('F1', 'Описание');
                $active_sheet->setCellValue('G1', 'B2P OrderID');
                $active_sheet->setCellValue('H1', 'B2P OperationID');
                $active_sheet->setCellValue('I1', 'Страховка');

                $i = 2;
                foreach ($operations as $contract) {

                    $active_sheet->setCellValue('A' . $i, date('d.m.Y', strtotime($contract->created)));
                    $active_sheet->setCellValue('B' . $i, $contract->contract_number . ' ' . ($contract->sector == '7036' ? 'ЮК' : 'МКК'));
                    $active_sheet->setCellValue('C' . $i, $contract->lastname . ' ' . $contract->firstname . ' ' . $contract->patronymic . ' ' . $contract->birth);
                    $active_sheet->setCellValue('D' . $i, $contract->amount);
                    $active_sheet->setCellValue('E' . $i, $contract->pan);
                    $active_sheet->setCellValue('F' . $i, $contract->description . ' ' . ($contract->prolongation ? '(пролонгация)' : ''));
                    $active_sheet->setCellValue('G' . $i, $contract->register_id);
                    $active_sheet->setCellValue('H' . $i, $contract->operation);//--
                    $active_sheet->setCellValue('I' . $i, $contract->insurance_number . ' ' . ($contract->insurance_amount ? $contract->insurance_amount . ' руб' : ''));

                    $i++;
                }

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

                $objWriter->save($this->config->root_dir . $filename);

                header('Location:' . $this->config->root_url . '/' . $filename);
                exit;
            }


            $this->design->assign('operations', $operations);
        }

        return $this->design->fetch('statistics/payments.tpl');
    }

    private function action_eventlogs()
    {
        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);


            $query_manager_id = '';
            if ($filter_manager_id = $this->request->get('manager_id')) {
                if ($filter_manager_id != 'all')
                    $query_manager_id = $this->db->placehold("AND o.manager_id = ?", (int)$filter_manager_id);

                $this->design->assign('filter_manager_id', $filter_manager_id);
            }

            $query = $this->db->placehold("
                SELECT
                    o.id AS order_id,
                    o.date,
                    o.reason_id,
                    o.reject_reason,
                    o.user_id,
                    o.manager_id,
                    o.status,
                    u.lastname,
                    u.firstname,
                    u.patronymic
                FROM __orders AS o
                LEFT JOIN __users AS u
                ON u.id = o.user_id
                WHERE o.manager_id IS NOT NULL
                AND DATE(o.date) >= ?
                AND DATE(o.date) <= ?
                $query_manager_id
            ", $date_from, $date_to);
            $this->db->query($query);

            $orders = array();
            foreach ($this->db->results() as $o)
                $orders[$o->order_id] = $o;

            if (!empty($orders)) {
                foreach ($orders as $o) {
                    $o->eventlogs = $this->eventlogs->get_logs(array('order_id' => $o->order_id));
                }
            }

            $events = $this->eventlogs->get_events();
            $this->design->assign('events', $events);

            $reasons = $this->reasons->get_reasons();
            $this->design->assign('reasons', $reasons);


            if ($this->request->get('download') == 'excel') {
                $managers = array();
                foreach ($this->managers->get_managers() as $m)
                    $managers[$m->id] = $m;

                $order_statuses = $this->orders->get_statuses();

                $filename = 'files/reports/eventlogs.xls';
                require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

                $excel = new PHPExcel();

                $excel->setActiveSheetIndex(0);
                $active_sheet = $excel->getActiveSheet();

                $active_sheet->setTitle("Логи " . $from . "-" . $to);

                $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
                $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $active_sheet->getColumnDimension('A')->setWidth(6);
                $active_sheet->getColumnDimension('B')->setWidth(30);
                $active_sheet->getColumnDimension('C')->setWidth(10);
                $active_sheet->getColumnDimension('D')->setWidth(10);
                $active_sheet->getColumnDimension('E')->setWidth(30);
                $active_sheet->getColumnDimension('F')->setWidth(35);

                $active_sheet->setCellValue('A1', '#');
                $active_sheet->setCellValue('B1', 'Заявка');
                $active_sheet->mergeCells('C1:F1');
                $active_sheet->setCellValue('C1', 'События');

                $style_bold = array(
                    'font' => array(
                        'name' => 'Calibri',
                        'size' => 13,
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap' => true,
                    )
                );
                $active_sheet->getStyle('A1:C1')->applyFromArray($style_bold);

                $i = 2;
                $rc = 1;
                foreach ($orders as $order) {
                    $start_i = $i;

                    $a_indexes = 'A' . $i . ':A' . ($i + count($order->eventlogs) - 1);
                    if (count($order->eventlogs) > 2)
                        $active_sheet->mergeCells($a_indexes);
                    $active_sheet->getStyle($a_indexes)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $active_sheet->getStyle($a_indexes)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $active_sheet->setCellValue('A' . $i, $rc);

                    $b_indexes = 'B' . ($i + 3) . ':B' . ($i + count($order->eventlogs) - 1);
                    if (count($order->eventlogs) > 3)
                        $active_sheet->mergeCells($b_indexes);
                    $active_sheet->getStyle($b_indexes)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $active_sheet->getStyle($b_indexes)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $active_sheet->setCellValue('B' . $i, $order->order_id);
                    $active_sheet->setCellValue('B' . ($i + 1), 'Статус: ' . $order_statuses[$order->status]);
                    $active_sheet->setCellValue('B' . ($i + 2), 'Менеджер: ' . $managers[$order->manager_id]->name);

                    foreach ($order->eventlogs as $ev) {
                        $active_sheet->setCellValue('C' . $i, date('d.m.Y', strtotime($ev->created)));
                        $active_sheet->setCellValue('D' . $i, date('H:i:s', strtotime($ev->created)));
                        $active_sheet->setCellValue('E' . $i, $events[$ev->event_id]);
                        $active_sheet->setCellValue('F' . $i, $managers[$ev->manager_id]->name);

//                        $active_sheet->getStyle('C'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                        $active_sheet->getStyle('D'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                        $active_sheet->getStyle('E'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                        $active_sheet->getStyle('F'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//
                        $i++;
                    }

                    $rc++;

                    $active_sheet->getStyle('A' . $start_i . ':F' . ($i - 1))->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '666666')
                                )
                            )
                        )
                    );
                    $active_sheet->getStyle('A' . $start_i . ':F' . ($i - 1))->applyFromArray(
                        array(
                            'borders' => array(
                                'top' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                                    'color' => array('rgb' => '222222')
                                ),
                                'bottom' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                                    'color' => array('rgb' => '222222')
                                ),
                                'left' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                                    'color' => array('rgb' => '222222')
                                ),
                                'right' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                                    'color' => array('rgb' => '222222')
                                )
                            )
                        )
                    );
//                    $active_sheet->getStyle()->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                }

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

                $objWriter->save($this->config->root_dir . $filename);

                header('Location:' . $this->config->root_url . '/' . $filename);
                exit;
            }


            $this->design->assign('orders', $orders);
        }

        return $this->design->fetch('statistics/eventlogs.tpl');
    }

    private function action_penalties()
    {
        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);


            $filter = array();
            $filter['date_from'] = $date_from;
            $filter['date_to'] = $date_to;
            $filter['status'] = array(2, 3, 4);

            if ($this->manager->role == 'user' || $this->manager->role == 'big_user') {
                $filter['manager_id'] = $this->manager->id;
            } elseif ($filter_manager_id = $this->request->get('manager_id')) {
                if ($filter_manager_id != 'all')
                    $filter['manager_id'] = $filter_manager_id;

                $this->design->assign('filter_manager_id', $filter_manager_id);
            }

            $orders = array();
            if ($penalties = $this->penalties->get_penalties($filter)) {
                $order_ids = array();
                foreach ($penalties as $penalty)
                    $order_ids[] = $penalty->order_id;

                foreach ($this->orders->get_orders(array('id' => $order_ids)) as $order) {
                    $order->penalties = array();
                    $orders[$order->order_id] = $order;
                }

                foreach ($penalties as $penalty) {
                    if (isset($orders[$penalty->order_id]))
                        $orders[$penalty->order_id]->penalties[] = $penalty;
                }

                $total_summ = 0;
                $total_count = 0;
                foreach ($orders as $order) {
                    $total_count++;
                    $order->penalty_summ = 0;
                    foreach ($order->penalties as $p) {
                        if ($order->status == 7)
                            $p->cost = 0;

                        if ($p->status == 2 || $p->status == 3)
                            $p->cost = 0;

                        if ($order->penalty_summ < $p->cost)
                            $order->penalty_summ = $p->cost;
                    }
                    $order->penalty_summ = min($order->penalty_summ, 500);
                    $total_summ += $order->penalty_summ;
                }

                $this->design->assign('total_summ', $total_summ);
                $this->design->assign('total_count', $total_count);
            }

            $this->design->assign('orders', $orders);

            $penalty_types = array();
            foreach ($this->penalties->get_types() as $t)
                $penalty_types[$t->id] = $t;
            $this->design->assign('penalty_types', $penalty_types);

            $penalty_statuses = $this->penalties->get_statuses();
            $this->design->assign('penalty_statuses', $penalty_statuses);

            $managers = array();
            foreach ($this->managers->get_managers() as $m)
                $managers[$m->id] = $m;
            uasort($managers, function ($a, $b) {
                return strcasecmp($a->name_1c, $b->name_1c);
            });
            $this->design->assign('managers', $managers);
        }

        if ($this->request->get('download') == 'excel') {
            $managers = array();
            foreach ($this->managers->get_managers() as $m)
                $managers[$m->id] = $m;

            $filename = 'files/reports/penalties.xls';
            require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

            $excel = new PHPExcel();

            $excel->setActiveSheetIndex(0);
            $active_sheet = $excel->getActiveSheet();

            $active_sheet->setTitle("Штрафы " . $from . "-" . $to);

            $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
            $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $active_sheet->getColumnDimension('A')->setWidth(30);
            $active_sheet->getColumnDimension('B')->setWidth(30);
            $active_sheet->getColumnDimension('C')->setWidth(10);
            $active_sheet->getColumnDimension('D')->setWidth(10);
            $active_sheet->getColumnDimension('E')->setWidth(20);
            $active_sheet->getColumnDimension('F')->setWidth(10);
            $active_sheet->getColumnDimension('G')->setWidth(30);
            $active_sheet->getColumnDimension('H')->setWidth(30);
            $active_sheet->getColumnDimension('I')->setWidth(10);
            $active_sheet->getColumnDimension('J')->setWidth(10);
            $active_sheet->getColumnDimension('K')->setWidth(30);


            $active_sheet->mergeCells('A1:E1');
            $active_sheet->mergeCells('F1:K1');
            $active_sheet->setCellValue('A1', 'Заявка');
            $active_sheet->setCellValue('F1', 'Штрафы');

            $orders_i = 2;
            $penalties_i = 2;

            $order_status = ['Новая', 'Принята', 'Одобрена', 'Отказ', 'Подписан', 'Выдан', 'Не удалось выдать', 'Погашен', 'Отказ клиента'];

            foreach ($orders as $order) {
                $order_fio = "$order->lastname, $order->firstname, $order->patronymic";

                $active_sheet->setCellValue('A' . $orders_i, date('d.m.Y h:i:s', strtotime($order->date)));
                $active_sheet->setCellValue('B' . $orders_i, $order_fio);
                $active_sheet->setCellValue('C' . $orders_i, $order->order_id);
                $active_sheet->setCellValue('D' . $orders_i, $order_status[$order->status]);
                $active_sheet->setCellValue('E' . $orders_i, "$order->penalty_summ Р");

                foreach ($order->penalties as $penalty) {
                    $active_sheet->setCellValue('F' . $penalties_i, $penalty->created);
                    $active_sheet->setCellValue('G' . $penalties_i, $managers[$penalty->manager_id]->name);
                    $active_sheet->setCellValue('H' . $penalties_i, $penalty->comment);
                    $active_sheet->setCellValue('I' . $penalties_i, $this->penalties->get_statuses($penalty->status));
                    $active_sheet->setCellValue('J' . $penalties_i, "$penalty->cost Р");
                    $active_sheet->setCellValue('K' . $penalties_i, $managers[$penalty->control->manager_id]->name);

                    $penalties_i++;
                }
                $orders_i++;
            }

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

            $objWriter->save($this->config->root_dir . $filename);

            header('Location:' . $this->config->root_url . '/' . $filename);
            exit;

        }

        return $this->design->fetch('statistics/penalties.tpl');
    }

    private function action_adservices()
    {
        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);


            $filter = array();
            $filter['date_from'] = $date_from;
            $filter['date_to'] = $date_to;

            if ($this->manager->role == 'user') {
                $filter['manager_id'] = $this->manager->id;
            } elseif ($filter_manager_id = $this->request->get('manager_id')) {
                if ($filter_manager_id != 'all')
                    $filter['manager_id'] = $filter_manager_id;

                $this->design->assign('filter_manager_id', $filter_manager_id);
            }

            $ad_services = $this->operations->operations_contracts_insurance($filter);

            $op_type = ['INSURANCE' => 'Страховка', 'BUD_V_KURSE' => 'Будь в курсе', 'REJECT_REASON' => 'Узнай причину отказа', 'INSURANCE_CLOSED' => 'Страховка'];
            $gender = ['male' => 'Мужской', 'female' => 'Женский'];

            $this->design->assign('ad_services', $ad_services);
            $this->design->assign('op_type', $op_type);
            $this->design->assign('gender', $gender);

            if ($this->request->get('download') == 'excel') {

                $filename = 'files/reports/adservices.xls';
                require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

                $excel = new PHPExcel();

                $excel->setActiveSheetIndex(0);
                $active_sheet = $excel->getActiveSheet();

                $active_sheet->setTitle($from . "-" . $to);

                $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
                $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $active_sheet->getColumnDimension('A')->setWidth(15);
                $active_sheet->getColumnDimension('B')->setWidth(15);
                $active_sheet->getColumnDimension('C')->setWidth(15);
                $active_sheet->getColumnDimension('D')->setWidth(15);
                $active_sheet->getColumnDimension('E')->setWidth(15);
                $active_sheet->getColumnDimension('F')->setWidth(15);
                $active_sheet->getColumnDimension('G')->setWidth(15);
                $active_sheet->getColumnDimension('H')->setWidth(15);
                $active_sheet->getColumnDimension('I')->setWidth(15);
                $active_sheet->getColumnDimension('J')->setWidth(15);
                $active_sheet->getColumnDimension('K')->setWidth(15);
                $active_sheet->getColumnDimension('L')->setWidth(15);
                $active_sheet->getColumnDimension('M')->setWidth(15);
                $active_sheet->getColumnDimension('N')->setWidth(15);
                $active_sheet->getColumnDimension('O')->setWidth(15);

                $active_sheet->setCellValue('A1', 'Дата продажи');
                $active_sheet->setCellValue('B1', 'Договор займа');
                $active_sheet->setCellValue('C1', 'ID клиента');
                $active_sheet->setCellValue('D1', 'Номер полиса');
                $active_sheet->setCellValue('E1', 'Продукт');
                $active_sheet->setCellValue('F1', 'ID операции');
                $active_sheet->setCellValue('G1', 'УИД договора');
                $active_sheet->setCellValue('H1', 'ФИО, дата рождения');
                $active_sheet->setCellValue('I1', 'Номер телефона');
                $active_sheet->setCellValue('J1', 'Пол');
                $active_sheet->setCellValue('K1', 'Паспорт, серия номер');
                $active_sheet->setCellValue('L1', 'Адрес');
                $active_sheet->setCellValue('M1', 'Дата начала / завершения ответственности');
                $active_sheet->setCellValue('N1', 'Страховая сумма');
                $active_sheet->setCellValue('O1', 'Сумма оплаты/Страховая премия');

                $i = 2;
                foreach ($ad_services as $ad_service) {

                    if ($ad_service->Regcity) {
                        $address = "$ad_service->Regindex $ad_service->Regcity $ad_service->Regstreet_shorttype $ad_service->Regstreet $ad_service->Reghousing $ad_service->Regroom";

                    } else {
                        $address = "$ad_service->Regindex $ad_service->Reglocality $ad_service->Regstreet_shorttype $ad_service->Regstreet $ad_service->Reghousing $ad_service->Regroom";
                    }

                    $fio_birth = "$ad_service->lastname $ad_service->firstname $ad_service->patronymic $ad_service->birth";


                    $active_sheet->setCellValue('A' . $i, date('d.m.Y', strtotime($ad_service->created)));
                    $active_sheet->setCellValue('B' . $i, $ad_service->contract_id);
                    $active_sheet->setCellValue('C' . $i, $ad_service->user_id);
                    $active_sheet->setCellValue('D' . $i, $ad_service->number);
                    $active_sheet->setCellValue('E' . $i, $op_type[$ad_service->type]);
                    $active_sheet->setCellValue('F' . $i, $ad_service->id);
                    $active_sheet->setCellValue('G' . $i, $ad_service->uid);
                    $active_sheet->setCellValue('H' . $i, $fio_birth);
                    $active_sheet->setCellValue('I' . $i, $ad_service->phone_mobile);
                    $active_sheet->setCellValue('J' . $i, $gender[$ad_service->gender]);
                    $active_sheet->setCellValue('K' . $i, $ad_service->passport_serial);
                    $active_sheet->setCellValue('L' . $i, $address);

                    if ($ad_service->start_date) {
                        $active_sheet->setCellValue('M' . $i, date('d.m.Y', strtotime($ad_service->start_date)) . '/' . date('Y-m-d', strtotime($ad_service->end_date)));
                    } else {
                        $active_sheet->setCellValue('M' . $i, '-');
                    }
                    if ($ad_service->number) {
                        $active_sheet->setCellValue('N' . $i, $ad_service->amount_contract * 3);
                    }
                    $active_sheet->setCellValue('O' . $i, $ad_service->amount_insurance);

                    $i++;
                }

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

                $objWriter->save($this->config->root_dir . $filename);

                header('Location:' . $this->config->root_url . '/' . $filename);
                exit;
            }

        }


        return $this->design->fetch('statistics/adservices.tpl');
    }

    private function action_kpicollection()
    {
        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d 00:00', strtotime($from));
            $date_to = date('Y-m-d 23:59', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);


            if ($this->manager->role == 'user') {
                $filter['manager_id'] = $this->manager->id;
            } elseif ($filter_manager_id = $this->request->get('manager_id')) {
                if ($filter_manager_id != 'all')
                    $filter['manager_id'] = $filter_manager_id;

                $this->design->assign('filter_manager_id', $filter_manager_id);
            }

            $kpi = $this->Kpicollections->get_records($date_from, $date_to);
            $result = [];

            foreach ($kpi as $record) {

                $date = date('Y-m-d', strtotime($record->created_at));

                $result[$date][$record->position] = round($record->kpi, 2);

            }


            $this->design->assign('kpi', $result);
        }
        return $this->design->fetch('statistics/kpi_collection.tpl');
    }

    private function action_leadcraft()
    {

        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $items_per_page = 100;

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);


            if ($this->manager->role == 'user') {
                $filter['manager_id'] = $this->manager->id;
            } elseif ($filter_manager_id = $this->request->get('manager_id')) {
                if ($filter_manager_id != 'all')
                    $filter['manager_id'] = $filter_manager_id;

                $this->design->assign('filter_manager_id', $filter_manager_id);
            }

            $filter = [];
            $filter['date_from'] = $date_from;
            $filter['date_to'] = $date_to;

            if ($this->request->get('postback_type', 'string') && $this->request->get('postback_type', 'string') != 'reset') {
                $filter['postback_type'] = $this->request->get('postback_type', 'string');
            }

            $current_page = $this->request->get('page', 'integer');
            $current_page = max(1, $current_page);
            $this->design->assign('current_page_num', $current_page);

            $orders = $this->orders->get_orders_to_leadcraft($filter);

            $results = [];
            $orders_count = 0;

            foreach ($orders as $key => $order) {
                if ($order->utm_source) {
                    $results[$key] = $order;
                    $orders_count++;
                }
            }

            $pages_num = ceil($orders_count / $items_per_page);
            $this->design->assign('total_pages_num', $pages_num);
            $this->design->assign('total_orders_count', $orders_count);

            $filter['page'] = $current_page;
            $filter['limit'] = $items_per_page;

            $statuses = array(
                0 => 'Принята',
                1 => 'На рассмотрении',
                2 => 'Одобрена',
                3 => 'Отказ',
                4 => 'Готов к выдаче',
                5 => 'Займ выдан',
                6 => 'Не удалось выдать',
                7 => 'Погашен',
                8 => 'Отказ клиента',
            );

            $color =
                [
                    0 => 'label label-success',
                    1 => 'label label-info',
                    2 => 'label label-success',
                    3 => 'label label-danger ',
                    4 => 'label label-warning',
                    5 => 'label label-success',
                    6 => 'label label-danger ',
                    7 => 'label label-primary',
                    8 => 'label label-danger ',
                ];

            $color_postback =
                [
                    'pending' => 'info',
                    'cancelled' => 'danger',
                    'approved' => 'success'
                ];

            $this->design->assign('orders', $results);
            $this->design->assign('statuses', $statuses);
            $this->design->assign('color', $color);
            $this->design->assign('color_postback', $color_postback);


            if ($this->request->get('download') == 'excel') {

                $orders = $this->orders->get_orders_to_leadcraft($filter);

                $results = [];

                foreach ($orders as $key => $order) {
                    if ($order->utm_source) {
                        $results[$key] = $order;
                        $orders_count++;
                    }
                }

                $filename = 'files/reports/leadcraft.xls';
                require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

                $excel = new PHPExcel();

                $excel->setActiveSheetIndex(0);
                $active_sheet = $excel->getActiveSheet();

                $active_sheet->setTitle($from . "-" . $to);

                $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
                $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $active_sheet->getColumnDimension('A')->setWidth(35);
                $active_sheet->getColumnDimension('B')->setWidth(15);
                $active_sheet->getColumnDimension('C')->setWidth(35);
                $active_sheet->getColumnDimension('D')->setWidth(15);
                $active_sheet->getColumnDimension('E')->setWidth(20);
                $active_sheet->getColumnDimension('F')->setWidth(20);
                $active_sheet->getColumnDimension('G')->setWidth(10);
                $active_sheet->getColumnDimension('H')->setWidth(20);
                $active_sheet->getColumnDimension('I')->setWidth(15);
                $active_sheet->getColumnDimension('J')->setWidth(15);

                $active_sheet->setCellValue('A1', 'ID вебмастера');
                $active_sheet->setCellValue('B1', 'Источник');
                $active_sheet->setCellValue('C1', 'Кликхеш');
                $active_sheet->setCellValue('D1', 'ID заявки');
                $active_sheet->setCellValue('E1', 'Дата заявки');
                $active_sheet->setCellValue('F1', 'Статус заявки');
                $active_sheet->setCellValue('G1', 'Статус клиента');
                $active_sheet->setCellValue('H1', 'Постбек');
                $active_sheet->setCellValue('I1', 'Цена');
                $active_sheet->setCellValue('J1', 'Тип постбека');

                $i = 2;
                foreach ($results as $result) {

                    $active_sheet->setCellValue('A' . $i, $result->webmaster_id);
                    $active_sheet->setCellValue('B' . $i, $result->utm_source);
                    $active_sheet->setCellValue('C' . $i, $result->click_hash);
                    $active_sheet->setCellValue('D' . $i, $result->order_id);
                    $active_sheet->setCellValue('E' . $i, $result->date);
                    $active_sheet->setCellValue('F' . $i, $statuses[$result->status]);
                    $active_sheet->setCellValue('G' . $i, $result->client_status);
                    $active_sheet->setCellValue('H' . $i, $result->leadcraft_postback_date);
                    $active_sheet->setCellValue('I' . $i, '');
                    $active_sheet->setCellValue('J' . $i, $result->leadcraft_postback_type);

                    $i++;
                }

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

                $objWriter->save($this->config->root_dir . $filename);

                header('Location:' . $this->config->root_url . '/' . $filename);
                exit;
            }

        }
        return $this->design->fetch('statistics/leadcraft.tpl');
    }

    private function action_sudlogs()
    {
        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);


            if ($this->manager->role == 'user') {
                $filter['manager_id'] = $this->manager->id;
            } elseif ($filter_manager_id = $this->request->get('manager_id')) {
                if ($filter_manager_id != 'all')
                    $filter['manager_id'] = $filter_manager_id;

                $this->design->assign('filter_manager_id', $filter_manager_id);
            }

            $filter = array();
            $filter['date_from'] = $date_from;
            $filter['date_to'] = $date_to;
            $filter['type'] = 'sudblock_events';

            $logs = $this->changelogs->get_changelogs($filter);

            $sudblock_contracts = [];
            $managers = [];
            $users = [];
            $sudblock_statuses = [];


            foreach ($logs as $log) {
                $sudblock_contracts[$log->user_id] = $this->sudblock->get_contract_by_user_id($log->user_id);
                $managers[$log->manager_id] = $this->managers->get_manager($log->manager_id);
                $users[$log->user_id] = $this->users->get_user($log->user_id);
                $sudblock_statuses[$sudblock_contracts[$log->user_id]->id] = $this->sudblock->get_status($sudblock_contracts[$log->user_id]->status);
            }

            $this->design->assign('logs', $logs);
            $this->design->assign('sudblock_contracts', $sudblock_contracts);
            $this->design->assign('managers', $managers);
            $this->design->assign('users', $users);
            $this->design->assign('sudblock_statuses', $sudblock_statuses);

            if ($this->request->get('download') == 'excel') {

                $filename = 'files/reports/sudlogs.xls';
                require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

                $excel = new PHPExcel();

                $excel->setActiveSheetIndex(0);
                $active_sheet = $excel->getActiveSheet();

                $active_sheet->setTitle($from . "-" . $to);

                $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
                $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $active_sheet->getColumnDimension('A')->setWidth(6);
                $active_sheet->getColumnDimension('B')->setWidth(30);
                $active_sheet->getColumnDimension('C')->setWidth(10);
                $active_sheet->getColumnDimension('D')->setWidth(10);
                $active_sheet->getColumnDimension('E')->setWidth(30);
                $active_sheet->getColumnDimension('F')->setWidth(30);

                $active_sheet->setCellValue('A1', '#');
                $active_sheet->setCellValue('B1', 'Договор');
                $active_sheet->mergeCells('C1:F1');
                $active_sheet->setCellValue('C1', 'События');

                $style_bold = array(
                    'font' => array(
                        'name' => 'Calibri',
                        'size' => 13,
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap' => true,
                    )
                );
                $active_sheet->getStyle('A1:C1')->applyFromArray($style_bold);

                $i = 2;
                $rc = 1;
                foreach ($sudblock_contracts as $contract) {
                    $start_i = $i;

                    $a_indexes = 'A' . $i . ':A' . ($i + count($logs) - 1);
                    if (count($logs) > 2)
                        $active_sheet->mergeCells($a_indexes);
                    $active_sheet->getStyle($a_indexes)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $active_sheet->getStyle($a_indexes)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $active_sheet->setCellValue('A' . $i, $rc);

                    $b_indexes = 'B' . ($i + 3) . ':B' . ($i + count($logs) - 1);
                    if (count($logs) > 2)
                        $active_sheet->mergeCells($b_indexes);
                    $active_sheet->getStyle($b_indexes)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $active_sheet->getStyle($b_indexes)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $active_sheet->setCellValue('B' . $i, $contract->id);
                    $active_sheet->setCellValue('B' . ($i + 1), 'Статус: ' . $sudblock_statuses[$contract->id]->name);
                    $active_sheet->setCellValue('B' . ($i + 2), 'Менеджер: ' . $managers[$contract->manager_id]->name);

                    foreach ($logs as $log) {
                        $active_sheet->setCellValue('C' . $i, date('d.m.Y', strtotime($log->created)));
                        $active_sheet->setCellValue('D' . $i, date('H:i:s', strtotime($log->created)));
                        $active_sheet->setCellValue('E' . $i, $log->new_values['event_name']);
                        $active_sheet->setCellValue('F' . $i, $managers[$log->manager_id]->name);

//                        $active_sheet->getStyle('C'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                        $active_sheet->getStyle('D'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                        $active_sheet->getStyle('E'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                        $active_sheet->getStyle('F'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//
                        $i++;
                    }

                    $rc++;

                    $active_sheet->getStyle('A' . $start_i . ':F' . ($i - 1))->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '666666')
                                )
                            )
                        )
                    );
                    $active_sheet->getStyle('A' . $start_i . ':F' . ($i - 1))->applyFromArray(
                        array(
                            'borders' => array(
                                'top' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                                    'color' => array('rgb' => '222222')
                                ),
                                'bottom' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                                    'color' => array('rgb' => '222222')
                                ),
                                'left' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                                    'color' => array('rgb' => '222222')
                                ),
                                'right' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                                    'color' => array('rgb' => '222222')
                                )
                            )
                        )
                    );
//                    $active_sheet->getStyle()->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                }

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

                $objWriter->save($this->config->root_dir . $filename);

                header('Location:' . $this->config->root_url . '/' . $filename);
                exit;
            }

        }

        return $this->design->fetch('statistics/sudlogs.tpl');
    }

    private function action_sources()
    {
        $integrations = $this->Integrations->get_integrations();
        $this->design->assign('integrations', $integrations);

        if ($action = $this->request->get('to-do', 'string')) {
            if ($action == 'report') {

                $daterange = $this->request->get('daterange');

                list($from, $to) = explode('-', $daterange);

                $date_from = date('Y-m-d', strtotime($from));
                $date_to = date('Y-m-d', strtotime($to));
                $this->design->assign('from', $from);
                $this->design->assign('to', $to);
                $this->design->assign('date_from', $date_from);
                $this->design->assign('date_to', $date_to);


                $filter = array();
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;

                foreach ($integrations as $integration) {
                    $filter['integrations'][] = $integration->utm_source;
                }

                $utm_source_filter = $this->request->get('utm_source_filter');
                $utm_medium_filter = $this->request->get('utm_medium_filter');
                $utm_campaign_filter = $this->request->get('utm_campaign_filter');
                $utm_term_filter = $this->request->get('utm_term_filter');
                $utm_content_filter = $this->request->get('utm_content_filter');


                if ($this->request->get('utm_source'))
                    $filter['utm_source'][] = 'utm_source';

                if ($this->request->get('utm_medium'))
                    $filter['utm_source'][] = 'utm_medium';

                if ($this->request->get('utm_campaign'))
                    $filter['utm_source'][] = 'utm_campaign';

                if ($this->request->get('utm_term'))
                    $filter['utm_source'][] = 'utm_term';

                if ($this->request->get('utm_content'))
                    $filter['utm_source'][] = 'utm_content';


                $filtres = [];


                if ($utm_source_filter) {
                    $filter['utm_source_filter'] = $this->request->get('utm_source_filter_val');
                    $filtres['utm_source_filter'] = $filter['utm_source_filter'];
                }

                if ($utm_medium_filter) {
                    $filter['utm_medium_filter'] = $this->request->get('utm_medium_filter_val');
                    $filtres['utm_medium_filter'] = $filter['utm_medium_filter'];
                }


                if ($utm_campaign_filter) {
                    $filter['utm_campaign_filter'] = $this->request->get('utm_campaign_filter_val');
                    $filtres['utm_campaign_filter'] = $filter['utm_campaign_filter'];
                }


                if ($utm_term_filter) {
                    $filter['utm_term_filter'] = $this->request->get('utm_term_filter_val');
                    $filtres['utm_term_filter'] = $filter['utm_term_filter'];
                }


                if ($utm_content_filter) {
                    $filter['utm_content_filter'] = $this->request->get('utm_content_filter_val');
                    $filtres['utm_content_filter'] = $filter['utm_content_filter'];
                }

                $this->design->assign('filtres', $filtres);

                $group_by = $this->request->get('group_by');
                $filter['date_group_by'] = $this->request->get('date_group_by');
                $filter['group_by'] = $group_by;

                $this->design->assign('date_group_by', $filter['date_group_by']);

                $orders = $this->orders->get_orders_by_utm($filter);

                $visits = $this->Visits->search_visits($filter);

                $this->design->assign('group_by', $group_by);

                $months = [
                    '01' => 'Январь',
                    '02' => 'Февраль',
                    '03' => 'Март',
                    '04' => 'Апрель',
                    '05' => 'Май',
                    '06' => 'Июнь',
                    '07' => 'Июль',
                    '08' => 'Август',
                    '09' => 'Сентябрь',
                    '10' => 'Октябрь',
                    '11' => 'Ноябрь',
                    '12' => 'Декабрь',
                ];

                $this->design->assign('months', $months);

                $all_params =
                    [
                        'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
                        'visits', 'all_orders', 'CR', 'orders_nk',
                        'orders_pk', 'orders_bk', 'accept_all',
                        'accept_nk', 'accept_pk', 'accept_bk',
                        'ar_all', 'ar_nk', 'ar_pk', 'ar_bk',
                        'reject_all', 'reject_all_prc',
                        'reject_nk', 'reject_nk_prc', 'reject_pk',
                        'reject_pk_prc', 'reject_bk', 'reject_bk_prc',
                        'check_all_summ', 'check_nk_summ', 'check_pk_summ',
                        'check_srch', 'check_srch_nk', 'check_srch_pk',
                        'orders_on_check'
                    ];

                foreach ($all_params as $k => $param) {
                    if ($this->request->get($param) == 1)
                        $all_get_params[$param] = $param;
                }

                $this->design->assign('all_get_params', $all_get_params);

                $months =
                    [
                        1 => 'Январь',
                        2 => 'Февраль',
                        3 => 'Март',
                        4 => 'Апрель',
                        5 => 'Май',
                        6 => 'Июнь',
                        7 => 'Июль',
                        8 => 'Август',
                        9 => 'Сентябрь',
                        10 => 'Октябрь',
                        11 => 'Ноябрь',
                        12 => 'Декабрь'
                    ];

                if ($filter['date_group_by'] == 'issuance') {

                    $contracts = $this->orders->get_orders_contracts_issuance($filter);

                    foreach ($orders as $key => $order) {
                        $orders[$key]->accept_all = 0;
                        $orders[$key]->accept_pk = 0;
                        $orders[$key]->accept_nk = 0;
                        $orders[$key]->accept_bk = 0;
                        foreach ($contracts as $k => $contract) {

                            if ($order->utm_source == $contract->utm_source) {
                                if ($contract->group_date == $order->group_date) {
                                    if ($this->request->get('accept_all') == 1)
                                        $orders[$key]->accept_all = ($contract->accept_all) ? $contract->accept_all : 0;

                                    if ($this->request->get('accept_pk') == 1)
                                        $orders[$key]->accept_pk = ($contract->accept_pk) ? $contract->accept_pk : 0;

                                    if ($this->request->get('accept_nk') == 1)
                                        $orders[$key]->accept_nk = ($contract->accept_nk) ? $contract->accept_nk : 0;

                                    if ($this->request->get('accept_bk') == 1)
                                        $orders[$key]->accept_bk = ($contract->accept_bk) ? $contract->accept_bk : 0;

                                }
                            }
                        }
                    }
                }

                if ($this->request->get('visits') == 1) {
                    foreach ($visits as $visit) {
                        foreach ($orders as $key => $order) {
                            if ($order->utm_source == $visit->utm_source) {
                                $orders[$key]->visits = $visit->count_visit;
                            }
                        }
                    }
                }

                foreach ($orders as $key => $order) {
                    if ($this->request->get('CR') == 1
                        && isset($order->all_orders)
                        && isset($order->visits)
                        && $order->all_orders != 0
                        && $order->visits != 0) {
                        $order->CR = (int)($order->all_orders / $order->visits * 100);
                    } else {
                        $order->CR = 0;
                    }

                    if ($this->request->get('ar_all') == 1
                        && isset($order->accept_all)
                        && isset($order->all_orders)
                        && $order->accept_all != 0
                        && $order->all_orders != 0) {
                        $order->ar_all = (int)($order->accept_all / $order->all_orders * 100);
                    } else {
                        $order->ar_all = 0;
                    }

                    if ($this->request->get('ar_nk') == 1
                        && isset($order->accept_nk)
                        && isset($order->orders_nk)
                        && $order->accept_nk != 0
                        && $order->orders_nk != 0) {
                        $order->ar_nk = (int)($order->accept_nk / $order->orders_nk * 100);
                    } else {
                        $order->ar_nk = 0;
                    }

                    if ($this->request->get('ar_pk') == 1
                        && isset($order->accept_pk)
                        && isset($order->orders_pk)
                        && $order->accept_pk != 0
                        && $order->orders_pk != 0) {
                        $order->ar_pk = (int)($order->accept_pk / $order->orders_pk * 100);
                    } else {
                        $order->ar_pk = 0;
                    }

                    if ($this->request->get('ar_bk') == 1
                        && isset($order->accept_bk)
                        && isset($order->orders_bk)
                        && $order->accept_bk != 0
                        && $order->orders_bk != 0) {
                        $order->ar_bk = (int)($order->accept_bk / $order->orders_bk * 100);
                    } else {
                        $order->ar_bk = 0;
                    }

                    if ($this->request->get('reject_all_prc') == 1
                        && isset($order->reject_all)
                        && isset($order->all_orders)
                        && $order->reject_all != 0
                        && $order->all_orders != 0) {
                        $order->reject_all_prc = (int)($order->reject_all / $order->all_orders * 100);
                    } else {
                        $order->reject_all_prc = 0;
                    }

                    if ($this->request->get('reject_nk_prc') == 1
                        && isset($order->reject_nk)
                        && isset($order->orders_nk)
                        && $order->reject_nk != 0
                        && $order->orders_nk != 0) {
                        $order->reject_nk_prc = (int)($order->reject_nk / $order->orders_nk * 100);
                    } else {
                        $order->reject_nk_prc = 0;
                    }

                    if ($this->request->get('reject_pk_prc') == 1
                        && isset($order->reject_pk)
                        && isset($order->orders_pk)
                        && $order->reject_pk != 0
                        && $order->orders_pk != 0) {
                        $order->reject_pk_prc = (int)($order->reject_pk / $order->orders_pk * 100);
                    } else {
                        $order->reject_pk_prc = 0;
                    }

                    if ($this->request->get('reject_bk_prc') == 1
                        && isset($order->reject_bk)
                        && isset($order->orders_bk)
                        && $order->reject_bk != 0
                        && $order->orders_bk != 0) {
                        $order->reject_bk_prc = (int)($order->reject_bk / $order->orders_bk * 100);
                    } else {
                        $order->reject_bk_prc = 0;
                    }
                }

                $i = 0;
                $results = array();

                foreach ($orders as $order) {
                    foreach ($all_get_params as $param) {
                        if (isset($order->{$param})) {

                            if ($group_by == 'week') {
                                $dto = new DateTime();
                                $dto->setISODate($order->year, $order->group_date);
                                $ret['week_start'] = $dto->format('d.m.Y');
                                $dto->modify('+6 days');
                                $ret['week_end'] = $dto->format('d.m.Y');

                                $key = $ret['week_start'] . ' - ' . $ret['week_end'];
                            } elseif ($group_by == 'month') {
                                $key = $months[$order->group_date];
                            } else {
                                $key = $order->group_date;
                            }

                            $results[$key][$i][$param] = $order->{$param};
                            $results[$key][$i]['visits'] = 0;
                        }
                    }
                    $i++;
                }

                $all_thead =
                    [
                        'utm_source' => 'Источник',
                        'utm_medium' => 'Канал',
                        'utm_campaign' => 'Кампания',
                        'utm_term' => 'Таргетинг',
                        'utm_content' => 'Контент',
                        'visits' => 'Визиты',
                        'all_orders' => 'Заявки',
                        'orders_nk' => 'Заявки НК',
                        'orders_pk' => 'Заявки ПК',
                        'orders_bk' => 'Заявки ПБ',
                        'CR' => 'CR %',
                        'accept_all' => 'Выдано',
                        'accept_nk' => 'Выдано НК',
                        'accept_pk' => 'Выдано ПК',
                        'accept_bk' => 'Выдано ПБ',
                        'ar_all' => 'AR %',
                        'ar_nk' => 'AR НК%',
                        'ar_pk' => 'AR ПК%',
                        'ar_bk' => 'AR ПБ%',
                        'reject_all' => 'Отказы',
                        'reject_all_prc' => 'Отказы %',
                        'reject_nk' => 'Отказы НК',
                        'reject_nk_prc' => 'Отказы НК%',
                        'reject_pk' => 'Отказы ПК',
                        'reject_pk_prc' => 'Отказы ПК%',
                        'reject_bk' => 'Отказы ПБ',
                        'reject_bk_prc' => 'Отказы ПБ%',
                        'check_all_summ' => 'Сумма',
                        'check_nk_summ' => 'Cумма НК',
                        'check_pk_summ' => 'Сумма ПК',
                        'check_srch' => 'СРЧ',
                        'check_srch_nk' => 'СРЧ НК',
                        'check_srch_pk' => 'СРЧ ПК',
                        'orders_on_check' => 'Проверка',
                    ];

                $group_results = array();
                $thead = array();

                foreach ($results as $key => $result) {
                    foreach ($result as $date => $value) {
                        foreach ($all_thead as $k => $head) {
                            if (array_key_exists($k, $value)) {
                                $group_results[$key][$date][$k] = $value[$k];
                                $thead[$k] = $head;
                            }
                        }
                    }
                }

                $this->design->assign('thead', $thead);
                $this->design->assign('results', $group_results);
            }
        }

        return $this->design->fetch('statistics/sources.tpl');
    }

    private function action_conversions()
    {
        if ($action = $this->request->get('to-do', 'string')) {
            if ($action == 'report') {

                $items_per_page = $this->request->get('page_count');

                if (empty($items_per_page))
                    $items_per_page = 25;

                $this->design->assign('page_count', $items_per_page);

                $daterange = $this->request->get('daterange');

                list($from, $to) = explode('-', $daterange);

                $date_from = date('Y-m-d', strtotime($from));
                $date_to = date('Y-m-d', strtotime($to));

                $this->design->assign('from', $from);
                $this->design->assign('to', $to);
                $this->design->assign('date_from', $date_from);
                $this->design->assign('date_to', $date_to);

                $filter = array();
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;

                if ($this->request->get('utm_source_filter')) {
                    $filter['utm_source_filter'] = $this->request->get('utm_source_filter_val');
                    $filtres['utm_source_filter'] = $filter['utm_source_filter'];
                }

                if ($this->request->get('utm_medium_filter')) {
                    $filter['utm_medium_filter'] = $this->request->get('utm_medium_filter_val');
                    $filtres['utm_medium_filter'] = $filter['utm_medium_filter'];
                }


                if ($this->request->get('utm_campaign_filter')) {
                    $filter['utm_campaign_filter'] = $this->request->get('utm_campaign_filter_val');
                    $filtres['utm_campaign_filter'] = $filter['utm_campaign_filter'];
                }


                if ($this->request->get('utm_term_filter')) {
                    $filter['utm_term_filter'] = $this->request->get('utm_term_filter_val');
                    $filtres['utm_term_filter'] = $filter['utm_term_filter'];
                }


                if ($this->request->get('utm_content_filter')) {
                    $filter['utm_content_filter'] = $this->request->get('utm_content_filter_val');
                    $filtres['utm_content_filter'] = $filter['utm_content_filter'];
                }

                if (isset($filtres))
                    $this->design->assign('filtres', $filtres);


                if ($this->request->get('date_filter') == 1)
                    $filter['issuance'] = 1;

                $date_select = $this->request->get('date_filter');
                $this->design->assign('date_select', $date_select);

                $all_checkbox = [
                    'id' => 'Заявка',
                    'utm_source' => 'Источник',
                    'utm_medium' => 'Канал',
                    'utm_campaign' => 'Кампания',
                    'utm_term' => 'Таргетинг',
                    'click_hash' => 'Контент',
                    'client_status' => 'Статус клиента',
                    'status' => 'Статус заявки',
                    'leadcraft_postback_type' => 'Постбэк'
                ];

                $thead = array();

                $orders_statuses =
                    [
                        0 => 'Принята',
                        1 => 'На рассмотрении',
                        2 => 'Одобрена',
                        3 => 'Отказ',
                        4 => 'Готов к выдаче',
                        5 => 'Займ выдан',
                        6 => 'Не удалось выдать',
                        7 => 'Погашен',
                        8 => 'Отказ клиента',
                    ];

                $this->design->assign('orders_statuses', $orders_statuses);

                foreach ($all_checkbox as $key => $checkbox) {
                    if ($this->request->get($key) == 1) {
                        $filter['select'][] = $key;
                        $thead[$key] = $checkbox;
                    }
                }

                $current_page = $this->request->get('page', 'integer');
                $current_page = max(1, $current_page);
                $this->design->assign('current_page_num', $current_page);

                $orders = $this->orders->get_orders_for_conversions($filter);
                $orders_count = count($orders);

                $filter['page'] = $current_page;
                $filter['limit'] = $items_per_page;
                $orders = $this->orders->get_orders_for_conversions($filter);

                $pages_num = ceil($orders_count / $items_per_page);

                $this->design->assign('total_pages_num', $pages_num);
                $this->design->assign('total_orders_count', $orders_count);

                $this->design->assign('thead', $thead);
                $this->design->assign('orders', $orders);

                if ($this->request->get('download') == 'excel') {

                    unset($filter['page']);
                    unset($filter['limit']);

                    $orders = $this->orders->get_orders_for_conversions($filter);

                    $filename = 'files/reports/conversions.xls';
                    require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

                    $excel = new PHPExcel();

                    $excel->setActiveSheetIndex(0);
                    $active_sheet = $excel->getActiveSheet();

                    $active_sheet->setTitle($from . "-" . $to);

                    $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
                    $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $active_sheet->getColumnDimension('A')->setWidth(25);
                    $active_sheet->setCellValue('A1', 'Дата');

                    $characters = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
                    $checkboxes = array_values($thead);

                    for ($i = 0; $i <= count($thead); $i++) {
                        $active_sheet->getColumnDimension("$characters[$i]")->setWidth(30);
                        $active_sheet->setCellValue("$characters[$i]" . '1', $checkboxes[$i]);
                    }

                    $i = 2;
                    foreach ($orders as $key => $order) {

                        $active_sheet->setCellValue('A' . $i, date('d.m.Y', strtotime($order->date)));

                        $ch = 0;
                        foreach ($order as $k => $value) {
                            if ($k != 'date') {
                                if ($k == 'status') {
                                    foreach ($orders_statuses as $kii => $status) {
                                        if ($kii == $value) {
                                            $active_sheet->setCellValue("$characters[$ch]" . $i, $status);
                                        }
                                    }
                                } else {
                                    $active_sheet->setCellValue("$characters[$ch]" . $i, $value);
                                }
                                $ch++;
                            }
                        }

                        $i++;
                    }

                    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

                    $objWriter->save($this->config->root_dir . $filename);

                    header('Location:' . $this->config->root_url . '/' . $filename);
                    exit;
                }
            }
        }

        return $this->design->fetch('statistics/conversions.tpl');
    }

    private function action_reminders()
    {
        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);

            $filter['date_from'] = date('Y-m-d 00:00:00', strtotime($date_from));
            $filter['date_to'] = date('Y-m-d 23:59:59', strtotime($date_to));

            $reminders = $this->Reminders->get_reminders($filter);
            $this->design->assign('reminders', $reminders);
        }

        return $this->design->fetch('statistics/reminders.tpl');
    }

    private function action_divisions()
    {
        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);

            $date_to_plus = date("Y-m-d", strtotime("+1 days", strtotime($date_to)));
            
            // $date_from = '0000-00-00';


            $query = $this->db->placehold("
            SELECT date, status
            FROM __orders
            WHERE  DATE(date) >= ? AND DATE(date) <= ? 
            ", $date_from, $date_to);
            $this->db->query($query);

            $orders = $this->db->results();

            $orders_array = [];
            $orders_array['count_all'] = 0;
            $orders_array['count_issued'] = 0;
            $orders_array['count_rejected'] = 0;
            $orders_array['count_waiting'] = 0;

            foreach ($orders as $order) {
                $orders_array['count_all'] += 1;
                if ($order->status == 5 || $order->status == 7)
                    $orders_array['count_issued'] += 1;
                elseif ($order->status == 0 || $order->status == 1 || $order->status == 2 || $order->status == 4)
                    $orders_array['count_waiting'] += 1;
                else
                    $orders_array['count_rejected'] += 1;
            }

            $query = $this->db->placehold("
                SELECT accept_date, close_date, status 
                FROM __contracts 
                WHERE  DATE(accept_date) >= ? AND DATE(accept_date) <= ? 
                AND (status=2 OR status=3 OR status=4)
                    ", $date_from, $date_to);
            $this->db->query($query);
            $new_clients = $this->db->results();

            $query = $this->db->placehold("
                SELECT user_id, count(*) as cou 
                FROM __contracts 
                GROUP BY user_id 
                    ");
            $this->db->query($query);

            $all_clients = $this->db->results();

            $all_clients_array = [];
            $all_clients_array['all'] = 0;
            $all_clients_array['active'] = 0;
            $all_clients_array['passive'] = 0;
            $all_clients_array['delay'] = 0;

            foreach ($all_clients as $all_client) {
                $contracts = $this->contracts->get_contracts(array('user_id' => $all_client->user_id));
                $contract = end($contracts);

                $all_clients_array['all'] += 1;
                if(is_null($contract->close_date) || $contract->close_date > $date_to_plus)
                    $all_clients_array['active'] += 1;
                else
                    $all_clients_array['passive'] += 1;

                if(is_null($contract->close_date) && $contract->return_date < $date_to_plus)
                    $all_clients_array['delay'] += 1;

                if(is_null($contract->close_date) && $contract->return_date < $date_to_plus)
                    $all_clients_array['delay'] += 1;
                
                // if($contract->prolongation && $contract->return_date < $date_to_plus)
                //     $all_clients_array['prolongation'] += 1;
            }

            $query = $this->db->placehold("
            SELECT count(contract_id) as cou 
            FROM __prolongations 
            WHERE  DATE(created) >= ? AND DATE(created) <= ? 
            ", $date_from, $date_to);

            $this->db->query($query);

            $all_clients_array['prolongation'] = $this->db->results()[0]->cou;

            $query = $this->db->placehold("
                SELECT amount 
                FROM __operations
                WHERE type='PAY' AND
                DATE(created) >= ? AND DATE(created) <= ? 
            ", $date_from, $date_to);
            $this->db->query($query);

            $payments = $this->db->results();

            $payments_array = [];
            $payments_array['count'] = 0;
            $payments_array['sum'] = 0;
            $payments_array['average'] = 0;

            foreach ($payments as $payment) {
                $payments_array['count'] += 1;
                $payments_array['sum'] += $payment->amount;
            }
            if($payments_array['count'] > 0 )
                $payments_array['average'] = round($payments_array['sum'] / $payments_array['count'], 2);


            $query = $this->db->placehold("
            SELECT
                c.loan_body_summ,
                c.loan_percents_summ,
                c.loan_peni_summ,
                c.status
            FROM __contracts AS c
            WHERE c.status = 4
            ");
            $this->db->query($query);

            $sum_contracts = $this->db->results();

            $sum_contracts_array = [];
            $sum_contracts_array['risk'] = 0;
            $sum_contracts_array['active_sum'] = 0;

            foreach ($sum_contracts as $sum_contract) {
                if($sum_contract->status == 4){
                    $sum_contracts_array['risk'] += $sum_contract->loan_body_summ + $sum_contract->loan_percents_summ + $sum_contract->loan_peni_summ;
                }
                if($sum_contract->status == 2 || $sum_contract->status == 4){
                    $sum_contracts_array['active_sum'] += $sum_contract->loan_body_summ;
                }
            }


            $query = $this->db->placehold("
            SELECT id, status
            FROM __contracts 
            WHERE status = 2  OR status = 4
            ORDER BY id
            ");
            $this->db->query($query);

            $pay_debts = $this->db->results();

            $pay_debts_array = [];
            $pay_debts_array ['count'] = 0;
            $pay_debts_array ['body'] = 0;
            $pay_debts_array ['percents'] = 0;

            foreach ($pay_debts as $pay_debt) {
                $contract_operations = $this->operations->operations->get_operations(array('contract_id'=>$pay_debt->id));

                $getting_percents = false;
                $loan_body_summ = 0;
                $loan_percents_summ = 0;
                $loan_peni_summ = 0;

                foreach ($contract_operations as $contract_operation) {
                    if($contract_operation->type == 'PERCENTS'){
                        if($contract_operation->loan_body_summ > $loan_body_summ)
                            $loan_body_summ = $contract_operation->loan_body_summ;
                        if($contract_operation->loan_percents_summ > $loan_percents_summ)
                            $loan_percents_summ = $contract_operation->loan_percents_summ;
                        if($contract_operation->loan_peni_summ > $loan_peni_summ)
                            $loan_peni_summ = $contract_operation->loan_peni_summ;
                    }
                    else{
                        if(!$getting_percents){
                            $loan_body_summ = $contract_operation->amount;
                        }
                    }
                }
                $pay_debts_array ['count'] += 1;
                $pay_debts_array ['body'] += $loan_body_summ;
                $pay_debts_array ['percents'] += $loan_percents_summ;
            }


            $query = $this->db->placehold("
            SELECT id, status
            FROM __contracts 
            WHERE status = 3 
            AND DATE(close_date) >= ? AND DATE(close_date) <= ?
            ORDER BY id
            ", $date_from, $date_to);
            $this->db->query($query);

            $payd_debts = $this->db->results();

            $payd_debts_array = [];
            $payd_debts_array ['count'] = 0;
            $payd_debts_array ['body'] = 0;
            $payd_debts_array ['percents'] = 0;
            $payd_debts_array ['peni'] = 0;
            $payd_debts_array ['all'] = 0;

            foreach ($payd_debts as $payd_debt) {
                $contract_operations = $this->operations->operations->get_operations(array('contract_id'=>$payd_debt->id));

                $getting_percents = false;
                $loan_body_summ = 0;
                $loan_percents_summ = 0;
                $loan_peni_summ = 0;

                foreach ($contract_operations as $contract_operation) {
                    if($contract_operation->type == 'PERCENTS'){
                        if($contract_operation->loan_body_summ > $loan_body_summ)
                            $loan_body_summ = $contract_operation->loan_body_summ;
                        if($contract_operation->loan_percents_summ > $loan_percents_summ)
                            $loan_percents_summ = $contract_operation->loan_percents_summ;
                        if($contract_operation->loan_peni_summ > $loan_peni_summ)
                            $loan_peni_summ = $contract_operation->loan_peni_summ;
                    }
                    else{
                        if(!$getting_percents){
                            $loan_body_summ = $contract_operation->amount;
                        }
                    }
                }
                $payd_debts_array['count'] += 1;
                $payd_debts_array['body'] += $loan_body_summ;
                $payd_debts_array['percents'] += $loan_percents_summ;
                $payd_debts_array['peni'] += $loan_peni_summ;
                $payd_debts_array['all'] += $loan_peni_summ + $loan_percents_summ + $loan_body_summ;
            }


            $query = $this->db->placehold("
                SELECT amount 
                FROM __operations
                WHERE (type = 'INSURANCE' OR type = 'BUD_V_KURSE' OR type = 'REJECT_REASON')
                AND DATE(created) >= ? AND DATE(created) <= ? 
            ", $date_from, $date_to);
            $this->db->query($query);

            $services = $this->db->results();

            $services_array = [];
            $services_array['count'] = 0;
            $services_array['amount'] = 0;

            foreach ($services as $service) {
                $services_array['count'] += 1;
                $services_array['amount'] += $service->amount;
            }

            
            $this->design->assign('orders_array', $orders_array);
            $this->design->assign('new_clients', $new_clients);
            $this->design->assign('all_clients_array', $all_clients_array);
            $this->design->assign('payments_array', $payments_array);
            $this->design->assign('sum_contracts_array', $sum_contracts_array);
            $this->design->assign('pay_debts_array', $pay_debts_array);
            $this->design->assign('payd_debts_array', $payd_debts_array);
            $this->design->assign('services_array', $services_array);
            
        }

        return $this->design->fetch('statistics/divisions.tpl');
    }

    private function action_active()
    {
        if ($date = $this->request->get('date')) {
            $this->design->assign('date', $date);
            $query = $this->db->placehold("
                SELECT
                    u.id as user_id,
                    u.lastname,
                    u.firstname,
                    u.patronymic,
                    c.id AS contract_id,
                    c.number,
                    c.inssuance_date AS date,
                    c.base_percent,
                    c.amount,
                    c.status,
                    c.return_date,
                    c.stop_profit,             
                    c.prolongation,             
                    c.period             
                    FROM __contracts AS c
                    LEFT JOIN __users AS u
                    ON u.id = c.user_id
                    WHERE DATE(c.inssuance_date) <= ?
                    AND (DATE(c.close_date) >= ? 
                    OR c.close_date IS null)
                    AND c.status <> 3
                    ORDER BY contract_id
                ", $date, $date, $date);
                    
            $this->db->query($query);

            $contracts = array();
            $cou = 0;
            foreach ($this->db->results() as $c) {

                $contracts[$c->contract_id] = $c;

                $query = $this->db->placehold("
                    SELECT created
                    FROM __operations WHERE
                    created IN (
                        SELECT max(created) 
                        FROM __operations 
                        WHERE contract_id=" . $c->contract_id . " AND type='PAY') 
                    AND contract_id=" . $c->contract_id
                );
                $this->db->query($query);

                $last_pay = $this->db->results();
                if (count($last_pay))
                    $contracts[$c->contract_id]->last_pay = $last_pay[0]->created;
                else
                    $contracts[$c->contract_id]->last_pay = '';



                $query = $this->db->placehold("
                    SELECT count(*) as cou
                    FROM __operations 
                    WHERE contract_id=" . $c->contract_id . " AND type='PAY'"
                );
                $this->db->query($query);
                
                $payments_count = $this->db->results();
                if(count($payments_count))
                    $contracts[$c->contract_id]->payments_count = $payments_count[0]->cou;
                else
                    $contracts[$c->contract_id]->payments_count = '';   

                if (count($last_pay) > 0)
                    $contracts[$c->contract_id]->last_pay = $last_pay[0]->created;
                else
                    $contracts[$c->contract_id]->last_pay = '';



                $query = $this->db->placehold("
                    SELECT loan_body_summ, loan_percents_summ, loan_peni_summ, created
                    FROM __operations WHERE
                    created IN (
                        SELECT max(created) 
                        FROM __operations 
                        WHERE contract_id=" . $c->contract_id . " AND (type='PERCENTS' OR type='PENI')) 
                    AND contract_id=" . $c->contract_id
                );
                $this->db->query($query);

                $balance = $this->db->results();
                if(count($balance) > 0)
                    $contracts[$c->contract_id]->balance = $balance[0];
                else
                    $contracts[$c->contract_id]->balance = '';

                

                $today = date_create(date('Y-m-d 00:00:00'));
                $inssuance_date = date_create(date('Y-m-d 00:00:00', strtotime($c->date)));
                $delay = date_diff($today, $inssuance_date)->days - $c->period;
                $contracts[$c->contract_id]->delay_fakt = $delay;
                
                $return_date = date_create(date('Y-m-d 00:00:00', strtotime($c->return_date)));
                $delay = date_diff($today, $return_date)->days;
                $contracts[$c->contract_id]->delay_status = $delay;
            }

            if ($this->request->get('download') == 'excel') {

                $filename = 'files/reports/active.xls';
                require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

                $excel = new PHPExcel();

                $excel->setActiveSheetIndex(0);
                $active_sheet = $excel->getActiveSheet();

                $active_sheet->setTitle("Активные займы");

                $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
                $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $active_sheet->getColumnDimension('A')->setWidth(15);
                $active_sheet->getColumnDimension('B')->setWidth(15);
                $active_sheet->getColumnDimension('C')->setWidth(15);
                $active_sheet->getColumnDimension('D')->setWidth(20);
                $active_sheet->getColumnDimension('E')->setWidth(20);
                $active_sheet->getColumnDimension('F')->setWidth(20);
                $active_sheet->getColumnDimension('G')->setWidth(20);
                $active_sheet->getColumnDimension('H')->setWidth(20);
                $active_sheet->getColumnDimension('I')->setWidth(20);
                $active_sheet->getColumnDimension('J')->setWidth(20);
                $active_sheet->getColumnDimension('K')->setWidth(20);
                $active_sheet->getColumnDimension('L')->setWidth(20);
                $active_sheet->getColumnDimension('M')->setWidth(20);
                $active_sheet->getColumnDimension('N')->setWidth(20);
                $active_sheet->getColumnDimension('O')->setWidth(20);
                $active_sheet->getColumnDimension('P')->setWidth(20);
                $active_sheet->getColumnDimension('Q')->setWidth(20);
                $active_sheet->getColumnDimension('R')->setWidth(20);
                $active_sheet->getColumnDimension('S')->setWidth(20);
                $active_sheet->getColumnDimension('T')->setWidth(20);
                $active_sheet->getColumnDimension('U')->setWidth(20);
                $active_sheet->getColumnDimension('V')->setWidth(20);
                $active_sheet->getColumnDimension('W')->setWidth(20);
                $active_sheet->getColumnDimension('X')->setWidth(20);
                $active_sheet->getColumnDimension('Y')->setWidth(20);
                $active_sheet->getColumnDimension('Z')->setWidth(20);
                $active_sheet->getColumnDimension('AA')->setWidth(15);
                $active_sheet->getColumnDimension('AB')->setWidth(15);
                $active_sheet->getColumnDimension('AС')->setWidth(15);           

                $active_sheet->setCellValue('A1', '№');
                $active_sheet->setCellValue('B1', '№ по гр.');
                $active_sheet->setCellValue('C1', 'Регион');
                $active_sheet->setCellValue('D1', 'Филиал');
                $active_sheet->setCellValue('E1', 'Подразделение');
                $active_sheet->setCellValue('F1', 'Источник финансирования');
                $active_sheet->setCellValue('G1', 'Клиент');
                $active_sheet->setCellValue('H1', 'Контракт');
                $active_sheet->setCellValue('I1', 'Дата выдачи');
                $active_sheet->setCellValue('J1', 'Дата последнего погашения');
                $active_sheet->setCellValue('K1', 'Дата последнего начисления');
                $active_sheet->setCellValue('L1', 'Процентная ставка');
                $active_sheet->setCellValue('M1', 'Кол-во траншей');
                $active_sheet->setCellValue('N1', 'Кол-во льготных периодов');
                $active_sheet->setCellValue('O1', 'Сумма займа');
                $active_sheet->setCellValue('P1', 'Баланс по ОД');
                $active_sheet->setCellValue('Q1', 'Баланс по %');
                $active_sheet->setCellValue('R1', 'Баланс по штрафам');
                $active_sheet->setCellValue('S1', 'Тип займа');
                $active_sheet->setCellValue('T1', 'Статус контракта');
                $active_sheet->setCellValue('U1', 'Количество дней просрочки по статусу');
                $active_sheet->setCellValue('V1', 'Количество дней просрочки фактическое');
                $active_sheet->setCellValue('W1', 'Остановка начисления процентов');
                $active_sheet->setCellValue('X1', 'Дата остановки начисления процентов');
                $active_sheet->setCellValue('Y1', 'Остановка начисления штрафов');
                $active_sheet->setCellValue('Z1', 'Дата остановки начисления штрафов');
                $active_sheet->setCellValue('AA1', 'Судебник');
                $active_sheet->setCellValue('AB1', 'Дата признака Судебник');
                $active_sheet->setCellValue('AC1', 'Пользовательский статус контракта');

                $i = 2;
                foreach ($contracts as $contract) {
                    
                    $active_sheet->setCellValue('A' . $i, $i - 1);
                    $active_sheet->setCellValue('B' . $i, $i - 1);
                    $active_sheet->setCellValue('C' . $i, 'Россия');
                    $active_sheet->setCellValue('D' . $i, 'Головной');
                    $active_sheet->setCellValue('E' . $i, 'Основное');
                    $active_sheet->setCellValue('F' . $i, 'Собственные средства');
                    $active_sheet->setCellValue('G' . $i, $contract->lastname . ' ' . $contract->firstname . ' ' . $contract->patronymic);
                    $active_sheet->setCellValue('H' . $i, $contract->number);
                    $active_sheet->setCellValue('I' . $i, date('d.m.Y', strtotime($contract->date)));

                    $last_pay = '';
                    if ($contract->last_pay)
                        $last_pay = date('d.m.Y', strtotime($contract->last_pay));

                    $active_sheet->setCellValue('J' . $i, date('d.m.Y', strtotime($last_pay)));

                    $balance = '';
                    if ($contract->balance)
                        $balance = date('d.m.Y', strtotime($contract->balance->created));

                    $active_sheet->setCellValue('K' . $i, $balance);
                    $active_sheet->setCellValue('L' . $i, $contract->base_percent);
                    $active_sheet->setCellValue('M' . $i, $contract->payments_count);
                    $active_sheet->setCellValue('N' . $i, '');
                    $active_sheet->setCellValue('O' . $i, $contract->amount);

                    $loan_body_summ = 0;
                    if ($contract->balance)
                        $loan_body_summ = $contract->balance->loan_body_summ;

                    $active_sheet->setCellValue('P' . $i, $loan_body_summ);

                    $loan_percents_summ = 0;
                    if ($contract->balance)
                        $loan_percents_summ = $contract->balance->loan_percents_summ;

                    $active_sheet->setCellValue('Q' . $i, $loan_percents_summ);

                    $loan_peni_summ = 0;
                    if ($contract->balance)
                        $loan_peni_summ = $contract->balance->loan_peni_summ;
                    

                    $active_sheet->setCellValue('R' . $i, $loan_peni_summ);
                    $active_sheet->setCellValue('S' . $i, 'Краткосрочный');

                    if ($contract->status == 2)
                        $status = 'Выданный';
                    elseif ($contract->status == 4)
                        $status = 'Просроченный'; 
                    else
                        $status = '---'; 

                    $active_sheet->setCellValue('T' . $i, $status);
                    $active_sheet->setCellValue('U' . $i, $contract->delay_status);
                    $active_sheet->setCellValue('V' . $i, $contract->delay_fakt);

                    if ($contract->stop_profit)
                        $stop_profit = 'Да';
                    else
                        $stop_profit = 'Нет';

                    $active_sheet->setCellValue('W' . $i, $stop_profit);

                    $stop_percents = '';
                    if ($contract->stop_profit){
                        if ($contract->balance)
                            $stop_percents =date('d.m.Y', strtotime($contract->balance->created));
                    }

                    $active_sheet->setCellValue('X' . $i, $stop_percents);

                    if ($contract->stop_profit)
                        $stop_profit = 'Да';
                    else
                        $stop_profit = 'Нет';

                    $active_sheet->setCellValue('Y' . $i, $stop_profit);

                    $stop_peni = '';
                    if ($contract->stop_profit){
                        if ($contract->balance)
                            $stop_peni = $contract->balance->created;
                    }

                    $active_sheet->setCellValue('Z' . $i, date('d.m.Y', strtotime($stop_peni)));
                    $active_sheet->setCellValue('AA' . $i, '');
                    $active_sheet->setCellValue('AB' . $i, '');


                    if ($contract->status == 2)
                        $user_status = 'Выдан';
                    elseif ($contract->status == 4)
                        $user_status = 'Просрочен'; 
                    else
                        $user_status = '---'; 

                    $active_sheet->setCellValue('AC' . $i, $user_status);

                    $i++;
                }

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

                $objWriter->save($this->config->root_dir . $filename);

                header('Location:' . $this->config->root_url . '/' . $filename);
                exit;
            }

            $this->design->assign('contracts', $contracts);
        }
        return $this->design->fetch('statistics/active.tpl');
    }


    private function action_delay()
    {

        $query = $this->db->placehold("
            SELECT
                u.lastname,
                u.firstname,
                u.patronymic,
                u.birth,
                u.birth_place,
                u.passport_serial,
                u.passport_issued,
                u.passport_date,
                u.phone_mobile,
                u.contact_person_phone,
                u.contact_person_name,
                u.contact_person2_phone,
                u.contact_person2_name,
                u.workphone,
                u.id as user_id,
                c.id AS contract_id,
                c.inssuance_date AS date,
                c.number,
                c.amount,
                c.close_date,
                c.return_date,
                c.loan_body_summ,
                c.loan_percents_summ,
                c.loan_peni_summ,
                u.regaddress_id,
                u.faktaddress_id
            FROM __contracts AS c
            LEFT JOIN __users AS u
            ON u.id = c.user_id
            WHERE c.status = 4
            ORDER BY contract_id
        ");
        $this->db->query($query);

        $contracts = array();
        $cou = 0;
        foreach ($this->db->results() as $c) {

            $contracts[$c->contract_id] = $c;

            if($c->passport_serial){
                $passport = explode("-", $c->passport_serial);
                $contracts[$c->contract_id]->passport_ser = $passport[0];
                $contracts[$c->contract_id]->passport_num = $passport[1];
            }

            $cards = $this->cards->get_cards(array('user_id' => $c->user_id));
            if($cards)
                $contracts[$c->contract_id]->pan = $cards[0]->pan;

            $today = date_create(date('Y-m-d 00:00:00'));
            $inssuance_date = date_create(date('Y-m-d 00:00:00', strtotime($c->date)));
            $contracts[$c->contract_id]->delay = date_diff($today, $inssuance_date)->days;

            if ($c->status == 3) {
                if (strtotime($c->close_date) > strtotime($c->return_date)) {
                    $datetime1 = date_create(date('Y-m-d 00:00:00', strtotime($c->close_date)));
                    $datetime2 = date_create(date('Y-m-d 00:00:00', strtotime($c->return_date)));
                    $interval = date_diff($datetime1, $datetime2);
                    $contracts[$c->contract_id]->delay = $interval->days;
                }
            } else {
                if (strtotime(date('Y-m-d H:i:s')) > strtotime($c->return_date)) {
                    $datetime1 = date_create(date('Y-m-d 00:00:00'));
                    $datetime2 = date_create(date('Y-m-d 00:00:00', strtotime($c->return_date)));
                    $interval = date_diff($datetime1, $datetime2);
                    $contracts[$c->contract_id]->delay = $interval->days;
                }
            }
            
            $contracts[$c->contract_id]->regaddress = '';
            if(null != $this->Addresses->get_address($c->regaddress_id))
                $contracts[$c->contract_id]->regaddress = $this->Addresses->get_address($c->regaddress_id)->adressfull ;
            
            $contracts[$c->contract_id]->faktaddress = '';
            if(null != $this->Addresses->get_address($c->faktaddress_id))
                $contracts[$c->contract_id]->faktaddress = $this->Addresses->get_address($c->faktaddress_id)->adressfull ;

        }

        if ($this->request->get('download') == 'excel') {

            $filename = 'files/reports/delay.xls';
            require $this->config->root_dir . 'PHPExcel/Classes/PHPExcel.php';

            $excel = new PHPExcel();

            $excel->setActiveSheetIndex(0);
            $active_sheet = $excel->getActiveSheet();

            $active_sheet->setTitle("Активные займы");

            $excel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
            $excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $active_sheet->getColumnDimension('A')->setWidth(15);
            $active_sheet->getColumnDimension('B')->setWidth(15);
            $active_sheet->getColumnDimension('C')->setWidth(15);
            $active_sheet->getColumnDimension('D')->setWidth(20);
            $active_sheet->getColumnDimension('E')->setWidth(20);
            $active_sheet->getColumnDimension('F')->setWidth(20);
            $active_sheet->getColumnDimension('G')->setWidth(20);
            $active_sheet->getColumnDimension('H')->setWidth(20);
            $active_sheet->getColumnDimension('I')->setWidth(20);
            $active_sheet->getColumnDimension('J')->setWidth(20);
            $active_sheet->getColumnDimension('K')->setWidth(20);
            $active_sheet->getColumnDimension('L')->setWidth(20);
            $active_sheet->getColumnDimension('M')->setWidth(20);
            $active_sheet->getColumnDimension('N')->setWidth(20);
            $active_sheet->getColumnDimension('O')->setWidth(20);
            $active_sheet->getColumnDimension('P')->setWidth(20);
            $active_sheet->getColumnDimension('Q')->setWidth(20);
            $active_sheet->getColumnDimension('R')->setWidth(20);
            $active_sheet->getColumnDimension('S')->setWidth(20);
            $active_sheet->getColumnDimension('T')->setWidth(20);
            $active_sheet->getColumnDimension('U')->setWidth(20);
            $active_sheet->getColumnDimension('V')->setWidth(20);
            $active_sheet->getColumnDimension('W')->setWidth(20);
            $active_sheet->getColumnDimension('X')->setWidth(20);
            $active_sheet->getColumnDimension('Y')->setWidth(20);
            $active_sheet->getColumnDimension('Z')->setWidth(20);
            $active_sheet->getColumnDimension('AA')->setWidth(15);
            $active_sheet->getColumnDimension('AB')->setWidth(15);
            $active_sheet->getColumnDimension('AС')->setWidth(15);           
            $active_sheet->getColumnDimension('AD')->setWidth(15);           

            $active_sheet->setCellValue('A1', 'Номер по порядку');
            $active_sheet->setCellValue('B1', 'Фамилия Должника');
            $active_sheet->setCellValue('C1', 'Имя Должника');
            $active_sheet->setCellValue('D1', 'Отчество Должника');
            $active_sheet->setCellValue('E1', 'Дата рождения Должника');
            $active_sheet->setCellValue('F1', 'Место рождения Должника');
            $active_sheet->setCellValue('G1', 'Серия паспорта Должника');
            $active_sheet->setCellValue('H1', 'Номер паспорта Должника');
            $active_sheet->setCellValue('I1', 'Кем выдан паспорт Должника');
            $active_sheet->setCellValue('J1', 'Дата выдачи паспорта');

            $active_sheet->setCellValue('K1', 'Телефоны Должника');
            $active_sheet->setCellValue('L1', 'Телефон 1 контакта и ФИО');
            $active_sheet->setCellValue('M1', 'Телефон 2 контакта и ФИО');
            $active_sheet->setCellValue('N1', 'Рабочий телефон');
            $active_sheet->setCellValue('O1', 'Программа кредитования Должника');

            $active_sheet->setCellValue('P1', 'Дата выдачи');
            $active_sheet->setCellValue('Q1', 'Номер кредитного договора');
            $active_sheet->setCellValue('R1', 'Номер счета для погашения задолженности');
            $active_sheet->setCellValue('S1', 'Сумма кредитного лимита');
            $active_sheet->setCellValue('T1', 'Валюта кредитного лимита');

            $active_sheet->setCellValue('U1', 'Дата возникновения просроченной задолженности');
            $active_sheet->setCellValue('V1', 'Количество дней просрочки');
            $active_sheet->setCellValue('W1', 'Дата фиксации задолженности');
            $active_sheet->setCellValue('X1', 'Сумма задолженности по основному долгу');
            $active_sheet->setCellValue('Y1', 'Сумма задолженности по процентам');

            $active_sheet->setCellValue('Z1', 'Сумма задолженности по штрафам');
            $active_sheet->setCellValue('AA1', 'бщая сумма взыскиваемой задолженности');
            $active_sheet->setCellValue('AB1', 'Адрес проживания');
            $active_sheet->setCellValue('AC1', 'Адрес регистрации');
            $active_sheet->setCellValue('AD1', 'Пользовательский статус контракта');

            $i = 2;
            foreach ($contracts as $contract) {
                
                $active_sheet->setCellValue('A' . $i, $i - 1);
                $active_sheet->setCellValue('B' . $i, $contract->lastname);
                $active_sheet->setCellValue('C' . $i, $contract->firstname);
                $active_sheet->setCellValue('D' . $i, $contract->patronymic);
                $active_sheet->setCellValue('E' . $i, date('d.m.Y', strtotime($contract->birth)));
                $active_sheet->setCellValue('F' . $i, $contract->birth_place);
                $active_sheet->setCellValue('G' . $i, $contract->passport_ser);
                $active_sheet->setCellValue('H' . $i, $contract->passport_num);
                $active_sheet->setCellValue('I' . $i, $contract->passport_issued);
                $active_sheet->setCellValue('J' . $i, date('d.m.Y', strtotime($contract->passport_date)));

                $active_sheet->setCellValue('K' . $i, $contract->phone_mobile);
                $active_sheet->setCellValue('L' . $i, $contract->contact_person_phone . ", ". $contract->contact_person_name);
                $active_sheet->setCellValue('M' . $i, $contract->contact_person2_phone . ", ". $contract->contact_person2_name);
                $active_sheet->setCellValue('N' . $i, $contract->workphone);
                $active_sheet->setCellValue('O' . $i, '');

                $active_sheet->setCellValue('P' . $i, date('d.m.Y', strtotime($contract->date)));
                $active_sheet->setCellValue('Q' . $i, $contract->number);
                $active_sheet->setCellValue('R' . $i, $pcontract->an);
                $active_sheet->setCellValue('S' . $i, $contract->amount);
                $active_sheet->setCellValue('T' . $i, 'Рубли');

                $active_sheet->setCellValue('U' . $i, date('d.m.Y', strtotime($contract->return_date)));
                $active_sheet->setCellValue('V' . $i, $contract->delay);
                $active_sheet->setCellValue('W' . $i, date('d.m.Y'));
                $active_sheet->setCellValue('X' . $i, $contract->loan_body_summ);
                $active_sheet->setCellValue('Y' . $i, $contract->loan_percents_summ);
                $active_sheet->setCellValue('Z' . $i, $contract->loan_peni_summ);

                $full_summ = 0;
                // if ($contract->balance)
                //     $full_summ = $contract->balance->loan_body_summ + $contract->balance->loan_percents_summ + $contract->balance->loan_peni_summ;
                $full_summ = $contract->loan_body_summ + $contract->loan_percents_summ + $contract->loan_peni_summ;

                $active_sheet->setCellValue('AA' . $i, $full_summ);
                $active_sheet->setCellValue('AB' . $i, $contract->faktaddress);
                $active_sheet->setCellValue('AC' . $i, $contract->regaddress);
                $active_sheet->setCellValue('AD' . $i, 'Просрочен');

                $i++;
            }

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

            $objWriter->save($this->config->root_dir . $filename);

            header('Location:' . $this->config->root_url . '/' . $filename);
            exit;
        }

        $this->design->assign('contracts', $contracts);

        return $this->design->fetch('statistics/delay.tpl');
    }

}
