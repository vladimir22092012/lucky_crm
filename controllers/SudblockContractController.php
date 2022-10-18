<?php

error_reporting(-1);
ini_set('display_errors', 'On');

class SudblockContractController extends Controller
{
    public function fetch()
    {
        if (!($contract_id = $this->request->get('id', 'integer')))
            return false;

        if ($this->request->method('post')) {
            switch ($this->request->post('action', 'string')):

                case 'add_notification':
                    $this->add_notification_action();
                    break;

                case 'send_sud':
                    $this->send_sud_action($contract_id);
                    break;

                case 'sudprikaz':
                    $this->sudprikaz_action($contract_id);
                    break;

                case 'send_fssp':
                    $this->send_fssp_action($contract_id);
                    break;

                case 'ready_document':
                    $this->ready_document_action();
                    break;

                case 'calendar':
                    return $this->to_calendar_action($this->manager->id);
                    break;

                case 'update_task':
                    $this->action_update_task();
                    break;

                case 'done_task':
                    $this->action_done_task();
                    break;

            endswitch;

        }


        switch ($this->request->get('action', 'string')):

            case 'create':
                $block = $this->request->get('block', 'string');
                if ($block == 'sud')
                    $this->create_sud_documents_action($contract_id);
                if ($block == 'fssp')
                    $this->create_fssp_documents_action($contract_id);
                break;

            case 'remove':
                $this->remove_document_action();
                break;

        endswitch;


        $managers = array();
        foreach ($this->managers->get_managers() as $m)
            $managers[$m->id] = $m;

        if ($contract = $this->sudblock->get_contract($contract_id)) {
            $date1 = new DateTime(date('Y-m-d', strtotime($contract->created)));
            $date2 = new DateTime(date('Y-m-d'));

            $diff = $date2->diff($date1);
            $contract->delay = $diff->days;

            if (!empty($contract->user_id)) {
                $contract->user = $this->users->get_user($contract->user_id);
            }

            if (!empty($contract->contract_id)) {
                $contract->contract = $this->contracts->get_contract($contract->contract_id);

                $contract_operations = $this->operations->get_operations(array('contract_id' => $contract->contract_id));
                $this->design->assign('contract_operations', $contract_operations);

//                $documents = $this->documents->get_documents(array('contract_id' => $contract->contract_id));
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($documents);echo '</pre><hr />';
//                $this->design->assign('documents', $documents);

                $comments = $this->comments->get_comments(array('user_id' => $contract->user_id));
                $this->design->assign('comments', $comments);

                $user = $this->users->get_user((int)$contract->user_id);
                $changelogs = $this->changelogs->get_changelogs(array('order_id' => $contract->contract->order_id));
                foreach ($changelogs as $changelog) {
                    $changelog->user = $user;
                    if (!empty($changelog->manager_id) && !empty($managers[$changelog->manager_id]))
                        $changelog->manager = $managers[$changelog->manager_id];
                }
                $changelog_types = $this->changelogs->get_types();

                $this->design->assign('changelog_types', $changelog_types);
                $this->design->assign('changelogs', $changelogs);


            }

            if ($documents = $this->sudblock->get_documents(array('sudblock_contract_id' => $contract->id))) {
                $sud_documents = array();
                $fssp_documents = array();

                foreach ($documents as $doc) {
                    if ($doc->block == 'sud')
                        $sud_documents[] = $doc;
                    if ($doc->block == 'fssp')
                        $fssp_documents[] = $doc;
                }

                $this->design->assign('sud_documents', $sud_documents);
                $this->design->assign('fssp_documents', $fssp_documents);
            }

            $this->design->assign('contract', $contract);

            if (in_array('looker_link', $this->manager->permissions)) {
                $looker_link = $this->users->get_looker_link($contract->user->id);
                $this->design->assign('looker_link', $looker_link);
            }


        }

        $statuses = array();
        foreach ($this->sudblock->get_statuses() as $st)
            $statuses[$st->id] = $st;
        $this->design->assign('statuses', $statuses);

        $notification_events = $this->notifications->get_events();
        $this->design->assign('notification_events', $notification_events);

        $default_notification_date = date('Y-m-d', time() + 86400 * 30);
        $this->design->assign('default_notification_date', $default_notification_date);

        $not_closed_notifications = [];
        $i = 0;

        if ($notifications = $this->notifications->get_notifications(array('manager_id' => $this->manager->id))) {
            foreach ($notifications as $n) {
                if (!empty($n->event_id))
                    $n->event = $this->notifications->get_event($n->event_id);

                if ($n->done == 0 && $n->manager_id == $this->manager->id) {
                    $not_closed_notifications[$i] = $n->notification_date;
                    $i++;
                }
            }
        }

        $undone_notifications = $this->notifications->get_notifications(array('sudblock_contract_id' => $contract->id, 'done' => 0));

        $this->design->assign('notifications', $notifications);

        if (!empty($_SESSION['sudblock_error'])) {
            $this->design->assign('sudblock_error', $_SESSION['sudblock_error']);
            $_SESSION['sudblock_error'] = NULL;
        }

        $now_date = date('D');
        $this->design->assign('now_date', $now_date);

        $count_today[$now_date] = 0;

        foreach ($not_closed_notifications as $notification) {
            $now = date('Y-m-d', strtotime('now'));
            $notification_date = date('Y-m-d', strtotime($notification));

            if (strtotime($now) >= strtotime($notification_date)) {
                $count_today[$now_date] += 1;
                unset($notification);
            }


            if (strtotime($notification_date) <= strtotime('this sunday') && strtotime($notification_date) > strtotime($now))
            {
                if (isset($not_closed_notifications[date('D', strtotime($notification))])) {
                    $not_closed_notifications[date('D', strtotime($notification))] += 1;
                    unset($notification);
                }
                else
                {
                    $not_closed_notifications[date('D', strtotime($notification))] = 1;
                    unset($notification);
                }
            } else {
                unset($notifications);
            }
        }

        if ($count_today[$now_date] == 0)
            unset($count_today[$now_date]);

        $events = $this->EventTypes->get_events();
        $this->design->assign('events', $events);
        $this->design->assign('count_today', $count_today);
        $this->design->assign('not_closed_notifications', $not_closed_notifications);
        $this->design->assign('undone_notifications', $undone_notifications);

        return $this->design->fetch('sudblock_contract.tpl');
    }

