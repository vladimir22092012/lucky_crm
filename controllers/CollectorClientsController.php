<?php

class CollectorClientsController extends Controller
{
    public function fetch()
    {
        if (!in_array('collection_moving', $this->manager->permissions))
            return false;

        if ($daterange = $this->request->get('daterange')) {
            list($from, $to) = explode('-', $daterange);

            $date_from = date('Y-m-d', strtotime($from));
            $date_to = date('Y-m-d', strtotime($to));

            $this->design->assign('date_from', $date_from);
            $this->design->assign('date_to', $date_to);
            $this->design->assign('from', $from);
            $this->design->assign('to', $to);
            
            $query_manager = '';            
            if ($manager_id = $this->request->get('manager_id', 'integer'))
            {
                $query_manager = $this->db->placehold("AND cm.manager_id = ?", $manager_id);
                $this->design->assign('manager_id', $manager_id);            
            }

            $query_status = '';
            if ($filter_status = $this->request->get('status'))
            {
                $query_status = $this->db->placehold("AND cm.collection_status = ?", $filter_status);
                $this->design->assign('filter_status', $filter_status);
            }
            
            


            $query = $this->db->placehold("
                SELECT c.number,
                    c.id,
                    c.order_id,
                    c.inssuance_date,
                    cm.from_date,
                    cm.summ_body,
                    cm.summ_percents,
                    cm.manager_id,
                    u.birth,
                    u.lastname,
                    u.firstname,
                    u.patronymic
                FROM __collector_movings AS cm
                LEFT JOIN __contracts AS c
                ON c.id = cm.contract_id
                LEFT JOIN __users AS u
                ON u.id = c.user_id
                WHERE DATE(from_date) >= ?
                AND DATE(from_date) <= ?
                $query_status
                $query_manager
            ", $date_from, $date_to);

            $this->db->query($query);

            $count_od = 0;
            $count_percents = 0;
            $contracts = array();
            foreach ($this->db->results() as $contract) {
                $count_percents += $contract->summ_percents;
                $count_od += $contract->summ_body;
                $contracts[$contract->order_id] = $contract;
            }

            $this->design->assign('count_od', round($count_od));
            $this->design->assign('count_percents', round($count_percents));

            
            foreach ($contracts as $contract)
            {
                $this->db->query("
                    SELECT *
                    FROM __collector_movings AS cm
                    WHERE contract_id = ? 
                    AND DATE(from_date) > ?
                    ORDER BY id ASC
                    LIMIT 1
                ", $contract->id, $date_to);
                $contract->next_moving = $this->db->result();
                
                
                $this->db->query("
                    SELECT *
                    FROM __collections
                    WHERE contract_id = ?
                    AND DATE(created) >= ?
                ", $contract->id, $date_to);
                $contract->next_payment = $this->db->result();
            }
            
            $this->design->assign('contracts', $contracts);
        }

        $collection_statuses = $this->contracts->get_collection_statuses();

        if ($contracts_status = $this->request->get('status'))
            $this->design->assign('contracts_status', $contracts_status);

        $this->design->assign('collection_statuses', $collection_statuses);


        if ($this->request->post('datepick')) {

            $start = $this->request->post('start');
            $end = $this->request->post('end');

            $date_from = date('Y-m-d', strtotime($start));
            $date_to = date('Y-m-d', strtotime($end));

            $data = [];
            $data[] = $date_from;
            $data[] = $date_to;


            $query = $this->db->placehold("
                    SELECT DISTINCT m.name, m.id
                    FROM s_collector_movings AS cm
                    LEFT JOIN s_contracts AS c
                    ON c.id = cm.contract_id
                    LEFT JOIN s_managers AS m
                    ON m.id = cm.manager_id
                    WHERE DATE(from_date) >= ?
                    AND DATE(from_date) <= ? 
                    AND m.role = 'collector';
                   ", $date_from, $date_to);

            $this->db->query($query);
            $res = $this->db->results();

            $managers = array();
            $strm = '<select id="manager_list" name="manager_id" class="form-control">';
            foreach ($res as $m) {
                $add = "<option value='" . $m->id . "'>" . $m->name . "</option>";
                $strm = $strm . $add;
            }
            $strm = $strm . "</select>";

            echo json_encode(['resp' => 'success', 'test' => $data, 'str' => $strm]);
            exit;
        }

        return $this->design->fetch('collector_clients.tpl');
    }

}