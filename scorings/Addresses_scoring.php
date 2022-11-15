<?php

class Addresses_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $user = $this->users->get_user($scoring->user_id);

        $regaddress = $this->Addresses->get_address($user->regaddress_id);
        $regaddress_full = $regaddress->adressfull;
        $faktaddress = $this->Addresses->get_address($user->faktaddress_id);
        $faktaddress_full = $faktaddress->adressfull;

        $this->db->query("
        select *
        from s_addresses
        where id != ?
        and adressfull = ?
        or id != ?
        and adressfull = ?
        ", $regaddress->id, $regaddress_full, $faktaddress->id, $faktaddress_full);

        $matched = $this->db->results();

        if (!empty($matched)) {
            $matchedUsers = [];

            foreach ($matched as $address) {
                $this->db->query("
                select *
                from s_users
                where regaddress_id = ?
                and id != ?
                or faktaddress_id = ?
                and id != ?
                ", $address->id, $user->id, $address->id, $user->id);

                $matchedUser = $this->db->result();

                if (!empty($matchedUser))
                    $matchedUsers[$matchedUser->id] = "$matchedUser->lastname $matchedUser->firstname $matchedUser->patronymic";
            }
        }

        $update = [
            'status' => 'completed',
            'body' => (!empty($matchedUsers)) ? serialize($matchedUsers) : null,
            'string_result' => (!empty($matchedUsers)) ? 'Найдены совпадения' : 'Совпадений не найдено',
            'success' => 1
        ];

        $this->scorings->update_scoring($scoring_id, $update);
    }
}