    public function ready_document_action()
    {
        $ready = $this->request->post('ready', 'integer');
        $document_id = $this->request->post('document_id', 'integer');

        $this->sudblock->update_document($document_id, array('ready' => $ready));

        $this->json_output(array(
            'success' => 1,
            'ready' => $ready
        ));
        exit;

    }

    private function send_fssp_action($contract_id)
    {
        $fssp_post_number = (string)$this->request->post('post_number');

        $this->sudblock->update_contract($contract_id, array(
            'status' => 5,
            'fssp_post_number' => $fssp_post_number,
            'fssp_post_sent' => date('Y-m-d H:i:s'),
        ));
    }

    private function send_sud_action($contract_id)
    {
        $sud_post_number = (string)$this->request->post('post_number');

        $this->sudblock->update_contract($contract_id, array(
            'status' => 2,
            'sud_post_number' => $sud_post_number,
            'sud_post_sent' => date('Y-m-d H:i:s'),
        ));
    }

    private function sudprikaz_action($contract_id)
    {
        $sudprikaz_number = $this->request->post('sudprikaz_number');
        $sudprikaz_date = $this->request->post('sudprikaz_date');

        $this->sudblock->update_contract($contract_id, array(
            'status' => 3,
            'sudprikaz_number' => $sudprikaz_number,
            'sudprikaz_date' => $sudprikaz_date,
            'sudprikaz_added_date' => date('Y-m-d H:i:s'),
        ));

        $this->json_output(array('success' => 1));
    }

