<?php

class Helpers extends Core
{
    public function get_ip()
    {
    	return $_SERVER['REMOTE_ADDR'];
    }
    
    public function format_client_details($details)
    {
        if ($details->Пол == 'Мужской')
            $gender = 'male';
        elseif ($details->Пол == 'Женский')
            $gender = 'female';
        else
            $gender = '';
        
        $birth = date('d.m.Y', strtotime($details->ДатаРождения));
        if (empty($birth))
            $birth = '';
        
        $passport_date = date('d.m.Y', strtotime($details->ПаспортДатаВыдачи));
        if (empty($passport_date))
            $passport_date = '';
        
        list($regregion, $regregion_shorttype) = $this->parse_shorttype($details->АдресРегистрацииРегион);
        list($regdistrict, $regdistrict_shorttype) = $this->parse_shorttype($details->АдресРегистрацииРайон);
        list($reglocality, $reglocality_shorttype) = $this->parse_shorttype($details->АдресРегистрацииНасПункт);
        list($regcity, $regcity_shorttype) = $this->parse_shorttype($details->АдресРегистрацииГород, ',');
        list($regstreet, $regstreet_shorttype) = $this->parse_shorttype($details->АдресРегистрацииУлица);

        list($faktregion, $faktregion_shorttype) = $this->parse_shorttype($details->АдресФактическогоПроживанияРегион);
        list($faktdistrict, $faktdistrict_shorttype) = $this->parse_shorttype($details->АдресФактическогоПроживанияРайон);
        list($faktlocality, $faktlocality_shorttype) = $this->parse_shorttype($details->АдресФактическогоПроживанияНасПункт);
        list($faktcity, $faktcity_shorttype) = $this->parse_shorttype($details->АдресФактическогоПроживанияГород, ',');
        list($faktstreet, $faktstreet_shorttype) = $this->parse_shorttype($details->АдресФактическогоПроживанияУлица);


        $user = array(
            
            'gender' => $gender,
            'birth' => $birth,
            'birth_place' => $details->МестоРожденияПоПаспорту,
            'phone_mobile' => $this->sms->clear_phone($details->МобильныйТелефон),

            'passport_serial' => $details->ПаспортСерия.'-'.$details->ПаспортНомер,
            'subdivision_code' => $details->ПаспортКодПодразделения,
            'passport_date' => $passport_date,
            'passport_issued' => $details->ПаспортКемВыдан,

            'Regindex' => $details->АдресРегистрацииИндекс,
            'Regregion' => empty($regregion) ? '' : $regregion,
            'Regregion_shorttype' => empty($regregion_shorttype) ? '' : $regregion_shorttype,
            'Regdistrict' => empty($regdistrict) ? '' : $regdistrict,
            'Regdistrict_shorttype' => empty($regdistrict_shorttype) ? '' : $regdistrict_shorttype,
            'Reglocality' => empty($reglocality) ? '' : $reglocality,
            'Reglocality_shorttype' => empty($reglocality_shorttype) ? '' : $reglocality_shorttype,
            'Regcity' => empty($regcity) ? '' : $regcity,
            'Regcity_shorttype' => empty($regcity_shorttype) ? '' : $regcity_shorttype,
            'Regstreet' => empty($regstreet) ? '' : $regstreet,
            'Regstreet_shorttype' => empty($regstreet_shorttype) ? '' : $regstreet_shorttype,
            'Reghousing' => $details->АдресРегистрацииДом,
            'Regbuilding' => '',
            'Regroom' => $details->АдресРегистрацииКвартира,

            'Faktindex' => $details->АдресФактическогоПроживанияИндекс,
            'Faktregion' => empty($faktregion) ? '' : $faktregion,
            'Faktregion_shorttype' => empty($faktregion_shorttype) ? '' : $faktregion_shorttype,
            'Faktdistrict' => empty($faktdistrict) ? '' : $faktdistrict,
            'Faktdistrict_shorttype' => empty($faktdistrict_shorttype) ? '' : $faktdistrict_shorttype,
            'Faktlocality' => empty($faktlocality) ? '' : $faktlocality,
            'Faktlocality_shorttype' => empty($faktlocality_shorttype) ? '' : $faktlocality_shorttype,
            'Faktcity' => empty($faktcity) ? '' : $faktcity,
            'Faktcity_shorttype' => empty($faktcity_shorttype) ? '' : $faktcity_shorttype,
            'Faktstreet' => empty($faktstreet) ? '' : $faktstreet,
            'Faktstreet_shorttype' => empty($faktstreet_shorttype) ? '' : $faktstreet_shorttype,
            'Fakthousing' => $details->АдресФактическогоПроживанияДом,
            'Faktbuilding' => '',
            'Faktroom' => $details->АдресФактическогоПроживанияКвартира,
            
            'profession' => $details->ОрганизацияДолжность,
            'workplace' => $details->ОрганизацияНазвание,
            'workaddress' => $details->ОрганизацияАдрес,
            'workphone' => $this->sms->clear_phone($details->ОрганизацияТелефон),
            'chief_name' => $details->ОрганизацияФИОРуководителя,

        );
                
        return $user;
    }

