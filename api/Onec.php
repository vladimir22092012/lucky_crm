<?php

ini_set("soap.wsdl_cache_enabled", 0);
ini_set('default_socket_timeout', '300');

class Onec implements ApiInterface
{
    protected static $link = "http://109.195.83.202:80/bar/ws/";
    protected static $login = 'Администратор';
    protected static $password = '';
    protected static $orderId;

    public static function sendRequest($request)
    {
        // TODO: Implement sendRequest() method.
    }

    private function send_loan($order_id)
    {
        self::$orderId = $order_id;

        $order = OrdersORM::find($order_id);
        $contract = ContractsORM::find($order->contract_id);
        $user = UsersORM::find($order->user_id);

        $user->regaddress = Addresses::find($order->regaddress_id);
        $user->faktaddress = Addresses::find($order->faktaddress_id);

        $passport_serial = str_replace([' ', '-'], '', $order->passport_serial);
        $passport_series = substr($passport_serial, 0, 4);
        $passport_number = substr($passport_serial, 4, 6);

        $item = new StdClass();

        $item->ID = (string)$contract->id;
        $item->Дата = date('YmdHis', strtotime($contract->inssuance_date));
        $item->Срок = $contract->period;
        $item->Периодичность = 'День';
        $item->ПроцентнаяСтавка = $contract->base_percent;
        $item->ПСК = '365';
        $item->ИдентификаторФормыВыдачи = 'Безналичная';
        $item->ИдентификаторФормыОплаты = 'ТретьеЛицо';
        $item->Сумма = $contract->amount;
        $item->Порог = '1.5';
        $item->ИННОрганизации = '9725055162';
        $item->СпособПодачиЗаявления = 'Прямой';

        $client = new StdClass();
        $client->id = $user->id;
        $client->ФИО = $user->lastname . ' ' . $user->firstname . ' ' . $user->patronymic;
        $client->Фамилия = $user->lastname;
        $client->Имя = $user->firstname;
        $client->Отчество = $user->patronymic;
        $client->ДатаРождения = date('Ymd000000', strtotime($user->birth));
        $client->МестоРождения = $user->birth_place;
        $client->АдресРегистрации = $user->regaddress->adressfull;
        $client->АдресПроживания = $user->faktaddress->adressfull;
        $client->Телефон = $this->format_phone($user->phone_mobile);
        $client->ОКАТО = $user->regaddress->okato;
        $client->ОКТМО = $user->regaddress->oktmo;

        $passport = new StdClass();
        $passport->Серия = $passport_series;
        $passport->Номер = $passport_number;
        $passport->КемВыдан = $user->passport_issued;
        $passport->КодПодразделения = $user->subdivision_code;
        $passport->ДатаВыдачи = date('Ymd000000', strtotime($user->passport_date));

        $client->Паспорт = $passport;

        $item->Клиент = $client;

        $request = new StdClass();
        $request->TextJSON = json_encode($item);
        $result = $this->send_request('CRM_WebService', 'Loans', $request);

        return $result;
    }
    private function send_request($service, $method, $request)
    {
        $params = array();
        if (!empty(self::$login) || !empty(self::$password))
        {
            $params['login'] = self::$login;
            $params['password'] = self::$password;
        }

        try {
            $service_url = self::$link . $service . ".1cws?wsdl";

            $client = new SoapClient($service_url, $params);
            $response = $client->__soapCall($method, array($request));
        } catch (Exception $fault) {
            $response = $fault;
        }

        $insert =
            [
                'orderId' => self::$orderId,
                'request' => json_encode($request),
                'response' => json_encode($response)
            ];

        OnecLogs::insert($insert);

        return $response;
    }

    public function format_phone($phone)
    {
        if (empty($phone)) {
            return '';
        }

        if ($phone == 'не указан' || $phone == 'не указана') {
            return '';
        }

        $replace_params = array('(', ')', ' ', '-', '+');
        $clear_phone = str_replace($replace_params, '', $phone);

        $substr_phone = mb_substr($clear_phone, -10, 10, 'utf8');
        $format_phone = '7(' . mb_substr($substr_phone, 0, 3, 'utf8') . ')' . mb_substr($substr_phone, 3, 3, 'utf8') . '-' . mb_substr($substr_phone, 6, 2, 'utf8') . '-' . mb_substr($substr_phone, 8, 2, 'utf8');

        return $format_phone;
    }
}