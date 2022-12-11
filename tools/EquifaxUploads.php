<?php

use CloudCastle\EquifaxReport\Individual\Client;
use CloudCastle\EquifaxReport\Individual\Report;
use CloudCastle\EquifaxConfig\Config;
use CloudCastle\EquifaxConfig\Action;
use CloudCastle\EquifaxReport\Generator;

class EquifaxUploads implements ToolsInterface
{

    public static function processing($orderId)
    {
        $order = OrdersORM::with('user')->find($orderId);
        $contract = ContractsORM::where('order_id', $orderId)->first();
        $regAddress = AdressesORM::find($order->user->regaddress_id);
        $faktAddress = AdressesORM::find($order->user->faktaddress_id);

        list($passportSerial, $passportNumber) = explode('-', $order->user->passport_serial);

        $client = new Client();
        $client->setName($order->user->lastname, $order->user->firstname, $order->user->patronymic);
        $client->setInn(['inn' => $order->user->inn]);
        $client->setSnils($order->user->snils);
        $client->setBirth(
            [
                'date' => date('d.m.Y', strtotime($order->user->birth)),
                'birthCountry' => 'Россия',
                'birthPlace' => $order->user->birth_place
            ]);
        $client->setDocument(
            [
                'country' => 'Росиия',
                'type' => 'Паспорт РФ',
                'serial' => $passportSerial,
                'number' => $passportNumber,
                'date' => date('d.m.Y', strtotime($order->user->passport_date)),
                'who' => $order->user->passport_issued,
                'department_code' => $order->user->subdivision_code
            ]);

        $report = new Report();
        $report
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
                $order->user->phone_mobile,
                $order->user->email
            );
        if (!empty($contract)) {
            $report->setContract(

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
        }

        $config = new Config('config.json');
        $action = new Action();


        $action->set([
            'action' => 'Источник направляет кредитную историю о субъекте или его отдельном обязательстве впервые',
            'event' => 'Субъект обратился к источнику с предложением совершить сделку',
            'action_volume' => 'Изменение отдельных показателей кредитной истории'
        ]);
        $config->setAction($action);

        /**
         * Передаем генератору конфигурацию и объект клиента для формирования титульной части КИ
         */
        $generator = new Generator($config, $client);

        /**
         * Сгенерировать xml файл передав объект с информацией о КИ
         */
        $xml = $generator->create($report);

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