    private function create_sud_documents_action($sudblock_contract_id)
    {
        $document_dir = $this->config->root_dir . 'files/sudblock/' . $sudblock_contract_id . '/';

        if (!($sudblock_contract = $this->sudblock->get_contract($sudblock_contract_id)))
            return false;

        // создаем папку для документов если ее нет
        if (!file_exists($document_dir))
            mkdir($document_dir, 0775);

        $isset_documents = $this->sudblock->get_documents(array('sudblock_contract_id' => $sudblock_contract_id));

        // копируем документы по цессии
        $cession_info = $this->soap1c->get_cession_info($sudblock_contract->number, 1);

        if (!empty($cession_info->return)) {
            $cession_info_format = array();
            $cession_info_return = json_decode($cession_info->return);
            $have_cession_premier = 0;
            foreach ($cession_info_return as $cession_item) {
                $cession_item_format = new StdClass();

                $cession_item_format->number = $cession_item->Номер;
                $cession_item_format->date = $cession_item->Дата;
                $cession_item_format->buyer = $cession_item->Покупатель;
                $cession_item_format->loan_summ = $cession_item->СуммаЗайма;
                $cession_item_format->loan_percents = $cession_item->Проценты;
                $cession_item_format->loan_peni = $cession_item->Пени;
                $cession_item_format->total_summ = $cession_item->СуммаДолга;
                $cession_item_format->files = $cession_item->Файлы;

                $cession_info_format[] = $cession_item_format;

                if ($cession_item_format->buyer == 'ООО "ПРЕМЬЕР"')
                    $have_cession_premier = 1;
            }

            if (empty($have_cession_premier)) {
                $_SESSION['sudblock_error'] = 'Необходимо создать в 1С договора по цессии Премьер';
                header('Location: ' . $this->request->url(array('action' => NULL, 'block' => NULL)));
                exit;

            }

            usort($cession_info_format, function ($a, $b) {
                return strtotime($a->date) - strtotime($b->date);
            });

            $sudblock_contract->cession_info = ($cession_info_format);

            $i = 21;
            foreach ($sudblock_contract->cession_info as $cession_info) {
                if (!empty($cession_info->files)) {
                    foreach ($cession_info->files as $k => $file_item) {

                        $file_content = base64_decode($file_item);

                        $filename = md5(rand()) . '.pdf';
                        file_put_contents($document_dir . $filename, $file_content);

                        $this->sudblock->add_document(array(
                            'sudblock_contract_id' => $sudblock_contract->id,
                            'base' => 0,
                            'filename' => $filename,
                            'name' => 'Цессия ' . $cession_info->buyer . ' (' . ($k + 1) . ')',
                            'provider' => $sudblock_contract->provider,
                            'block' => 'sud',
                            'ready' => 0,
                            'parent' => 'CESSION',
                            'created' => date('Y-m-d H:i:s'),
                            'position' => $i++,
                        ));
                    }
                }
            }

            $cession_info_format = array_map(function ($var) {
                unset($var->files);
                return $var;
            }, $cession_info_format);
            $this->sudblock->update_contract($sudblock_contract->id, array('cession_info' => $cession_info_format));

        } else {
            $_SESSION['sudblock_error'] = 'Необходимо создать в 1С договора по цессии';
            header('Location: ' . $this->request->url(array('action' => NULL, 'block' => NULL)));
            exit;
        }

        $this->sudblock->calc_contract($sudblock_contract->id);

        $pp_document_created = 0;
        foreach ($isset_documents as $idoc)
            if ($idoc->parent == 'PP')
                $pp_document_created = 1;

        if (empty($pp_document_created)) {
            $pp = $this->soap1c->get_pp($sudblock_contract->number);
            if (!empty($pp->return)) {
                $decode_pp = json_decode($pp->return);
                if (!empty($decode_pp->ФайлКакBase64)) {
                    $file_content = base64_decode($decode_pp->ФайлКакBase64);

                    $filename = md5(rand()) . '.pdf';
                    file_put_contents($document_dir . $filename, $file_content);

                    $this->sudblock->add_document(array(
                        'sudblock_contract_id' => $sudblock_contract->id,
                        'base' => 0,
                        'filename' => $filename,
                        'name' => 'Платежное поручение',
                        'provider' => $sudblock_contract->provider,
                        'block' => 'sud',
                        'ready' => 0,
                        'parent' => 'PP',
                        'created' => date('Y-m-d H:i:s'),
                        'position' => 31,
                    ));
                }
            }
        }


        if ($contract = $this->contracts->get_contract($sudblock_contract->contract_id)) {
            // договор займа
            $contract_document_created = 0;
            foreach ($isset_documents as $idoc)
                if ($idoc->parent == 'IND_USLOVIYA_NL')
                    $contract_document_created = 1;

            if (empty($contract_document_created)) {
                if ($contract_document = $this->documents->get_contract_document($contract->id, 'IND_USLOVIYA_NL')) {
                    $contract_filename = md5(rand() . time()) . '.pdf';
                    $file = file_get_contents($this->config->front_url . '/document/' . $contract_document->user_id . '/' . $contract_document->id);
                    file_put_contents($document_dir . $contract_filename, $file);

                    $this->sudblock->add_document(array(
                        'sudblock_contract_id' => $sudblock_contract->id,
                        'base' => 0,
                        'filename' => $contract_filename,
                        'name' => $contract_document->name,
                        'provider' => $sudblock_contract->provider,
                        'block' => 'sud',
                        'ready' => 0,
                        'parent' => 'IND_USLOVIYA_NL',
                        'created' => date('Y-m-d H:i:s'),
                        'position' => 11,
                    ));

                }
            }
        }

        $i = 41;
        // создаем общие документы 
        if ($base_documents = $this->sudblock->get_documents(array('base' => 1, 'block' => 'sud'))) {
            foreach ($base_documents as $bdoc) {
                if ($bdoc->provider == $sudblock_contract->provider) {
                    $bdoc_document_created = 0;
                    foreach ($isset_documents as $idoc)
                        if ($idoc->parent == $bdoc->id)
                            $bdoc_document_created = 1;

                    if (empty($bdoc_document_created)) {
                        $file = file_get_contents($this->config->root_dir . 'files/sudblock/' . $bdoc->filename);
                        file_put_contents($document_dir . $bdoc->filename, $file);

                        $this->sudblock->add_document(array(
                            'sudblock_contract_id' => $sudblock_contract->id,
                            'base' => 0,
                            'filename' => $bdoc->filename,
                            'name' => $bdoc->name,
                            'provider' => $sudblock_contract->provider,
                            'block' => 'sud',
                            'ready' => 0,
                            'parent' => $bdoc->id,
                            'created' => date('Y-m-d H:i:s'),
                            'position' => $i++,
                        ));

                    }
                }
            }
        }

        // генерируем документы по шаблону
        $document_types = $this->documents->get_sudblock_create_documents('sud');

        $order = $this->orders->get_order($contract->order_id);
        $user = $this->users->get_user($contract->user_id);

        if (!empty($sudblock_contract->cession_info)) {
            $last_payment = NULL;
            foreach ($sudblock_contract->cession_info as $op) {
                if (empty($last_payment) || strtotime($last_payment) < strtotime($op->date))
                    $last_payment = date('Y-m-d', strtotime($op->date));
            }
        } else {
            $last_payment = $contract->inssuance_date;
        }

        $regaddress_full = empty($user->Regindex) ? '' : $user->Regindex . ', ';
        $regaddress_full .= trim($user->Regregion . ' ' . $user->Regregion_shorttype);
        $regaddress_full .= empty($user->Regcity) ? '' : trim(', ' . $user->Regcity . ' ' . $user->Regcity_shorttype);
        $regaddress_full .= empty($user->Regdistrict) ? '' : trim(', ' . $user->Regdistrict . ' ' . $user->Regdistrict_shorttype);
        $regaddress_full .= empty($user->Reglocality) ? '' : trim(', ' . $user->Reglocality . ' ' . $user->Reglocality_shorttype);
        $regaddress_full .= empty($user->Reghousing) ? '' : ', д.' . $user->Reghousing;
        $regaddress_full .= empty($user->Regbuilding) ? '' : ', стр.' . $user->Regbuilding;
        $regaddress_full .= empty($user->Regroom) ? '' : ', к.' . $user->Regroom;

        $passport_serial = str_replace(array('-', ' '), '', $user->passport_serial);
        $passport_series = substr($passport_serial, 0, 4);
        $passport_number = substr($passport_serial, 4, 6);

        $exactor_name = '';
        if ($exactor = $this->managers->get_manager($sudblock_contract->manager_id)) {
            $exactor_name = $exactor->name;
            $exactor_phone = $exactor->phone;
        }
        /*
        до 20 000 рублей - 4 процента цены иска, но не менее 400 рублей;
        от 20 001 рубля до 100 000 рублей - 800 рублей плюс 3 процента суммы, превышающей 20 000 рублей;
        от 100 001 рубля до 200 000 рублей - 3 200 рублей плюс 2 процента суммы, превышающей 100 000 рублей;
        от 200 001 рубля до 1 000 000 рублей - 5 200 рублей плюс 1 процент суммы, превышающей 200 000 рублей;
        свыше 1 000 000 рублей - 13 200 рублей плюс 0,5 процента суммы, превышающей 1 000 000 рублей, но не более 60 000 рублей;

        при подаче заявления о вынесении судебного приказа - 50 процентов размера государственной пошлины
        */
        if (($sudblock_contract->loan_summ * 2.5) < 20000)
            $poshlina = max(200, $sudblock_contract->loan_summ * 2.5 * 0.02);
        else
            $poshlina = 400 + ($sudblock_contract->loan_summ * 2.5 - 20000) * 0.015;

        $interval = date_diff(date_create($contract->inssuance_date), date_create(date('Y-m-d')));
        $loan_real_period = $interval->a;


        $params = array(
            'fio' => $user->lastname . ' ' . $user->firstname . ' ' . $user->patronymic,
            'birth' => $user->birth,
            'birth_place' => $user->birth_place,
            'document_date' => date('Y-m-d H:i:s'),
            'tribunal' => $sudblock_contract->tribunal,
            'first_number' => $sudblock_contract->first_number,
            'contract_date' => $contract->inssuance_date,
            'return_date' => $contract->return_date,
            'last_payment' => $last_payment,
            'regaddress_full' => $regaddress_full,
            'body_summ' => $sudblock_contract->loan_summ,
            'total_summ' => $sudblock_contract->total_summ,
            'passport_series' => $passport_series,
            'passport_number' => $passport_number,
            'passport_issued' => $user->passport_issued,
            'passport_date' => $user->passport_date,
            'passport_code' => $user->subdivision_code,
            'exactor_name' => $exactor_name,
            'exactor_phone' => $exactor_phone,
            'sudprikaz_number' => $sudblock_contract->sudprikaz_number,
            'sudprikaz_date' => $sudblock_contract->sudprikaz_date,
            'cession_info' => $sudblock_contract->cession_info,
            'loan_real_period' => $loan_real_period,
            'poshlina' => $poshlina,
        );

        $i = 1;
        foreach ($document_types as $dtype) {
            if ($found_doc = $this->documents->get_contract_document($sudblock_contract->contract_id, $dtype)) {
                $this->documents->update_document($found_doc->id, array(
                    'params' => $params
                ));
            } else {
                $id = $this->documents->create_document(array(
                    'user_id' => isset($user->id) ? $user->id : 0,
                    'order_id' => isset($contract->order_id) ? $contract->order_id : 0,
                    'contract_id' => isset($contract->id) ? $contract->id : 0,
                    'type' => $dtype,
                    'params' => $params,
                ));
                $found_doc = $this->documents->get_document($id);
            }
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($found_doc);echo '</pre><hr />';            
            $dtype_document_created = 0;
            foreach ($isset_documents as $idoc)
                if ($idoc->parent == $dtype)
                    $dtype_document_created = $idoc;

            if (empty($dtype_document_created)) {
                $dtype_filename = md5(rand() . time()) . '.pdf';

                $this->sudblock->add_document(array(
                    'sudblock_contract_id' => $sudblock_contract->id,
                    'base' => 0,
                    'filename' => $dtype_filename,
                    'name' => $found_doc->name,
                    'provider' => $sudblock_contract->provider,
                    'block' => 'sud',
                    'ready' => 0,
                    'parent' => $dtype,
                    'created' => date('Y-m-d H:i:s'),
                    'position' => $i++,
                ));
            } else {
                $dtype_filename = $dtype_document_created->filename;
            }

            $file = file_get_contents($this->config->front_url . '/document/' . $found_doc->user_id . '/' . $found_doc->id);
            file_put_contents($document_dir . $dtype_filename, $file);
        }

        $this->sudblock->update_contract($sudblock_contract->id, array('sud_docs_added' => 1, 'sud_docs_added_date' => date('Y-m-d H:i:s')));

        $this->sudblock->send_contract($sudblock_contract->id);

        header('Location: ' . $this->request->url(array('action' => NULL, 'block' => NULL)));
        exit;
    }