    /**
     * Import_1c::parse_shorttype()
     * Парсит названия городов, регионов улиц и извлекает тип 
     * 
     * @param string $subject
     * @param string $delimiter
     * @return array
     */
    private function parse_shorttype($subject, $delimiter = ' ')
    {
        $response = array(
            0 => '', // main
            1 => '', // shorttype
        );
        
        if (!empty($subject))
        {
            $expl = explode($delimiter, $subject);
            if (count($expl) > 1)
            {
                $response[1] = mb_strtolower(array_pop($expl), 'utf-8');
                $response[0] = implode($delimiter, $expl);
            }
            else
            {
                $response[0] = $subject;
            }
        }
        
        return $response;
    }

    
    public function get_regional_time($region)
    {
    	$region_times = array(
            "адыгея" => 0,
            "башкортостан" => 2,
            "бурятия" => 5,
            "алтай" => 4,
            "дагестан" => 0,
            "ингушетия" => 0,
            "кабардино-балкарская" => 0,
            "калмыкия" => 0,
            "карачаево-черкесская" => 0,
            "карелия" => 0,
            "коми" => 0,
            "марий эл" => 0,
            "мордовия" => 0,
            "саха /якутия/" => 6,
            "северная осетия - алания" => 0,
            "татарстан",
            "тыва" => 4,
            "удмуртская" => 1,
            "хакасия" => 4,
            "чеченская",
            "чувашская" => 0,
            "алтайский" => 4,
            "краснодарский" => 0,
            "красноярский" => 4,
            "приморский" => 7,
            "ставропольский",
            "хабаровский" => 7, 
            "амурская" => 6,
            "архангельская" => 0,
            "астраханская" => 1,
            "белгородская" => 0,
            "брянская" => 0,
            "владимирская" => 0,
            "волгоградская" => 0,
            "вологодская" => 0,
            "воронежская" => 0,
            "ивановская" => 0,
            "иркутская" => 5,
            "калининградская" => -1,
            "калужская" => 0,
            "камчатский" => 9,
            "кемеровская" => 4,
            "кировская" => 0,
            "костромская" => 0,
            "курганская" => 2,
            "курская" => 0,
            "ленинградская" => 0,
            "липецкая" => 0,
            "магаданская" => 8,
            "московская" => 0,
            "мурманская" => 0,
            "нижегородская" => 0,
            "новгородская" => 0,
            "новосибирская" => 4,
            "омская" => 3,
            "оренбургская" => 2,
            "орловская" => 0,
            "пензенская" => 0,
            "пермский" => 2,
            "псковская" => 0,
            "ростовская" => 0,
            "рязанская" => 0,
            "самарская" => 1,
            "саратовская" => 1,
            "сахалинская" => 8,
            "свердловская" => 2,
            "смоленская" => 0,
            "тамбовская" => 0,
            "тверская" => 0,
            "томская" => 4,
            "тульская" => 0,
            "тюменская" => 2,
            "ульяновская" => 1,
            "челябинская" => 2,
            "забайкальский" => 6,
            "ярославская" => 0,
            "москва" => 0,
            "санкт-петербург" => 0,
            "крым" => 0,
            "ханты-мансийский автономный округ - югра" => 2,
            "чукотский" => 9,
            "ямало-ненецкий" => 2,
            "севастополь" => 0,

        );
        
        $region = trim(mb_strtolower($region));
        
        $shift = 0;
        if (isset($region_times[$region]))
            $shift = $region_times[$region];
        
        return date('Y-m-d H:i:s', time() + $shift * 3600);
    }
    


