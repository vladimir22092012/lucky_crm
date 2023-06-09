<?php

use CloudCastle\EquifaxReport\Config\Config;
use CloudCastle\EquifaxReport\Individual\Client;
use CloudCastle\EquifaxReport\Report;
use CloudCastle\EquifaxReport\Report\Events;
use Config as Server;

class SigningReport extends ReportsAbstract
{

    public static function processing($contractId)
    {
        $conf = new Server();

        Config::$configFile = $conf->root_dir . 'config.json';
        $config = Config::instance();

        $reports = [];

        $contract = ContractsORM::find($contractId);


        if (empty($contract->user->regaddress_id))
            return 0;

        if (empty($contract->user->faktaddress_id))
            return 0;

        $regAddress = AdressesORM::find($contract->user->regaddress_id);
        $faktAddress = AdressesORM::find($contract->user->faktaddress_id);
        list($passportSerial, $passportNumber) = explode('-', $contract->user->passport_serial);

        $client = new Client();
        /**
         * Опционально (при наличии данной информации)
         */
        //$client->kski = 'fdglskh897876';

        /**
         * Номер СНИЛС
         */

        if (!empty($contract->user->snils))
            $client->snils = $contract->user->snils;
        /**
         * Номер ИНН
         */
        $client->inn->no = $contract->user->inn;

        /**
         * Опционально
         */
        //$client->inn->ogrnIp = '123456789012';

        /**
         * Если заемщик не является резидентом РФ
         */
        //$client->inn->code = false;

        $client->last = $contract->user->lastname;
        $client->first = $contract->user->firstname;
        $client->middle = $contract->user->patronymic;
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
        $client->doc->date = date('d.m.Y', strtotime($contract->user->passport_date));
        $client->doc->who = $contract->user->passport_issued;
        $client->doc->department_code = $contract->user->subdivision_code;

        /**
         * Опционально дата истечения срока действия документа
         */
        //$client->doc->end_date = date('d.m.Y', strtotime('12.12.2040'));

        /**
         * Дата рождения
         */
        $client->birthDate = date('d.m.Y', strtotime($contract->user->birth));

        /**
         * Код страны рождения (по умолчанию 643 - Россия)
         */
        $client->birthCountry = 643;

        /**
         * Место рождения
         */
        $client->birthPlace = $contract->user->birth_place;

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
        $event->event = '1.4.1';
        $event->action_reason = 'Субъект и источник заключили договор лизинга либо поручительства по лизингу и предмет лизинга передан лизингополучателю';
        $report = new Report($client, $event, $config);

        /**
         * Регистрация физического лица по месту жительства или пребывания
         */
        $report->base_part->addr_reg->reg_code = '1';
        $report->base_part->addr_reg->index = $regAddress->zip;
        $report->base_part->addr_reg->country = 643;
        $report->base_part->addr_reg->country_text = 'Российская Федерация';
        //$report->base_part->addr_reg->fias = '5bc8ef01-ab23-45ef-67bd-a8c5f78a0d2f';
        $report->base_part->addr_reg->okato = $regAddress->okato;
        $report->base_part->addr_reg->street = $regAddress->street;
        $report->base_part->addr_reg->house = $regAddress->house;
        //$report->base_part->addr_reg->domain = '15';
        //$report->base_part->addr_reg->block = '1';
        $report->base_part->addr_reg->build = $regAddress->building;
        $report->base_part->addr_reg->apartment = !empty($regAddress->room) ? $regAddress->room : 1;
        //$report->base_part->addr_reg->reg_date = '01.01.2010';
        //$report->base_part->addr_reg->reg_place = 'УВД г.Москвы';
        //$report->base_part->addr_reg->reg_department_code = '555-555';

        /**
         * Фактическое место жительства
         */
        $report->base_part->addr_fact->index = $faktAddress->zip;
        $report->base_part->addr_fact->country = 643;
        $report->base_part->addr_fact->country_text = 'Российская Федерация';
        //$report->base_part->addr_fact->fias = 'abcdef01-ab23-45ef-67bd-a8c5f78a0d2e';
        $report->base_part->addr_fact->okato = $faktAddress->okato;
        $report->base_part->addr_fact->street = $faktAddress->street;
        $report->base_part->addr_fact->house = $faktAddress->house;
        //$report->base_part->addr_fact->domain = '10';
        //$report->base_part->addr_fact->block = '14';
        $report->base_part->addr_fact->build = $faktAddress->building;
        $report->base_part->addr_fact->apartment = !empty($faktAddress->room) ? $faktAddress->room : 1;;

        // Контактные данные
        $report->base_part->contacts[] = [
            /*
             * поле обязательно
             */
            'phone' => preg_replace('~([^0-9()+])~ui', '', $contract->user->phone_mobile),
            /*
             * поле необязательно
             * если отсутствует то необходимо указать null или вообще не указывать элемент в массиве
             */
            //'comment' => 'Комментарий',
            /*
             * поле необязательно
             * если отсутствует то необходимо указать null или вообще не указывать элемент в массиве
             */
            'email' => $contract->user->email
        ];

        /*
         * Должен соответствовать регулярному выражению
         * [a-fA-F0-9]{8}\-[a-fA-F0-9]{4}\-1[a-fA-F0-9]{3}\-(8|9|a|A|b|B){1}[a-fA-F0-9]{3}\-[a-fA-F0-9]{12}\-[a-fA-F0-9]{1}
         */
        $report->base_part->contract->uid = $report::uidGenerate();

        // Общие сведения о сделке
        /*
         * Код типа сделки (по умолчанию 1 - Договор займа (кредита))
         */
        $report->base_part->contract->deal->category = 1;
        /*
         * Признак использования платежной карты
         * По умолчанию 0 - сумма займа (кредита) выдается без использования платежной карты
         * Если сумма займа (кредита) выдается с использованием платежной карты, то sign_credit_card = 1
         */
        $report->base_part->contract->deal->sign_credit_card = 0;
        /*
         * Дата совершения сделки (свойство обязательно)
         */
        $report->base_part->contract->deal->date = date('d.m.Y', strtotime($contract->accept_date));
        /*
         * Дата прекращения обязательства субъекта по условиям сделки (свойство обязательно)
         */
        $report->base_part->contract->deal->end_date = date('d.m.Y', strtotime($contract->return_date));
        /*
         * Код цели займа (кредита) (по умолчанию 19 - Цель не определена)
         */
        $report->base_part->contract->deal->purpose = 19;
        /*
         * Код вида участия в сделке (по умолчанию 1 - Заемщик)
         */
        $report->base_part->contract->deal->ratio = 1;
        /*
         * Признак использования платежной карты
         * если сумма займа (кредита) выдается с использованием платежной карты,
         * то sign_credit должен быть равен 1, иначе 0
         */
        $report->base_part->contract->deal->sign_credit = 1;
        /*
         * Признак денежного обязательства источника (по умолчанию - 1)
         * если обязательство источника не являются деньги то sign_deal_cash_source должен быть равен 0
         */
        $report->base_part->contract->deal->sign_deal_cash_source = 1;
        /*
         * Признак денежного обязательства субъекта (по умолчанию - 1)
         * если обязательство субъекта не являются деньги то sign_deal_cash_subject должен быть равен 0
         */
        $report->base_part->contract->deal->sign_deal_cash_subject = 1;
        /*
         * Признак возникновения обязательства в результате новации (по умолчанию - 0)
         * если возникли обязательства в результате новации то sign_renovation должен быть равен 1
         */
        $report->base_part->contract->deal->sign_renovation = 0;
        /*
         * Код вида займа (кредита) (по умолчанию 3 - Микрозаем)
         */
        $report->base_part->contract->deal->type = 3;

        /*
         * Сведения о наличии солидарных должников (по умолчанию 0)
         * указывается число созаемщиков или поручителей
         */
        $report->base_part->contract->joint_debtors->count = 0;

        // Полная стоимость потребительского кредита (займа)
        /*
         * Дата расчета полной стоимости кредита (займа)
         */
        $report->base_part->contract->full_cost->date = date('d.m.Y', strtotime($contract->accept_date));
        /*
         * Полная стоимость кредита (займа) в процентах годовых
         */
        $report->base_part->contract->full_cost->percent = $contract->base_percent * 365;
        /*
         * Полная стоимость кредита (займа) в денежном выражении
         */
        $report->base_part->contract->full_cost->sum = round($contract->amount * $contract->base_percent * $contract->period / 100, 2);

        // Сумма и валюта обязательства
        /*
         * Сумма обязательства
         */
        $report->base_part->contract->contract_amount->sum = $contract->amount;
        /*
         * Валюта обязательства (по умолчанию RUB)
         */
        $report->base_part->contract->contract_amount->currency = 'RUB';
        /*
         * Сумма обеспечиваемого обязательства (по умолчанию 0)
         */
        $report->base_part->contract->contract_amount->security_sum = 0;

        // Сведения об условиях платежей
        /*
         * Сумма ближайшего следующего платежа по основному долгу
         */
        $report->base_part->contract->payment_terms->op_next_payout_sum = $contract->amount;
        /*
         * Дата ближайшего следующего платежа по основному долгу
         */
        $report->base_part->contract->payment_terms->op_next_payout_date = date('d.m.Y', strtotime($contract->return_date));
        /*
         * Сумма ближайшего следующего платежа по процентам
         */
        $report->base_part->contract->payment_terms->percent_next_payout_sum = round($contract->amount * $contract->base_percent * $contract->period / 100, 2);
        /*
         * Дата ближайшего следующего платежа по процентам
         */
        $report->base_part->contract->payment_terms->percent_next_payout_date = date('d.m.Y', strtotime($contract->return_date));
        /*
         * Код частоты платежей (по умолчанию 2 - От двух до четырех раз в месяц)
         */
        $report->base_part->contract->payment_terms->regularity = 1;
        /*
         * Сумма минимального платежа по кредитной карте (свойство не обязательное)
         * Указывается в том случае если по данному договору выдана кредитная карта
         */
        //$report->base_part->contract->payment_terms->min_sum_pay_cc = 2000;
        /*
         * Дата начала беспроцентного периода (свойство не обязательное)
         * Свойство может присутствовать при наличии в договоре займа (кредита) с расходным лимитом беспроцентного
         * периода. В данном свойстве указывается дата начала беспроцентного периода при его наступлении в соответствии
         * с условиями договора.
         */
        //$report->base_part->contract->payment_terms->grace_date = date('d.m.Y', strtotime('01.01.2023'));
        /*
         * Дата окончания беспроцентного периода (свойство не обязательное)
         * Свойство может присутствовать при наличии в договоре займа (кредита) с расходным лимитом беспроцентного
         * периода. При наступлении беспроцентного периода в данном свойстве указывается плановая дата его окончания
         * в соответствии с условиями договора. По окончании беспроцентного периода в данном свойстве
         * указывается фактическая дата его окончания.
         */
        //$report->base_part->contract->payment_terms->grace_date_end = date('d.m.Y', strtotime('15.01.2023'));
        /*
         * Дата окончания срока уплаты процентов
         * Значение свойства определяется датой, в которую субъект должен полностью погасить требования по
         * процентам на срочный долг. Заполняется датой самого последнего гашения всех процентов по
         * графику в соответствии с договором
         */
        $report->base_part->contract->payment_terms->percent_end_date = date('d.m.Y', strtotime($contract->return_date));


        // Сведения об обращении субъекта к источнику с предложением совершить сделку
        // Опционально при наличии информации об обращении
        // Есди обращение отсутствует, то необходимо удалить данный объект unset($report->information_part);
        /*
         * UID предыдущего события (УИд обращения когда клиент обратился с предложением совершить сделку)
         */
        $report->information_part->application->uid = '102c4fd0-98b7-11ed-8f11-3dadacbb2a66-e';
        /*
         * Дата обращения (Дата когда клиент обратился с предложением совершить сделку)
         */
        $report->information_part->application->date = date('d.m.Y', strtotime('15.12.2022'));
        /*
         * Сумма запрошенного займа (кредита), лизинга или обеспечения
         */
        $report->information_part->application->sum = 5000;
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
         * Код источника (по умолчанию 2 - Заимодавец - микрофинансовая организация)
         */
        $report->information_part->application->source_type = 2;
        /*
         * Дата окончания действия одобрения обращения (оферты кредитора)
         */
        $report->information_part->application->approval_date = date('d.m.Y', strtotime('+5 days'));

        unset($report->information_part);

        $reports[] = $report;


        $file = Report::generate($reports, $config);

        /*

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);

        */

        self::sendFile($file);
        self::deleteDir($config->path . 'reports-equifax');

        $log =
            [
                'order_id' => $contract->order_id,
                'type'     => 'Подпись',
                'result'   => 'Успешно'
            ];

        self::logging($log);

        return 'success';
    }
}