    private function create_fssp_documents_action($sudblock_contract_id)
    {
        $document_dir = $this->config->root_dir . 'files/sudblock/' . $sudblock_contract_id . '/';

        if (!($sudblock_contract = $this->sudblock->get_contract($sudblock_contract_id)))
            return false;

        // создаем папку для документов если ее нет
        if (!file_exists($document_dir))
            mkdir($document_dir, 0775);

        $isset_documents = $this->sudblock->get_documents(array('sudblock_contract_id' => $sudblock_contract_id));

        $contract = $this->contracts->get_contract($sudblock_contract->contract_id);


        // создаем общие документы 
        if ($base_documents = $this->sudblock->get_documents(array('base' => 1, 'block' => 'fssp'))) {
            foreach ($base_documents as $bdoc) {
                if ($bdoc->provider == $sudblock_contract->provider) {
                    $bdoc_document_created = 0;
                    foreach ($isset_documents as $idoc)
                        if ($idoc->parent == $bdoc->id)
                            $bdoc_document_created = 1;

                    $file = file_get_contents($this->config->root_dir . 'files/sudblock/' . $bdoc->filename);

                    file_put_contents($document_dir . $bdoc->filename, $file);

                    if (empty($bdoc_document_created)) {
                        $this->sudblock->add_document(array(
                            'sudblock_contract_id' => $sudblock_contract->id,
                            'base' => 0,
                            'filename' => $bdoc->filename,
                            'name' => $bdoc->name,
                            'provider' => $sudblock_contract->provider,
                            'block' => 'fssp',
                            'ready' => 0,
                            'parent' => $bdoc->id,
                            'created' => date('Y-m-d H:i:s'),
                        ));

                    }
                }
            }
        }

        // генерируем документы по шаблону
        $document_types = $this->documents->get_sudblock_create_documents('fssp');

        $order = $this->orders->get_order($contract->order_id);
        $user = $this->users->get_user($contract->user_id);

        if ($operations = $this->operations->get_operations(array('contract_id' => $contract->id, 'type' => 'PAY'))) {
            $last_payment = NULL;
            foreach ($operations as $op) {
                if (empty($last_payment) || strtotime($last_payment) < strtotime($op->created))
                    $last_payment = $op->created;
            }
        } else {
            $last_payment = $contract->inssuance_date;
        }

        $regaddress_full = empty($user->Regindex) ? '' : $user->Regindex . ', ';
        $regaddress_full .= trim($user->Regregion . ' ' . $user->Regregion_shorttype);
        $regaddress_full .= empty($user->Regcity) ? '' : trim(', ' . $user->Regcity . ' ' . $user->Regcity_shorttype);
        $regaddress_full .= empty($user->Regdistrict) ? '' : trim(', ' . $user->Regdistrict . ' ' . $user->Regdistrict_shorttype);
        $regaddress_full .= empty($user->Reglocality) ? '' : trim(', ' . $user->Reglocality . ' ' . $user->Reglocality_shorttype);
        $regaddress_full .= empty($user->Reghousing) ? '' : ', д.' . $user->Reghousing;
        $regaddress_full .= empty($user->Regbuilding) ? '' : ', стр.' . $user->Regbuilding;
        $regaddress_full .= empty($user->Regroom) ? '' : ', к.' . $user->Regroom;

        $passport_serial = str_replace(array('-', ' '), '', $user->passport_serial);
        $passport_series = substr($passport_serial, 0, 4);
        $passport_number = substr($passport_serial, 4, 6);

        $exactor_name = '';
        $exactor_phone = '';
        if ($exactor = $this->managers->get_manager($sudblock_contract->manager_id)) {
            $exactor_name = $exactor->name;
            $exactor_phone = $exactor->phone;
        }

        $params = array(
            'fio' => $user->lastname . ' ' . $user->firstname . ' ' . $user->patronymic,
            'birth' => $user->birth,
            'birth_place' => $user->birth_place,
            'document_date' => date('Y-m-d H:i:s'),
            'tribunal' => $sudblock_contract->tribunal,
            'first_number' => $sudblock_contract->first_number,
            'contract_date' => $contract->inssuance_date,
            'return_date' => $contract->return_date,
            'last_payment' => $last_payment,
            'regaddress_full' => $regaddress_full,
            'body_summ' => $sudblock_contract->loan_summ,
            'total_summ' => $sudblock_contract->total_summ,
            'passport_series' => $passport_series,
            'passport_number' => $passport_number,
            'passport_issued' => $user->passport_issued,
            'passport_date' => $user->passport_date,
            'passport_code' => $user->subdivision_code,
            'exactor_name' => $exactor_name,
            'exactor_phone' => $exactor_phone,
            'sudprikaz_number' => $sudblock_contract->sudprikaz_number,
            'sudprikaz_date' => $sudblock_contract->sudprikaz_date,
        );

        foreach ($document_types as $dtype) {
            if ($found_doc = $this->documents->get_contract_document($sudblock_contract->contract_id, $dtype)) {
                $this->documents->update_document($found_doc->id, array(
                    'params' => $params
                ));
            } else {
                $id = $this->documents->create_document(array(
                    'user_id' => isset($user->id) ? $user->id : 0,
                    'order_id' => isset($contract->order_id) ? $contract->order_id : 0,
                    'contract_id' => isset($contract->id) ? $contract->id : 0,
                    'type' => $dtype,
                    'params' => $params,
                ));
                $found_doc = $this->documents->get_document($id);
            }

            $dtype_document_created = 0;
            foreach ($isset_documents as $idoc)
                if ($idoc->parent == $dtype)
                    $dtype_document_created = $idoc;

            if (empty($dtype_document_created)) {
                $dtype_filename = md5(rand() . time()) . '.pdf';

                $this->sudblock->add_document(array(
                    'sudblock_contract_id' => $sudblock_contract->id,
                    'base' => 0,
                    'filename' => $dtype_filename,
                    'name' => $found_doc->name,
                    'provider' => $sudblock_contract->provider,
                    'block' => 'fssp',
                    'ready' => 0,
                    'parent' => $dtype,
                    'created' => date('Y-m-d H:i:s'),
                ));
            } else {
                $dtype_filename = $dtype_document_created->filename;
            }

            $file = file_get_contents($this->config->front_url . '/document/' . $found_doc->user_id . '/' . $found_doc->id);
            file_put_contents($document_dir . $dtype_filename, $file);
        }


        header('Location: ' . $this->request->url(array('action' => NULL, 'block' => NULL)));
        exit;
    }

