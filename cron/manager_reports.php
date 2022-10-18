<?php
error_reporting(-1);
ini_set('display_errors', 'On');


chdir(dirname(__FILE__).'/../');

require 'autoload.php';

/**
тактическая отчётность: 
    присылать за день (в 07:00 мск) + 
    недельный (каждый пн за пред неделю в 7:00 мск) 
    просьба сделать в виде: 

дата (период дат)
количество заявок НК (“НК” + “Повтор”)
кол-во выдач НК 
сумма договоров НК 
количество заявок
кол-во выдач ПК 
сумма договоров ПК, 
количество закрытых договоров по всем клиентам за указанный период (день/неделя), 
сумма закрытых договоров 
количество пролонгаций 
сумма пролонгаций
допы: сумма страховок при выдаче (кол-во/сумма) / сумма страховок при пролонгации (кол-во/сумма)

Отдельным письмом (по вышеописанным условиям ежемесячно) присылать такой отчет: 
причина отказа (кол-во/сумма)

вывести в раздел Настройки поле для ввода почт для вышеперечисленных отчетов + 
вывести в раздел http://joxi.ru/BA0OE67CvlXVl2 кнопку “Получить отчет” с выбором периода, 
чтобы отправлялось по требованию на те же почты 

Сделать отчет для роли менеджеров. 
В разделе Аналитика добавить пункт “Ежедневная отчетность”, внутри:
Дата (можно выбрать период или конкретную дату)
Кол-во выданных займов (Общее/НК/ПК), без сумм
И отдельно по ФИО (скрин как надо сделать таблицу в срм ниже):

*/
class ManagerReportsCron extends Core
{
    public function __construct()
    {
    	parent::__construct();
    
        $this->run();
    }
    
    public function run()
    {
        if (($this->settings->report_email))
        {
            // делаем ежедненый отчет за прошлый день
            $date = date('Y-m-d', time() - 86400);
        	$this->director_report($date, $date);
    
            // если понедельник - то делаем недельный отчет
            
        }
        
/*
        $managers = $this->managers->get_managers();
        foreach ($managers as $manager)
        {
            if (!empty($manager->email))
                $this->manager_report($manager);
        }
*/
    }
    
