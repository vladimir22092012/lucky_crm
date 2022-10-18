<?php

/**
{
    "TUTDF": {
            "reported_date": "20210528",
            "member_data": "тесты тесты тесты",
            "username": "AE2390483394",
            "authorization_code": "PASSWORD",
            'cycle_identification': 'NOCYCLE'
        },
   
    "ID":[ {
            "doc_type": "21",
            "seria": "9823",
            "number": "757496",
            "issue_date": "20031212",
            "issued_by": "ОВД МОСКВЫ"
        },
    ],
    "NA":{
        "name": "Свирепов",
        "surname": "Сергей",
        "patronymic": "Александрович",
        "date_of_birth": "19650805",
        "place_of_birth": "г. Москва"
    },
    "AD":[
        {
            "address_type": "1",
            "postal_code": '123321',
            "country": 'RU',
            "region": '77',
            "district": 'ЦАО',
            "location": "Москва",
            "house_number": '1',
            "apartment":"15",
            "street": "Молодёжная",
            "status": "1",
        },
        {
            "country": "RU",
            "address_type": "2",
            "location": "Ростов-На-Дону",
            "street": "Молодёжная",
            "house_number": '1',
            "apartment":"15",
            "status": "1",
        }
    ],
    "TR":{
        "username": "AE2390483394",
        "account_number": "029387094723423",
        "account_type": "16",
        "account_relationship": "1",
        "date_account_opened": "20210530",
        "date_of_last_payment": "20210530",
        'account_rating': '00',
        "date_account_rating": "20210530",
        "date_reported": "20210530",
        "credit_limit_or_contract_amount": "10000",
        "balance": "10035",
        "past_due": "0",
        # "next_payment": "",
        "credit_payment_frequency": "2",
        "mop": '1',
        "date_of_contract_termination_date": "20210530",
        'date_payment_due': '20210620',
        "date_interest_payment_due": "20210620",
        "interest_payment_frequency": "1",
        "amount_outstanding": "0",
        "guarantor_indicator": "N",
        # "complete_performance_of_obligations_date": "",
        "trade_universally_unique_id": "cbe982e1-ebbc-11ec-9e14-810354d63c47-9",
        'overall_value_of_credit_percent_perannum': '10000',
        'overall_value_of_credit_monetary_amount': '10,000'
    }
}
*/