    private function remove_document_action()
    {
        $document_id = $this->request->get('document');

        $this->sudblock->delete_document($document_id);

        header('Location:' . $this->request->url(array('action' => NULL, 'document' => NULL)));
        exit;

    }


    private function add_notification_action()
    {
        $event_id = $this->request->post('event_id', 'integer');

        $event = $this->EventTypes->get_event($event_id);

        $contract_id = $this->request->post('contract_id', 'integer');

        $comment = $this->request->post('comment');

        if($date = $this->request->post('notification_date'))
        {
            $notification = array(
                'sudblock_contract_id' => $contract_id,
                'manager_id' => $this->manager->id,
                'created' => date('Y-m-d H:i:s'),
                'notification_date' => date('Y-m-d H:i', strtotime($date)),
                'comment' => $this->request->post('comment'),
                'event_id' => $event_id
            );
        }

        else
        {
            $notification = array(
                'sudblock_contract_id' => $contract_id,
                'manager_id' => $this->manager->id,
                'created' => date('Y-m-d H:i:s'),
                'notification_date' => date('Y-m-d H:i', strtotime('+'.$event->count_days.' day')),
                'comment' => $this->request->post('comment'),
                'event_id' => $event_id
            );
        }


        if (empty($notification['event_id'])) {
            $this->json_output(array('error' => 'Выберите событие'));
        } else {
            $id = $this->notifications->add_notification($notification);

            $sudblock_contract = $this->sudblock->get_contract($contract_id);

            $contract = $this->contracts->get_contract($sudblock_contract->contract_id);

            $this->changelogs->add_changelog(array(
                'manager_id' => $this->manager->id,
                'created' => date('Y-m-d H:i:s'),
                'type' => 'sudblock_events',
                'old_values' => serialize(array(
                    'event_id' => 'none',
                    'manager_id' => $sudblock_contract->manager_id
                )),
                'new_values' => serialize(array(
                    'event_id' => $event_id,
                    'manager_id' => $this->manager->id,
                    'comment' => $comment,
                    'event_name' => $event->name
                )),
                'order_id' => $contract->order_id,
                'user_id' => $sudblock_contract->user_id,
            ));

            $this->json_output(array('success' => $id));
        }
    }

