<?php

class Contacts_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);
        $user = $this->users->get_user($scoring->user_id);

        if (!empty($user->contact_person_name) && !empty($user->contact_person2_name)) {
            $this->db->query("
        select *
        from s_users
        where id != ?
        and contact_person_name = ?
        and contact_person_phone = ?
        or id != ?
        and contact_person_name = ?
        and contact_person_relation = ?
        or id != ?
        and contact_person2_name = ?
        and contact_person2_relation = ?
        or id != ?
        and contact_person2_name = ?
        and contact_person2_relation = ?
        ",
                $scoring->user_id,
                $user->contact_person_name,
                $user->contact_person_phone,
                $scoring->user_id,
                $user->contact_person2_name,
                $user->contact_person2_phone,
                $scoring->user_id,
                $user->contact_person_name,
                $user->contact_person_phone,
                $scoring->user_id,
                $user->contact_person2_name,
                $user->contact_person2_phone);

            $matched = $this->db->results();

            if (!empty($matched)) {
                $matchedUsers = [];

                foreach ($matched as $user) {

                    $matchedUsers[$user->id] = "$user->lastname $user->firstname $user->patronymic";
                }
            }

            $update = [
                'status' => 'completed',
                'body' => (!empty($matchedUsers)) ? serialize($matchedUsers) : null,
                'string_result' => (!empty($matchedUsers)) ? 'Найдены совпадения' : 'Совпадений не найдено',
                'success' => 1
            ];
        } else {
            $update = [
                'status' => 'completed',
                'body' => null,
                'string_result' => 'Контактные лица отсутствуют',
                'success' => 1
            ];
        }

        $this->scorings->update_scoring($scoring_id, $update);
    }
}