    /**
     * ManagerReportsCron::director_daily_report()
     * Создает и отправляет на почту ежедненый отчет для директора
     * 
     * @return void
     */
    private function director_report($date_from, $date_to)
    {

        // заявки
        $reject_reasons = array();
        $count_rejects = 0;

        $count_orders_nk = 0;
        $count_orders_pkcrm = 0;
        $count_orders_repeat = 0;
        $contract_ids = array();
        $orders = array();

        $items = $this->orders->get_orders(array('limit'=>10000, 'date_from' => $date_from, 'date_to' => $date_to, 'type' => 'base'));
        foreach ($items as $o) {
            $orders[$o->order_id] = $o;
            $contract_ids[] = $o->contract_id;

            if ($o->client_status == 'crm')
                $count_orders_pkcrm++;
            elseif ($o->client_status == 'pk')
                $count_orders_repeat++;
            elseif ($o->client_status == 'nk' || $o->client_status == 'rep')
                $count_orders_nk++;
            /*
                        $user_close_orders = $this->orders->get_orders(array(
                            'user_id' => $o->user_id,
                            'type' => 'base',
                            'status' => array(7)
                        ));
                        $o->have_crm_closed = !empty($user_close_orders);

                        if (!empty($o->have_crm_closed))
                            $count_orders_pkcrm++;
                        elseif ($o->loan_history == '[]' || empty($o->loan_history))
                            $count_orders_nk++;
                        else
                            $count_orders_repeat++;
            */
            if ($o->status == 3 || $o->status == 8) {
                $count_rejects++;
                if (!isset($reject_reasons[$o->reject_reason]))
                    $reject_reasons[$o->reject_reason] = 0;
                $reject_reasons[$o->reject_reason] += 1;
            }

        }
        $contract_ids = array_filter($contract_ids);
        if (!empty($contract_ids)) {
            foreach ($this->contracts->get_contracts(array('limit'=>1000, 'id' => $contract_ids)) as $contract)
                if (!empty($orders[$contract->order_id]))
                    $orders[$contract->order_id]->contract = $contract;
        }


        // выдачи
        $pk_contracts = array();
        $pkcrm_total = array();
        $nk_contracts = array();
        $pk_total = 0;
        $pkcrm_total = 0;
        $nk_total = 0;

        $contracts = $this->contracts->get_contracts(array('limit'=>1000, 'inssuance_date_from' => $date_from, 'inssuance_date_to' => $date_to, 'type' => 'base'));
        foreach ($contracts as $c) {
            $contract_order = $this->orders->get_order((int)$c->order_id);
            if ($contract_order->client_status == 'crm') {
                $pkcrm_contracts[$c->id] = $c;
                $pkcrm_total += $c->amount;
            } elseif ($contract_order->client_status == 'pk') {
                $pk_contracts[$c->id] = $c;
                $pk_total += $c->amount;
            } elseif ($contract_order->client_status == 'nk' || $contract_order->client_status == 'rep') {
                $nk_contracts[$c->id] = $c;
                $nk_total += $c->amount;
            }
            /*
                        $user_close_orders = $this->orders->get_orders(array(
                            'user_id' => $c->user_id,
                            'type' => 'base',
                            'status' => array(7)
                        ));
                        $c->have_crm_closed = !empty($user_close_orders);


                        $c->user = $this->users->get_user($c->user_id);
                        if ($c->have_crm_closed)
                        {
                            $pkcrm_contracts[$c->id] = $c;
                            $pkcrm_total += $c->amount;
                        }
                        elseif ($c->user->loan_history == '[]' || empty($c->user->loan_history))
                        {
                            $nk_contracts[$c->id] = $c;
                            $nk_total += $c->amount;
                        }
                        else
                        {
                            $pk_contracts[$c->id] = $c;
                            $pk_total += $c->amount;
                        }
            */
        }


        // страховки
        $insurance_new_count = 0;
        $insurance_prolongation_count = 0;
        $insurance_new_summ = 0;
        $insurance_prolongation_summ = 0;
        if ($insurance_operations = $this->operations->get_operations(array('limit'=>10000, 'type' => 'INSURANCE', 'date_from' => $date_from, 'date_to' => $date_to))) {
            foreach ($insurance_operations as $io) {
                if ($io->transaction = $this->transactions->get_transaction($io->transaction_id)) {
                    if (empty($io->transaction->prolongation)) {
                        $insurance_new_count++;
                        $insurance_new_summ += (int)$io->amount;
                    } else {
                        $insurance_prolongation_count++;
                        $insurance_prolongation_summ += (int)$io->amount;
                    }
                }
            }
        }

        // пролонгации
        // юк - 7036, премьер - 7814, мкк - 8305, 7182
        $type_operation = 'PAY';

        $all_prolongations = $this->operations->get_sum_count_prolongation(array(
            'date_from' => $date_from,
            'date_to' => $date_to,
            'type_operation' => $type_operation));

        $prolongation_by_organization = array();

        $mkk_sum_prolongations = 0;
        $mkk_count_prolongations = 0;
        $yuk_sum_prolongations = 0;
        $yuk_count_prolongations = 0;

        foreach ($all_prolongations as $prolongation) {
            if ($prolongation->sector == 7036) {
                $yuk_sum_prolongations += (int)$prolongation->amount;
                $yuk_count_prolongations += 1;
            }
            if ($prolongation->sector == 8305 || $prolongation->sector == 7182) {
                $mkk_sum_prolongations += (int)$prolongation->amount;
                $mkk_count_prolongations += 1;
            }
        }

        $count_prolongations = $yuk_count_prolongations + $mkk_count_prolongations;
        $sum_prolongations = $yuk_sum_prolongations + $mkk_sum_prolongations;

        // закрытые договора
        // сумма и кол-во закрытых договоров по организациям

        // юк - 7036, премьер - 7814, мкк - 8305, 7182
        $type_operation = 'PAY';
        $type_contract = 'base';

        $all_closed_contracts = $this->contracts->contracts_closed_report_by_organization(array(
            'date_from' => $date_from,
            'date_to' => $date_to,
            'type_operation' => $type_operation,
            'type_contract' => $type_contract));

        $closed_contracts_by_organization = array();
        $mkk_sum_closed_contracts = 0;
        $yuk_sum_closed_contracts = 0;

        foreach ($all_closed_contracts as $contract) {
            if ($contract->sector == 7036) {
                $yuk_sum_closed_contracts += (int)$contract->amount;
                if (!empty($closed_contracts_by_organization['yuk'][$contract->id])) {
                    if (array_key_exists($contract->id, $closed_contracts_by_organization['yuk'])) {
                        $closed_contracts_by_organization['yuk'][$contract->id]['amount'] += (int)$contract->amount;
                    }
                } else {
                    $closed_contracts_by_organization['yuk'][$contract->id] = ['amount' => (int)$contract->amount];
                }
            }
            if ($contract->sector == 8305 || $contract->sector == 7182) {
                $mkk_sum_closed_contracts += (int)$contract->amount;
                if (!empty($closed_contracts_by_organization['mkk'][$contract->id])) {
                    if (array_key_exists($contract->id, $closed_contracts_by_organization['mkk'])) {
                        $closed_contracts_by_organization['mkk'][$contract->id]['amount'] += (int)$contract->amount;
                    }
                } else {
                    $closed_contracts_by_organization['mkk'][$contract->id] = ['amount' => (int)$contract->amount];
                }
            }
        }
        $sum_closed_contracts = $yuk_sum_closed_contracts + $mkk_sum_closed_contracts;
        $count_closed_contracts = count($closed_contracts_by_organization['mkk']) + count($closed_contracts_by_organization['yuk']);

        // Проданые договора
        $sold_count = 0;
        if ($sold_contracts = $this->contracts->get_contracts(array('limit'=>1000, 'sold_date_from' => $date_from, 'sold_date_to' => $date_to, 'type' => 'base'))) {
            foreach ($sold_contracts as $sold_contract) {
                $sold_count += 1;
            }
        }

        // Итого поступлений по организациям
        // юк - 7036, премьер - 7814, мкк - 8305, 7182

        $all_final_sum = $this->operations->get_final_sum_by_organizations(array(
            'date_from' => $date_from,
            'date_to' => $date_to,));

        $final_sum_mkk = 0;
        $final_sum_yuk = 0;
        $final_sum = 0;

        foreach ($all_final_sum as $sum) {
            if ($sum->sector == 7036) {
                $final_sum_yuk += (int)$sum->amount;
            }
            if ($sum->sector == 8305 || $sum->sector == 7182) {
                $final_sum_mkk += (int)$sum->amount;
            }
        }

        $final_sum = $final_sum_yuk + $final_sum_mkk;

        if ($date_from == $date_to)
            $subject = 'Ежедневный отчет за ' . date('d.m.Y', strtotime($date_from));
        else
            $subject = 'Недельный отчет за ' . date('d.m.Y', strtotime($date_from)) . ' - ' . date('d.m.Y', strtotime($date_to));

        $msg = '<html>';
        $msg .= '<head>';
        $msg .= '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
        $msg .= '</head>';
        $msg .= '<body style="font-family:Verdana, Geneva, sans-serif;font-size:13px;">';
        $msg .= '<h6 style="font-size:16px;font-weight:normal">' . $this->config->front_url . '</h6>';
        $msg .= '<h1 style="font-size:22px;font-weight:bold">' . $subject . '</h1>';
        $msg .= '<table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Позиции</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">МКК</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">ЮК</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">ИТОГО</td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество заявок НК</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $count_orders_nk . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество выдач НК </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . count($nk_contracts) . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Cумма договоров НК </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format($nk_total, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество заявок ПК</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $count_orders_repeat . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество выдач ПК </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . count($pk_contracts) . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Cумма договоров ПК </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format($pk_total, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество заявок ПК CRM </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $count_orders_pkcrm . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество выдач ПК CRM </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . count($pkcrm_contracts) . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Cумма договоров ПК CRM </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format($pkcrm_total, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Общее количество выдач</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format(count($nk_contracts) + count($pk_contracts) + count($pkcrm_contracts), 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Сумма выдач</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format($nk_total + $pk_total + $pkcrm_total, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Отказы</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $count_rejects . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';

        foreach ($reject_reasons as $reject_reason => $reject_reason_count) {
            $msg .= '<tr>';
            $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Причина: ' . $reject_reason . '</td>';
            $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $reject_reason_count . '</td>';
            $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
            $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
            $msg .= '</tr>';
        }

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество закрытых договоров</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . count($closed_contracts_by_organization['mkk']) . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . count($closed_contracts_by_organization['yuk']) . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $count_closed_contracts . '</td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Сумма закрытых договоров</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format((int)$mkk_sum_closed_contracts, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format((int)$yuk_sum_closed_contracts, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format((int)$sum_closed_contracts, 0, '', ' ') . '</td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество пролонгаций </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $mkk_count_prolongations . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $yuk_count_prolongations . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $count_prolongations . '</td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Сумма пролонгаций</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format((int)$mkk_sum_prolongations, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format((int)$yuk_sum_prolongations, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format((int)$sum_prolongations, 0, '', ' ') . '</td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Страховки при выдаче (кол-во/сумма)</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $insurance_new_count . ' / ' . number_format((int)$insurance_new_summ, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $insurance_new_count . ' / ' . number_format((int)$insurance_new_summ, 0, '', ' ') . '</td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Страховки при пролонгации (кол-во/сумма)</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $insurance_prolongation_count . ' / ' . number_format($insurance_prolongation_summ, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $insurance_prolongation_count . ' / ' . number_format($insurance_prolongation_summ, 0, '', ' ') . '</td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Договора переданные на ЮК</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . $sold_count . '</td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Итого поступлений</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format((int)$final_sum_mkk, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format((int)$final_sum_yuk, 0, '', ' ') . '</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">' . number_format((int)$final_sum, 0, '', ' ') . '</td>';
        $msg .= '</tr>';

        $msg .= '</table>';
        $msg .= '</body>';
        $msg .= '</html>';

        //$email = 'kolgotin_vi@akticom.ru';
        //$this->notify->email($email, $subject, $msg);

        $emails = array_map('trim', explode(',', $this->settings->report_email));
        foreach ($emails as $email) {
            $this->notify->email($email, $subject, $msg);
        }
        echo $msg;
    }


    private function manager_report($manager)
    {
        $date = date('Y-m-d', time() - 86400);
        
        $subject = 'Ежедневный отчет за '.date('d.m.Y', strtotime($date));
        
        $msg = '<body style="font-family:verdana, sans-serif;font-size:13px;">';        
        $msg .= '<h1 style="font-size:22px;font-weight:bold">'.$subject.'</h1>';
        
        $msg .= '<p>Кол-во выданных займов(НК + ПК):</p>';
        
        $msg .= '<table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Дата</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">'.date('d.m.Y', strtotime($date)).'</td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество заявок НК</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">'.$count_orders_nk.'</td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество выдач НК </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Cумма договоров НК </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество заявок ПК</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;">'.$count_orders_nk.'</td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество выдач ПК </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Cумма договоров ПК </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';

        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество закрытых договоров</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Сумма закрытых договоров</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
 
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Количество пролонгаций </td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Сумма пролонгаций</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
         
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Страховки при выдаче (кол-во/сумма)</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
        $msg .= '<tr>';
        $msg .= '<td style="padding:6px; width:330; background-color:#f0f0f0; border:1px solid #e0e0e0;">Страховки при пролонгации (кол-во/сумма)</td>';
        $msg .= '<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;text-align:right;"></td>';
        $msg .= '</tr>';
 
        $msg .= '</table>';
        $msg .= '</body';
        
        echo $msg;
        
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($msg);echo '</pre><hr />';
    }
    
    
    private function get_contracts($filter = array())
    {
        $date_from_filter = '';
        $date_to_filter = '';
        $manager_id_filter = '';
        
        if (!empty($filter['date_from']))
            $date_from_filter = $this->db->placehold("AND DATE(c.inssuance_date) >= ?", $filter['date_from']);
        
        if (!empty($filter['date_to']))
            $date_to_filter = $this->db->placehold("AND DATE(c.inssuance_date) >= ?", $filter['date_to']);
        
        if (!empty($filter['manager_id']))
            $manager_id_filter = $this->db->placehold("AND o.manager_id = ?", (int)$filter['manager_id']);
        
        $query = $this->db->placehold("
            SELECT *
            FROM __contracts AS c
            LEFT JOIN __orders AS o
            ON c.order_id = o.id
            LEFT JOIN __users AS u
            ON u.id = c.user_id
            WHERE 1
                $date_from_filter
                $date_to_filter
                $manager_id_filter
        ");
        $this->db->query($query);
        
        $results = $this->db->results();
        
        return $results;
    }
}
new ManagerReportsCron();