    private function to_calendar_action($manager_id)
    {

        $notifications = $this->notifications->get_notifications(array('manager_id' => $manager_id, 'done' => 0));
        $events = [];
        $i = 0;

        foreach ($notifications as $notification) {
            $events[$i] = $this->EventTypes->get_event($notification->event_id);
            $sudblock_contract = $this->sudblock->get_contract($notification->sudblock_contract_id);
            $user = $this->users->get_user($sudblock_contract->user_id);
            $fio = "$sudblock_contract->lastname $sudblock_contract->firstname $sudblock_contract->patronymic";
            $notification->fio = $fio;
            $notification->number_contract = $sudblock_contract->number;
            $notification->contract_id = $sudblock_contract->id;
            $notification->birthday = $user->birth;
            $i++;
        }

        $eventlist = [];
        $i = 0;

        foreach ($events as $event) {
            foreach ($notifications as $notification) {
                if ($notification->event_id == $event->id) {

                    $contracts_number = $notification->number_contract;
                    $contract_id = $notification->sudblock_contract_id;
                    $birthday = $notification->birthday;
                    $fio = $notification->fio;
                    $date = $notification->created;
                    $comment = $notification->comment;


                    if (date('Y-m-d') > date('Y-m-d', strtotime($notification->notification_date))) {

                        $extendProps = ['status' => 'undone', 'contract_id' => $contract_id,'contracts_number' => $contracts_number, 'event_name' => $event->name, 'date' => $date, 'comment' => $comment];
                        $eventlist[$i] = ['title' => "$fio $birthday", 'start' => date('Y-m-d'), 'extendedProps' => $extendProps];
                    }
                    if (date('Y-m-d') == date('Y-m-d', strtotime($notification->notification_date))) {
                        $extendProps = ['status' => 'to-do', 'contract_id' => $contract_id, 'contracts_number' => $contracts_number, 'event_name' => $event->name, 'date' => $date, 'comment' => $comment];
                        $eventlist[$i] = ['title' => "$fio $birthday", 'start' => date('Y-m-d'), 'extendedProps' => $extendProps];
                    }
                    if (date('Y-m-d') < date('Y-m-d', strtotime($notification->notification_date))) {
                        $extendProps = ['status' => 'to-do', 'contract_id' => $contract_id, 'contracts_number' => $contracts_number, 'event_name' => $event->name, 'date' => $date, 'comment' => $comment];
                        $eventlist[$i] = ['title' => "$fio $birthday", 'start' => date('Y-m-d', strtotime($notification->notification_date)), 'extendedProps' => $extendProps];
                    }
                }

                $i++;
            }
        }

        $this->design->assign('eventlist', $eventlist);
        return $this->design->fetch('calendar.tpl');
    }

