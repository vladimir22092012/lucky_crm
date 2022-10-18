<?php

class SourcesController extends Controller
{
    public function fetch()
    {
        if ($action = $this->request->get('action', 'string')) {
            if ($action == 'report') {
                $date_from = '';
                $date_to = '';

                switch ($this->request->get('options')):

                    case 'today':
                        $date_from = date('Y-m-d');
                        $date_to = date('Y-m-d');
                        break;

                    case 'yesterday':
                        $date_from = date('Y-m-d', strtotime('-1 day'));
                        $date_to = date('Y-m-d', strtotime('-1 day'));
                        break;

                    case 'seven_days':
                        $now_date = new DateTime(date('Y-m-d'));
                        $previous_monday = $now_date->sub(new DateInterval('P7D'));
                        $date_from = $previous_monday->format('Y-m-d');
                        $date_to = date('Y-m-d');
                        break;

                    case 'this_week':
                        $date_from = date('Y-m-d', strtotime('last monday'));
                        $date_to = date('Y-m-d', strtotime('this sunday'));
                        break;

                    case 'last_week':
                        $this_monday = new DateTime(date('Y-m-d', strtotime('last monday')));
                        $previous_monday = $this_monday->sub(new DateInterval('P7D'));
                        $date_from = $previous_monday->format('Y-m-d');

                        $last_monday = new DateTime(date('Y-m-d', strtotime('last monday')));
                        $previous_sunday = $this_monday->sub(new DateInterval('P1D'));
                        $date_to = $previous_monday->format('Y-m-d');
                        break;

                    case 'this_months':
                        $now = new DateTime(date('Y-m-d'));
                        $now_d = $now->format('j');
                        $first_day_this_month = $now->sub(new DateInterval('P' . $now_d . 'D'));
                        $date_from = $first_day_this_month->add(new DateInterval('P1D'));
                        $date_to = date('Y-m-t');
                        break;

                    case 'last_months':
                        $now = new DateTime(date('Y-m-d'));
                        $now_d = $now->format('j');
                        $last_day_last_month = $now->sub(new DateInterval('P' . $now_d . 'D'));
                        $last_d = $last_day_last_month->format('j');
                        $date_to = $last_day_last_month->format('Y-m-d');

                        $first_day_last_month = $last_day_last_month->sub(new DateInterval('P' . $last_d . 'D'));
                        $first_day_last_month = $last_day_last_month->add(new DateInterval('P1D'));
                        $date_from = $first_day_last_month->format('Y-m-d');
                        break;

                    case 'casual':
                        $daterange = $this->request->get('daterange');

                        list($from, $to) = explode('-', $daterange);

                        $date_from = date('Y-m-d', strtotime($from));
                        $date_to = date('Y-m-d', strtotime($to));

                        break;

                endswitch;

                $this->design->assign('date_from', $date_from);
                $this->design->assign('date_to', $date_to);
                $this->design->assign('from', $from);
                $this->design->assign('to', $to);

                $results = array();

                $filter = array();
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;

                if ($this->request->get('yandex') == 1) {
                    $filter['yandex'] = 1;
                }

                if ($this->request->get('leadcraft') == 1) {
                    $filter['leadcraft'] = 1;
                }

                $visits = $this->Visits->search_visits($filter);


                $all_params = ['visits', 'all_orders', 'orders_nk', 'orders_pk',
                    'orders_bk', 'CR', 'accept_all', 'accept_nk', 'accept_pk', 'accept_bk',
                    'ar_all', 'ar_nk', 'ar_pk', 'ar_bk', 'reject_all', 'reject_all_prc',
                    'reject_nk', 'reject_nk_prc', 'reject_pk', 'reject_pk_prc', 'reject_bk', 'reject_bk_prc', 'check_all_summ',
                    'check_nk_summ', 'check_pk_summ', 'check_srch', 'check_srch_nk', 'check_srch_pk'];

                foreach ($visits as $visit) {
                    $date = date('Y-m-d', strtotime($visit->created));

                    ($visit->utm_source == 'leadcraft') ? $key = 'leadcraft' : $key = 'yandex';


                    if (isset($results[$date][$key])) {
                        $results[$date][$key]['visits'] += 1;
                    } else {

                        foreach ($all_params as $param) {
                            if ($this->request->get("$param") == 1) {
                                $results[$date][$key][$param] = 0;
                            }
                        }
                    }
                }

                $orders = $this->orders->get_orders_by_utm($filter);

                foreach ($orders as $order) {
                    $date = date('Y-m-d', strtotime($order->date));

                    if ($order->utm_source == 'leadcraft') {
                        $results[$date]['leadcraft']['all_orders'] += 1;
                        $results[$date]['leadcraft']['check_all_summ'] += $order->amount;

                        if ($order->status == 5) {
                            $results[$date]['leadcraft']['accept_all'] += 1;
                        }
                        if ($order->status == 3) {
                            $results[$date]['leadcraft']['reject_all'] += 1;
                        }

                        if ($order->client_status == 'nk') {
                            $results[$date]['leadcraft']['orders_nk'] += 1;
                            $results[$date]['leadcraft']['check_nk_summ'] += $order->amount;

                            if ($order->status == 5) {
                                $results[$date]['leadcraft']['accept_nk'] += 1;
                            }
                            if ($order->status == 3) {
                                $results[$date]['leadcraft']['reject_nk'] += 1;
                            }
                        }
                        if ($order->client_status == 'crm') {
                            $results[$date]['leadcraft']['orders_pk'] += 1;
                            $results[$date]['leadcraft']['check_pk_summ'] += $order->amount;

                            if ($order->status == 5) {
                                $results[$date]['leadcraft']['accept_pk'] += 1;
                            }
                            if ($order->status == 3) {
                                $results[$date]['leadcraft']['reject_pk'] += 1;
                            }
                        }
                        if ($order->leadcraft_postback_type == 'pending') {
                            $results[$date]['leadcraft']['orders_bk'] += 1;
                        }
                        if ($order->leadcraft_postback_type == 'approved') {
                            $results[$date]['leadcraft']['accept_bk'] += 1;
                        }
                        if ($order->leadcraft_postback_type == 'cancelled') {
                            $results[$date]['leadcraft']['reject_bk'] += 1;
                        }
                    }

                    if ($order->utm_source == 'yandex') {
                        $results[$date]['yandex']['all_orders'] += 1;
                        $results[$date]['yandex']['check_all_summ'] += $order->amount;

                        if ($order->status == 5) {
                            $results[$date]['yandex']['accept_all'] += 1;
                        }
                        if ($order->status == 3) {
                            $results[$date]['yandex']['reject_all'] += 1;
                        }

                        if ($order->client_status == 'nk') {
                            $results[$date]['yandex']['orders_nk'] += 1;
                            $results[$date]['yandex']['check_nk_summ'] += $order->amount;

                            if ($order->status == 5) {
                                $results[$date]['yandex']['accept_nk'] += 1;
                            }
                            if ($order->status == 3) {
                                $results[$date]['yandex']['reject_nk'] += 1;
                            }
                        }
                        if ($order->client_status == 'crm') {
                            $results[$date]['yandex']['orders_pk'] += 1;
                            $results[$date]['yandex']['check_pk_summ'] += $order->amount;

                            if ($order->status == 5) {
                                $results[$date]['yandex']['accept_pk'] += 1;
                            }
                            if ($order->status == 3) {
                                $results[$date]['yandex']['reject_pk'] += 1;
                            }
                        }
                        if ($order->leadcraft_postback_type == 'pending') {
                            $results[$date]['yandex']['orders_bk'] += 1;
                        }
                        if ($order->leadcraft_postback_type == 'approved') {
                            $results[$date]['yandex']['accept_bk'] += 1;
                        }
                        if ($order->leadcraft_postback_type == 'cancelled') {
                            $results[$date]['yandex']['reject_bk'] += 1;
                        }
                    }

                }

                foreach ($results as $date => $source) {
                    foreach ($source as $key => $value) {
                        $results[$date][$key]['CR'] = $results[$date][$key]['visits'] / $results[$date][$key]['all_orders'] * 100;
                        $results[$date][$key]['CR'] = $results[$date][$key]['visits'] / $results[$date][$key]['all_orders'] * 100;
                        $results[$date][$key]['ar_all'] = $results[$date][$key]['accept_all'] / $results[$date][$key]['all_orders'] * 100;
                        $results[$date][$key]['ar_nk'] = $results[$date][$key]['accept_nk'] / $results[$date][$key]['orders_nk'] * 100;
                        $results[$date][$key]['ar_pk'] = $results[$date][$key]['accept_pk'] / $results[$date][$key]['orders_pk'] * 100;
                        $results[$date][$key]['ar_bk'] = $results[$date][$key]['accept_bk'] / $results[$date][$key]['orders_bk'] * 100;
                        $results[$date][$key]['reject_all_prc'] = $results[$key][$key]['all_orders'] / $results[$date][$key]['reject_all'] * 100;
                        $results[$date][$key]['reject_nk_prc'] = $results[$key][$key]['orders_nk'] / $results[$date][$key]['reject_nk'] * 100;
                        $results[$date][$key]['reject_pk_prc'] = $results[$key][$key]['orders_pk'] / $results[$date][$key]['reject_pk'] * 100;
                        $results[$date][$key]['reject_bk_prc'] = $results[$key][$key]['orders_bk'] / $results[$date][$key]['reject_bk'] * 100;
                        $results[$date][$key]['check_srch'] = $results[$date][$key]['check_all_summ'] / $results[$date][$key]['all_orders'];
                        $results[$date][$key]['check_srch_nk'] = $results[$date][$key]['check_nk_summ'] / $results[$date][$key]['orders_nk'];
                        $results[$date][$key]['check_srch_pk'] = $results[$date][$key]['check_pk_summ'] / $results[$date][$key]['orders_pk'];
                    }
                }

                $all_thead = [
                    'visits' => 'Визиты',
                    'all_orders' => 'Всего заявок',
                    'orders_nk' => 'Заявки НК',
                    'orders_pk'=> 'Заявки ПК',
                    'orders_bk'=> 'Заявки ПБ',
                    'CR' => 'CR %',
                    'accept_all' => 'Всего выдано',
                    'accept_nk' => 'Выдано НК',
                    'accept_pk' => 'Выдано ПК',
                    'accept_bk' => 'Выдано ПБ',
                    'ar_all' => 'AR %',
                    'ar_nk' => 'AR НК%',
                    'ar_pk' => 'AR ПК%',
                    'ar_bk' => 'AR ПБ%',
                    'reject_all' => 'Всего отказов',
                    'reject_all_prc' => 'Всего отказов%',
                    'reject_nk' => 'Отказы НК',
                    'reject_nk_prc' => 'Отказы НК%',
                    'reject_pk' => 'Отказы ПК',
                    'reject_pk_prc' => 'Отказы ПК%',
                    'reject_bk' => 'Отказы ПБ',
                    'reject_bk_prc' => 'Отказы ПБ%',
                    'check_all_summ' => 'Сумма займов',
                    'check_nk_summ' => 'Cумма НК',
                    'check_pk_summ' => 'Сумма ПК',
                    'check_srch' => 'СРЧ',
                    'check_srch_nk' => 'СРЧ НК',
                    'check_srch_pk' => 'СРЧ ПК'];
                $thead = [];

                foreach ($all_params as $param) {
                    if ($this->request->get($param) != 1) {
                        foreach ($results as $date => $source) {
                            foreach ($source as $key => $value) {
                                unset($results[$date][$key][$param]);
                            }
                        }
                    }
                    foreach ($results as $date => $source) {
                        foreach ($source as $key => $value) {
                            foreach ($value as $k => $val) {
                                foreach ($all_thead as $hk => $head){
                                    if ($this->request->get($param) == 1 && $param == $k && $k == $hk) {
                                        $thead[] = $head;
                                    }
                                }
                            }
                        }
                    }
                }

                $this->design->assign('results', $results);
                $this->design->assign('thead', $thead);
            }
        }

        return $this->design->fetch('sources.tpl');
    }
}