class Nbki_report extends Core
{
    public function send_order($order_id)
    {
        if ($order = $this->orders->get_order($order_id))
        {
            if ($contract = $this->contracts->get_contract($order->contract_id))
            {
                $total_summ = $contract->loan_body_summ + $contract->loan_percents_summ + $contract->loan_charge_summ + $contract->loan_peni_summ;
                if ($contract->payments = $this->operations->get_operations(['contract_id'=>$contract->id, 'type'=>'PAY']))
                {
                    $total_payments = array_reduce($contract->payments, function($a, $b){return $a + $b->amount;}, 0);
                    $last_payment = array_pop($contract->payments);
                }

                $return_date = new DateTime($contract->return_date);
                $inssuance_date = new DateTime($contract->inssuance_date);
                $diff = $return_date->diff($inssuance_date);
                $real_period = $diff->days;
            }
            
            $passport_serial = str_replace([' ','-'], '', $order->passport_serial);
            $passport_series = substr($passport_serial, 0, 4);
            $passport_number = substr($passport_serial, 4, 6);
            $data = new StdClass();
            
            /*
            "reported_date": "20210528",
            "member_data": "тесты тесты тесты",
            "username": "AE2390483394",
            "authorization_code": "PASSWORD",
            'cycle_identification': 'NOCYCLE'
            */
            $TUTDF = new StdClass();
            $TUTDF->reported_date = date('Ymd');
//            $TUTDF->member_data = ''; // Отладочные сообщения которые нбки не читает
            $TUTDF->username = 'test'; // Имя пользователя для передачи данных присваивается НБКИ.
            $TUTDF->authorization_code = 'test'; // Пароль к имени пользователя для передачи данных, присвоенный НБКИ.
//            $TUTDF->cycle_identification = ''; // Не обязательное Может содержать букву или число, помогающее идентифицировать информацию, содержащуюся в отчёте

            $data->TUTDF = $TUTDF;
            
            /*
            "ID":[ 
                {
                    "doc_type": "21",
                    "seria": "9823",
                    "number": "757496",
                    "issue_date": "20031212",
                    "issued_by": "ОВД МОСКВЫ"
                },
            ],
            */
            $ID = new StdClass();
            $ID->doc_type = '21';
            $ID->seria = $passport_series;
            $ID->number = $passport_number;
            $ID->issue_date = date('Ymd', strtotime($order->passport_date));// ГГГГММДД
            $ID->issued_by = $order->passport_issued;
            
            $data->ID = [$ID];
            
            /*
            "NA":{
                "name": "Свирепов",
                "surname": "Сергей",
                "patronymic": "Александрович",
                "date_of_birth": "19650805",
                "place_of_birth": "г. Москва"
            },
            */
            $NA = new StdClass();
            $NA->name = $order->firstname;
            $NA->surname = $order->lastname; 
            $NA->patronymic = $order->patronymic; 
            $NA->date_of_birth = date('Ymd', strtotime($order->birth));
            $NA->place_of_birth = $order->birth_place;
            
            $data->NA = $NA;
            
            /*
            "AD":[
                {
                    "address_type": "1",
                    "postal_code": '123321',
                    "country": 'RU',
                    "region": '77',
                    "district": 'ЦАО',
                    "location": "Москва",
                    "house_number": '1',
                    "apartment":"15",
                    "street": "Молодёжная",
                    "status": "1",
                },
                {
                    "country": "RU",
                    "address_type": "2",
                    "location": "Ростов-На-Дону",
                    "street": "Молодёжная",
                    "house_number": '1',
                    "apartment":"15",
                    "status": "1",
                }
            ],
            */
            
            $regaddress = new StdClass();
            $regaddress->address_type = 1; //1= Адрес регистрации (только для физлиц) 
            $regaddress->country = 'RU';
            $regaddress->postal_code = $order->Regindex;
            $regaddress->region = $this->helpers->get_code($order->Regregion);
            if (!empty($order->Regdistrict))
                $regaddress->district = $order->Regdistrict;
            $regaddress->location = empty($order->Reglocality) ? $order->Regcity : $order->Reglocality;
            if (!empty($order->Reghousing))
                $regaddress->house_number = $order->Reghousing;
            if (!empty($order->Regroom))
                $regaddress->apartment = $order->Regroom;
            if (!empty($order->Regstreet))
                $regaddress->street = $order->Regstreet;
            $regaddress->status = 5; // 1 = Собственность 2 = Аренда дома/квартиры 3 = Предоставлено/Оплачено государством/Муниципальная собственность 4 = Предоставлено/Оплачено третьей стороной 5 = Другое

            $faktaddress = new StdClass();
            $faktaddress->address_type = 1; //1= Адрес регистрации (только для физлиц) 
            $faktaddress->country = 'RU';
            $faktaddress->postal_code = $order->Faktindex;
            if (!empty($order->Faktregion))
                $faktaddress->region = $this->helpers->get_code($order->Faktregion);
            if (!empty($order->Faktdistrict))
                $faktaddress->district = $order->Faktdistrict;
            $faktaddress->location = empty($order->Faktlocality) ? $order->Faktcity : $order->Faktlocality;
            if (!empty($order->Fakthousing))
                $faktaddress->house_number = $order->Fakthousing;
            if (!empty($order->Faktroom))
                $faktaddress->apartment = $order->Faktroom;
            if (!empty($order->Faktstreet))
                $faktaddress->street = $order->Faktstreet;
            $faktaddress->status = 5; // 1 = Собственность 2 = Аренда дома/квартиры 3 = Предоставлено/Оплачено государством/Муниципальная собственность 4 = Предоставлено/Оплачено третьей стороной 5 = Другое

            $data->AD = [$regaddress, $faktaddress];

            /*
            "TR":{
                "username": "AE2390483394",
                "account_number": "029387094723423",
                "account_type": "16",
                "account_relationship": "1",
                "date_account_opened": "20210530",
                "date_of_last_payment": "20210530",
                'account_rating': '00',
                "date_account_rating": "20210530",
                "date_reported": "20210530",
                "credit_limit_or_contract_amount": "10000",
                "balance": "10035",
                "past_due": "0",
                # "next_payment": "",
                "credit_payment_frequency": "2",
                "mop": '1',
                "date_of_contract_termination_date": "20210530",
                'date_payment_due': '20210620',
                "date_interest_payment_due": "20210620",
                "interest_payment_frequency": "1",
                "amount_outstanding": "0",
                "guarantor_indicator": "N",
                # "complete_performance_of_obligations_date": "",
                "trade_universally_unique_id": "cbe982e1-ebbc-11ec-9e14-810354d63c47-9",
                'overall_value_of_credit_percent_perannum': '10000',
                'overall_value_of_credit_monetary_amount': '10,000'
            }
            */
            $TR = new StdClass();
            
            $TR->username = 'test'; // Имя пользовател ???
            $TR->account_number = $contract->number; // Номер счёта
            $TR->account_type = '16'; // 16 = Микрокредит
            $TR->account_relationship = '1'; // 1 = Физическое лицо (заемщик)
            $TR->date_account_opened = date('Ymd', strtotime($contract->inssuance_date)); // Дата открытия счёта ГГГГММДД
            $TR->date_of_last_payment = empty($last_payment) ? date('Ymd', strtotime($contract->inssuance_date)) : date('Ymd', strtotime($last_payment->created)); // Дата последней выплаты ГГГГММДД
            
            // Состояние счёта 00 = Активный 12 = Оплачен за счет обеспечения 13 = Счет закрыт 14 = Передан на обслуживание в другую организацию 21 = Спор 52 = Просрочен 61 = Проблемы с возвратом 70 = Передача данных прекращена 85 = Принудительное исполнение обязательств 90 = Списан с баланса 95 = Банкротство, освобождение от требований 96 = Возобновлена процедура банкротства
            if ($contract->status == 2)
                $TR->account_rating = '00'; 
            elseif ($contract->status == 3)
                $TR->account_rating = '13'; 
            elseif ($contract->status == 4)
                $TR->account_rating = '52'; 
            
            $TR->date_account_rating = date('Ymd'); // Дата состояния счёта Дата наступления (изменения) состояния счёта.
            $TR->date_reported = date('Ymd'); // Дата составления отчёта
            $TR->credit_limit_or_contract_amount = $contract->amount; // В данном поле указывается сумма обязательств (или предельного лимита по кредиту, предоставленному с использованием банковской карты) заемщика на дату заключения договора
            $TR->balance = $total_payments ?? 0; // Общая сумма выплаченных средств (нарастающим итогом) в рамках договора займа (кредита).  Значение может быть только неотрицательным.
            $TR->past_due = $total_summ ?? 0; // Общая сумма всех находящихся в просрочке средств, на последнюю дату обновления, указанную в поле Даты отчёта. Сумма составляет целое число и должна быть неотрицательной.
            $TR->next_payment = $total_summ; // может содержать сумму очередного следующего платежа (не включая просрочку)
            $TR->mop = '0';// 0 = Новый, оценка невозможна 1 = Оплата без просрочек A = (латиница) – Просрочка от 1 до 29 дней B = (латиница) – Просрочка от 1 до 7 дней C = (латиница) – Просрочка от 8 до 29 дней 2 = Просрочка от 30 до 59 дней 3 = Просрочка от 60 до 89 дней 4 = Просрочка от 90 до 119 дней 5 = Просрочка от 120 дней 8 = Погашение за счет обеспечения 9 = Безнадёжный долг/ передано на взыскание
            $TR->date_of_contract_termination_date = date('Ymd', strtotime($contract->return_date)); // Дата окончания срока договора ГГГГММДД опционально
            $TR->date_payment_due = date('Ymd', strtotime($contract->return_date)); // Дата финального платежа
            $TR->date_interest_payment_due = date('Ymd', strtotime($contract->return_date)); // Дата финальной выплаты процентов
            $TR->credit_payment_frequency = '2'; // Частота выплат:1 – Еженедельно 2 – Раз в две недели 3 – Ежемесячно 4 – Поквартально 5 – Раз в полгода 6 -  Ежегодно 7 – Другое
            $TR->interest_payment_frequency = '2'; // Частота выплат процентов (см выше)
            $TR->amount_outstanding = $total_summ ?? 0; // Размер суммарной текущей задолженности по данному кредиту, включая просрочку, проценты и пени. Т.е. это задолженность, которая может быть предложена заемщику к полному погашению на последнюю дату обновления, указанную в поле Даты отчёта.
            $TR->guarantor_indicator = 'N'; // N = нет поручителя 
            if (!empty($contract->close_date))
                $TR->complete_performance_of_obligations_date = date('Ymd', strtotime($contract->close_date)); // Дата фактического исполнения обязательств в полном объеме
            $TR->trade_universally_unique_id = $contract->uid; 
            $TR->overall_value_of_credit_percent_perannum = $contract->base_percent * 365; // Полная стоимость кредита, в процентах годовых
            $TR->overall_value_of_credit_monetary_amount = strval($real_period * $contract->base_percent / 100 * $contract->amount);

            $data->TR = $TR;
            
            $resp = $this->send($data);
        
            return $resp;
            
        }
        
    }
    
    private function send($data)
    {
        $url = 'http://85.236.173.222:9009/api/v1/report/test/';
        
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        
        $json_res = curl_exec($curl);
        $res = json_decode($json_res);
echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($data, $res);echo '</pre><hr />';
        curl_close($curl);
        
        return $res;
    }
}