    private function action_done_task()
    {
        $id = $this->request->post('id', 'integer');
        $comment = $this->request->post('comment', 'string');

        $notification = ['done' => 1, 'comment' => $comment];

        $notification_old = $this->notifications->get_notification($id);
        $event_old = $this->notifications->get_notification($notification_old->event_id);

        $this->notifications->update_notification($id, $notification);

        $notification_new = $this->notifications->get_notification($id);
        $event_new = $this->notifications->get_notification($notification_old->event_id);

        $sudblock_contract = $this->sudblock->get_contract($notification_old->sudblock_contract_id);
        $contract = $this->contracts->get_contract($sudblock_contract->contract_id);

        $this->changelogs->add_changelog(array(
            'manager_id' => $this->manager->id,
            'created' => date('Y-m-d H:i:s'),
            'type' => 'sudblock_events',
            'old_values' => serialize(array(
                'event_id' => $notification_old->event_id,
                'manager_id' => $sudblock_contract->manager_id,
                'comment' => $notification_old->comment,
                'event_name' => $event_old->name
            )),
            'new_values' => serialize(array(
                'event_id' => $notification_new->event_id,
                'manager_id' => $this->manager->id,
                'comment' => $comment,
                'event_name' => $event_new->name
            )),
            'order_id' => $contract->order_id,
            'user_id' => $sudblock_contract->user_id,
        ));
    }