    private $c2o_codes = array(
        array('z', 'x', 'c', 'V', 'B', 'N', 'm', 'A', 's', '4'),
        array('Q', 'W', 'r', 'S', '6', 'Y', 'k', 'n', 'G', 'i'),
        array('T', '2', 'H', 'e', 'D', '1', '8', 'P', 'o', 'g'),
        array('O', 'u', 'Z', 'h', '0', 'I', 'J', '7', 'a', 'L'),
        array('v', 'w', 'p', 'E', 't', '5', 'b', '9', 'l', 'R'),
        array('d', '3', 'q', 'C', 'U', 'M', 'y', 'X', 'K', 'j'),        
    );
    
    public function c2o_encode($id)
    {
    	$code = '';
        
        $chars = str_split($id);
        
        if (count($chars) != 6)
            return false;
        
        $code .= $this->c2o_codes[5][$chars[5]];
        $code .= $this->c2o_codes[4][$chars[4]];
        $code .= $this->c2o_codes[3][$chars[3]];
        $code .= $this->c2o_codes[2][$chars[2]];
        $code .= $this->c2o_codes[1][$chars[1]];
        $code .= $this->c2o_codes[0][$chars[0]];
        return $code;
    }
    
    public function c2o_decode($code)
    {
    	$id = '';
        
        $chars = str_split($code);
        
        if (count($chars) != 6)
            return false;

        $id .= array_search($chars[5], $this->c2o_codes[0]);
        $id .= array_search($chars[4], $this->c2o_codes[1]);
        $id .= array_search($chars[3], $this->c2o_codes[2]);
        $id .= array_search($chars[2], $this->c2o_codes[3]);
        $id .= array_search($chars[1], $this->c2o_codes[4]);
        $id .= array_search($chars[0], $this->c2o_codes[5]);
        
        return $id;
    	
    }
    
    public function get_code($region_name)
    {
        $codes = array(
            1 => "адыгея",
            2 => "башкортостан",
            3 => "бурятия",
            4 => "алтай",
            5 => "дагестан",
            6 => "ингушетия",
            7 => "кабардино-балкарская",
            8 => "калмыкия",
            9 => "карачаево-черкесская",
            10 => "карелия",
            11 => "коми",
            12 => "марий эл",
            13 => "мордовия",
            14 => "саха /якутия/",
            15 => "северная осетия - алания",
            16 => "татарстан",
            17 => "тыва",
            18 => "удмуртская",
            19 => "хакасия",
            20 => "чеченская",
            21 => "чувашская",
            22 => "алтайский",
            23 => "краснодарский",
            24 => "красноярский",
            25 => "приморский",
            26 => "ставропольский",
            27 => "хабаровский", 
            28 => "амурская",
            29 => "архангельская",
            30 => "астраханская",
            31 => "белгородская",
            32 => "брянская",
            33 => "владимирская",
            34 => "волгоградская",
            35 => "вологодская",
            36 => "воронежская",
            37 => "ивановская",
            38 => "иркутская",
            39 => "калининградская",
            40 => "калужская",
            41 => "камчатский",
            42 => "кемеровская",
            43 => "кировская",
            44 => "костромская",
            45 => "курганская",
            46 => "курская",
            47 => "ленинградская",
            48 => "липецкая",
            49 => "магаданская",
            50 => "московская",
            51 => "мурманская",
            52 => "нижегородская",
            53 => "новгородская",
            54 => "новосибирская",
            55 => "омская",
            56 => "оренбургская",
            57 => "орловская",
            58 => "пензенская",
            59 => "пермский",
            60 => "псковская",
            61 => "ростовская",
            62 => "рязанская",
            63 => "самарская",
            64 => "саратовская",
            65 => "сахалинская",
            66 => "свердловская",
            67 => "смоленская",
            68 => "тамбовская",
            69 => "тверская",
            70 => "томская",
            71 => "тульская",
            72 => "тюменская",
            73 => "ульяновская",
            74 => "челябинская",
            75 => "забайкальский",
            76 => "ярославская",
            77 => "москва",
            78 => "санкт-петербург",
            82 => "крым",
            86 => "ханты-мансийский автономный округ - югра",
            87 => "чукотский",
            89 => "ямало-ненецкий",
            92 => "севастополь",
        );
        
        $index = array_search(mb_strtolower($region_name, 'utf8'), $codes);
        
        if (mb_strtolower($region_name, 'utf8') == 'еврейская')
            $index = 27;
        if (mb_strtolower($region_name, 'utf8') == 'ненецкий')
            $index = 29;
        if (mb_strtolower($region_name, 'utf8') == 'кемеровская область - кузбасс')
            $index = 42;
        
        return $index;            
    }
    


}