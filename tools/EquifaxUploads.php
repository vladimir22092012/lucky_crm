<?php

use CloudCastle\EquifaxReport\Individual\Client;
use CloudCastle\EquifaxReport\Individual\Report as Report;
use CloudCastle\EquifaxConfig\Config;
use CloudCastle\EquifaxReport\Report as Generator;
use CloudCastle\EquifaxConfig\Info;

class EquifaxUploads implements ToolsInterface
{

    public static function processing($count)
    {
        $config = new Config('config.json');

        $reports = [];

        $contracts = ContractsORM::with('user')->orderBy('id', 'desc')->limit($count)->get();

        foreach ($contracts as $contract) {
            $title_part = new stdClass();
            $report = new stdClass();
            $report->info = new Info();
            $report->info->set([
                /**
                 * Id клиента в системе кредитной организации
                 */
                'recnumber' => $contract->user_id,
                /*
                 * Действие с кредитной историей
                 * Возможные варианты :
                 * 'Источник направляет кредитную историю о субъекте или его отдельном обязательстве впервые' => 'A',
                 * 'Кредитная история изменяется или дополняется' => 'B',
                 * 'Исправляется ошибка в кредитной информации или представляется непринятая бюро кредитная информация' => 'C',
                 * 'Аннулируются сведения' => 'D'
                 */
                'action' => 'Кредитная история изменяется или дополняется', // или B (по умолчанию)
                /*
                 * события, вследствие которого формируется запись кредитной истории
                 */
                'event' => 'Субъект обратился к источнику с предложением совершить сделку', // или 1.1 (по умолчанию)
                /*
                 * Объём выполняемой операции, производимой с записью кредитной истории
                 */
                'action_volume' => 'изменение отдельных показателей кредитной истории', // или 1 (по умолчанию)
                /*
                 * Причина предоставления операции, производимой с записью кредитной истории
                 * Указывается только при action => 'Аннулируются сведения'
                 */
                # 'action_reason' => 'На основании пункта 2 части 1 статьи 7 218-ФЗ: на основании решения суда, вступившего в силу', // или 2
            ]);
            $regAddress = AdressesORM::find($contract->user->regaddress_id);
            $faktAddress = AdressesORM::find($contract->user->faktaddress_id);

            list($passportSerial, $passportNumber) = explode('-', $contract->user->passport_serial);

            $client = new Client();
            $client->setName($contract->user->lastname, $contract->user->firstname, $contract->user->patronymic);
            $client->setInn(['inn' => $contract->user->inn]);
            $client->setSnils($contract->user->snils);
            $client->setBirth(
                [
                    'date' => date('d.m.Y', strtotime($contract->user->birth)),
                    'birthCountry' => 'Россия',
                    'birthPlace' => $contract->user->birth_place
                ]);
            $client->setDocument(
                [
                    'country' => 'Росиия',
                    'type' => 'Паспорт РФ',
                    'serial' => $passportSerial,
                    'number' => $passportNumber,
                    'date' => date('d.m.Y', strtotime($contract->user->passport_date)),
                    'who' => $contract->user->passport_issued,
                    'department_code' => $contract->user->subdivision_code
                ]);

            $title_part->private = $client;
            $report->title_part = $title_part;

            $report->title_part->base_part = new Report();

            $report->title_part->base_part
                ->setAddrReg([
                    'index' => $regAddress->zip,
                    'country' => 'Росиия',
                    'okato' => $regAddress->okato,
                    'street' => $regAddress->street_type . ' ' . $regAddress->street,
                    'house' => $regAddress->house
                ])
                ->setAddrFact([
                    'index' => $faktAddress->zip,
                    'country' => 'Росиия',
                    'okato' => $faktAddress->okato,
                    'street' => $faktAddress->street_type . ' ' . $faktAddress->street,
                    'house' => $faktAddress->house
                ])
                ->setContacts(
                    $contract->user->phone_mobile,
                    $contract->user->email
                )
                ->setContract(
                $contract->number,
                [
                    'deal' =>
                        [
                            'ratio' => 'Заемщик',
                            'date' => date('d.m.Y', strtotime($contract->inssuance_date)),
                            'category' => 'Договор займа (кредита)',
                            'type' => 'микрозаём',
                            'purpose' => '',
                            'sign_credit' => 1,
                            'sign_credit_card' => 1,
                            'sign_renovation' => 1,
                            'sign_deal_cash_source' => 1,
                            'sign_deal_cash_subject' => 1,
                            'end_date' => date('d.m.Y', strtotime($contract->return_date))
                        ],
                    'contract_amount' => [
                        'sum' => $contract->amount,
                        'currency' => 'Российский рубль',
                    ],
                    'full_cost' => [
                        'percent' => $contract->base_percent * 365,
                        'sum' => (($contract->base_percent / 100) * $contract->amount) * 30,
                        'date' => date('d.m.Y', strtotime($contract->inssuance_date)),
                    ]
                ]
            );

            $reports[] = $report;
        }

        /**
         * Передаем генератору конфигурацию и объект клиента для формирования титульной части КИ
         */
        $generator = new Generator($config, $reports);

        /**
         * Сгенерировать xml файл передав объект с информацией о КИ
         */
        $xml = $generator->create($count);

        $fileDir = $xml->file->realPath;
        $dir = $xml->file->path;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fileDir) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileDir));
        readfile($fileDir);
        self::deleteDir($dir);
        exit;
    }

    private static function deleteDir($path)
    {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                self::deleteDir(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }
}