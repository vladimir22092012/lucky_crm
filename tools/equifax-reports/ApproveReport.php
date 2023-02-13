<?php

use CloudCastle\EquifaxReport\Config\Config;
use CloudCastle\EquifaxReport\Individual\Client;
use CloudCastle\EquifaxReport\Report;
use CloudCastle\EquifaxReport\Report\Events;
use Config as Server;

class ApproveReport extends ReportsAbstract
{

    public static function processing($orderId)
    {
        $conf = new Server();

        $order = OrdersORM::find($orderId);

        $user = UsersORM::find($order->user_id);

        if (empty($user->regaddress_id))
            return 0;

        if (empty($user->faktaddress_id))
            return 0;

        list($passportSerial, $passportNumber) = explode('-', $user->passport_serial);

        Config::$configFile = $conf->root_dir . 'config.json';
        $config = Config::instance();
        $config->path = $conf->root_dir . 'reports-equifax';

        $reports = [];

        $client = new Client();
        /**
         * Опционально (при наличии данной информации)
         */
//$client->kski = 'fdglskh897876';

        /**
         * Номер СНИЛС
         */
        if (!empty($user->snils))
            $client->snils = $user->user->snils;

        /**
         * Номер ИНН
         */
        $client->inn->no = $user->inn;

        /**
         * Опционально
         */
//$client->inn->ogrnIp = '123456789012';

        /**
         * Если заемщик не является резидентом РФ
         */
//$client->inn->code = false;

        $client->last = $user->lastname;
        $client->first = $user->firstname;
        $client->middle = $user->patronymic;
        /*
        * Код страны гражданства (по умолчанию 643 - Россия)
        */
        $client->doc->country = 643;
        $client->doc->country_text = 'Российская Федерация';
        $client->doc->type_text = 'Паспорт';
        /*
        * Код типа документа удостоверяющего личность (по умолчанию 21 - Паспорт гражданина РФ)
        */
        $client->doc->type = 21;
        $client->doc->serial = $passportSerial;
        $client->doc->number = $passportNumber;
        $client->doc->date = date('d.m.Y', strtotime($user->passport_date));
        $client->doc->who = $user->passport_issued;
        $client->doc->department_code = $user->subdivision_code;

        /**
         * Опционально дата истечения срока действия документа
         */
        //$client->doc->end_date = date('d.m.Y', strtotime('12.12.2040'));

        /**
         * Дата рождения
         */
        $client->birthDate = date('d.m.Y', strtotime($user->birth));

        /**
         * Код страны рождения (по умолчанию 643 - Россия)
         */
        $client->birthCountry = 643;

        /**
         * Место рождения
         */
        $client->birthPlace = $user->birth_place;

        /**
         * Предыдущий документ
         *
         * $client->history->doc->country = '643';
         * $client->history->doc->country_text = 'Российская Федерация';
         * $client->history->doc->type_text = 'Паспорт';
         * $client->history->doc->type = '21';
         * $client->history->doc->serial = '1234';
         * $client->history->doc->number = '12345'.$i;
         * $client->history->doc->date = '12.12.2000';
         * $client->history->doc->who = 'УВД г. Москвы';
         * $client->history->doc->department_code = '123-456';
         */

        /**
         * Событие для отправки отчета
         */
        $event = new Events($client);
        $event->action = 'A';
        $event->event = '1.2';
        $event->action_reason = 'Источник одобрил обращение субъекта (направил ему оферту) или изменились сведения об обращении';
        $report = new Report($client, $event, $config);

        /*
    * UID предыдущего события (УИд обращения когда клиент обратился с предложением совершить сделку)
    */
        $report->information_part->application->uid = $report::uidGenerate();
        /*
        * Дата обращения (Дата когда клиент обратился с предложением совершить сделку)
        */
        $report->information_part->application->date = date('d.m.Y', strtotime($order->date));
        /*
        * Сумма запрошенного займа (кредита), лизинга или обеспечения
        */
        $report->information_part->application->sum = $order->amount;
        /*
        * Код запрошенной валюты обязательства
        */
        $report->information_part->application->currency = 'RUB';
        /*
        * Код вида участия в сделке (по умолчанию 1 - Заемщик)
        */
        $report->information_part->application->ratio = 1;
        /*
        * Код способа обращения
        * (по умолчанию 2 - Дистанционный - оформление с использованием средств телекоммуникаций)
        */
        $report->information_part->application->way = 2;
        /*
        * Код источника (по умолчанию 2 - Заимодавец микрофинансовая организация)
        */
        $report->information_part->application->source_type = 2;

        /*
         * Дата окончания действия одобрения обращения (оферты кредитора)
         */
        $report->information_part->application->approval_date = date('d.m.Y', strtotime($order->date.'+5 days'));

        $reports[] = $report;

        $file = Report::generate($reports, $config);

        echo self::sendFile($file);
        self::deleteDir($config->path . 'reports-equifax');

        $log =
            [
                'order_id' => $order->id,
                'type'     => 'Одобрение',
                'result'   => 'Успешно'
            ];

        self::logging($log);

        return 'success';
    }
}