    private function action_update_task()
    {
        $id = $this->request->post('id', 'integer');
        $event_id = $this->request->post('event_id');
        $notification_date = $this->request->post('notification_date');
        $comment = $this->request->post('comment');
        $event_new = $this->EventTypes->get_event($event_id);

        $notification_old = $this->notifications->get_notification($id);
        $event_old = $this->notifications->get_notification($notification_old->event_id);
        $sudblock_contract = $this->sudblock->get_contract($notification_old->sudblock_contract_id);
        $contract = $this->contracts->get_contract($sudblock_contract->contract_id);

        $notification = ['event_id' => $event_id, 'notification_date' => date('Y-m-d', strtotime($notification_date)), 'comment' => $comment];
        $result = $this->notifications->update_notification($id, $notification);

        $this->changelogs->add_changelog(array(
            'manager_id' => $this->manager->id,
            'created' => date('Y-m-d H:i:s'),
            'type' => 'sudblock_events',
            'old_values' => serialize(array(
                'event_id' => $notification_old->event_id,
                'manager_id' => $sudblock_contract->manager_id,
                'comment' => $notification_old->comment,
                'event_name' => $event_old->name
            )),
            'new_values' => serialize(array(
                'event_id' => $event_id,
                'manager_id' => $this->manager->id,
                'comment' => $comment,
                'event_name' => $event_new->name
            )),
            'order_id' => $contract->order_id,
            'user_id' => $sudblock_contract->user_id,
        ));

        var_dump($result);
        exit;
    }
}