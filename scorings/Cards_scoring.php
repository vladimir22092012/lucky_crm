<?php

class Cards_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);

        $this->db->query("
        select *
        from s_cards
        where user_id = ?
        ", $scoring->user_id);

        $card = $this->db->result();

        $update = [
            'status' => 'completed',
            'body' => null,
            'string_result' => 'Срок годности карты до: '.$card->expdate,
            'success' => 1
        ];

        $this->scorings->update_scoring($scoring_id, $update);
        return $update;
    }
}