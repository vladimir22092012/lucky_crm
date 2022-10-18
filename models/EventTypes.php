<?php

class EventTypes extends Core
{
    public function add_event($event)
    {
        $query = $this->db->placehold("
            INSERT INTO __event_types SET ?%
        ", (array)$event);

        $this->db->query($query);
        $id = $this->db->insert_id();

        return $id;
    }

    public function update_event($event, $id)
    {
        $query = $this->db->placehold("
            UPDATE __event_types SET ?% WHERE id = ?
        ", (array)$event, (int)$id);

        $this->db->query($query);

        return $id;
    }

    public function delete_event($id)
    {
        $query = $this->db->placehold("
            DELETE FROM __event_types WHERE id = ?
        ", (int)$id);

        $this->db->query($query);
    }

    public function get_events()
    {
        $query = $this->db->placehold("
            SELECT * 
            FROM __event_types
        ");

        $this->db->query($query);

        $result = $this->db->results();

        return $result;
    }

    public function get_event($id)
    {
        $query = $this->db->placehold("
            SELECT * 
            FROM __event_types
            where id = ?
        ", (int)$id);

        $this->db->query($query);

        $result = $this->db->result();

        return $result;
    }
}