<?php


class Cloudkassir extends Core
{
    private $ck_API;
    private $ck_PublicId;
    private $ck_INN;

    public function __construct()
    {
        parent::__construct();

        $this->ck_API = $this->settings->apikeys['cloudkassir']['ck_API'];
        $this->ck_PublicId = $this->settings->apikeys['cloudkassir']['ck_PublicId'];
        $this->ck_INN = $this->settings->apikeys['cloudkassir']['ck_INN'];
    }

    public function send_insurance($operation_id)
    {
        if ($operation = $this->operations->get_operation($operation_id))
        {
            $insurance = $this->insurances->get_operation_insurance($operation->id);
            $user = $this->users->get_user($operation->user_id);
            $contract = $this->contracts->get_contract($operation->contract_id);

            $items = array();
            $total_amount = 0;

            $item = array(
                'label'           => 'Страховая премия - страхование от несчастных случаев',
                'price'           => $operation->amount,
                'quantity'        => 1,
                'amount'          => $operation->amount,
                'method'          => 0,
                'object'          => 0,
                'measurementUnit' => 'ед',
                "AgentSign"       => 6,                 //признак агента, тег ОФД 1222
                "AgentData"       => null,              //данные агента, тег офд 1223
                "PurveyorData"    => array(             //данные поставщика платежного агента,  тег ОФД 1224
                    "Phone" => "88007751575",           // телефон поставщика, тег ОД 1171
                    "Name"  => 'СТРАХОВОЕ АКЦИОНЕРНОЕ ОБЩЕСТВО "ВСК"',                 // наименование поставщика, тег ОФД 1225
                    "Inn"   => '7710026574',                    // ИНН поставщика, тег ОФД 1226
                ),

            );
            $total_amount += $operation->amount;

            if (!empty($insurance->protection))
                $item['label'] = 'Кредитная защита';

            $items[] = $item;

            $receipt = array(
                'Items'         => $items,
                'taxationSystem'=> 0, //система налогообложения; необязательный, если у вас одна система налогообложения
                'customerInfo'     => $user->lastname.' '.$user->firstname.' '.$user->patronymic,
                'amounts'       =>array (
                    'electronic'     => $total_amount,
                    'advancePayment' => 0,
                    'credit'         => 0,
                    'provision'      => 0,
                )
            );

            if (!empty($insurance->protection))
            {
                $receipt['email'] = 'str@nalichnoeplus.ru';
            }
            else
            {
                if (!empty($user->email))
                    $receipt['email'] = $user->email;
                if (!empty($user->phone_mobile))
                    $receipt['phone'] = $user->phone_mobile;
            }

            $data = array(
                'Inn'              => $this->ck_INN, //ИНН
                'InvoiceId'        => $contract->number, //номер заказа, необязательный
                'AccountId'        => $user->id, //идентификатор пользователя, необязательный
                'Type'             => 'Income', //признак расчета
                'CustomerReceipt'  => $receipt,
            );

            $res = $this->getResource($insurance->number.md5(serialize($items)), $data);

            $this->soap1c->logging(__METHOD__, 'https://api.cloudpayments.ru/kkt/receipt', $data, (array)$res, 'service.log');

            return $res;

        }
        else
        {
            return 'undefined_operation';
        }

    }

    public function send_reject_reason($order_id)
    {
        if ($order = $this->orders->get_order($order_id))
        {
            $items = array();
            $total_amount = 0;
            $item = array(
                'label'           => 'Информирование о причине отказа',
                'price'           => 39,
                'quantity'        => 1,
                'amount'          => 39,
                'vat'             => 20,
                'method'          => 4,
                'object'          => 4,
                'measurementUnit' => 'ед',
            );
            $total_amount = 39;

            $items[] = $item;

            $receipt = array(
                'Items'         => $items,
                'taxationSystem'=> 0, //система налогообложения; необязательный, если у вас одна система налогообложения
                'customerInfo'     => $order->lastname.' '.$order->firstname.' '.$order->patronymic,
                'amounts'       =>array (
                    'electronic'     => $total_amount,
                    'advancePayment' => 0,
                    'credit'         => 0,
                    'provision'      => 0,
                )
            );
            if (!empty($order->email))
                $receipt['email'] = $order->email;
            if (!empty($order->phone_mobile))
                $receipt['phone'] = $order->phone_mobile;

            $data = array(
                'Inn'              => $this->ck_INN, //ИНН
                'InvoiceId'        => $order->order_id, //номер заказа, необязательный
                'AccountId'        => $order->user_id, //идентификатор пользователя, необязательный
                'Type'             => 'Income', //признак расчета
                'CustomerReceipt'  => $receipt,
            );

            return $this->getResource($order->order_id.md5(serialize($items)), $data);
        }
        else
        {
            return 'undefined order';
        }
    }

    /**
     * @param $operation_id
     * @param $email
     *
     * @return false|string
     */
    public function send_close_contract($operation_id, $email = '') {
        if ($operation = $this->operations->get_operation($operation_id))
        {
            $insurance = $this->insurances->get_operation_insurance($operation->id);
            $user = $this->users->get_user($operation->user_id);
            $contract = $this->contracts->get_contract($operation->contract_id);

            $customerInfo = join(' ', [$user->lastname, $user->firstname, $user->patronymic]);

            if (empty($email)) {
                $email = $user->email;
            }
            $subject = 'Закрытые оффлайн-займа';

            $this->design->assign('customerInfo', $customerInfo);

            $mail = $this->design->fetch('offline/close_contract_email.tpl');

            if ($this->notify->email($email, $subject, $mail, $this->settings->notify_from_email)) {
                return json_encode(['success' => true, 'error' => false]);
            }

            return json_encode(['success' => false, 'error' => 'Fail Send mail']);
        }
        else
        {
            return json_encode('undefined_operation');
        }
    }

    public function send_add_card($user_id)
    {
        if ($user = $this->users->get_user($user_id))
        {
            $items = array();
            $total_amount = 1;
            $item = array(
                'label'           => 'Привязка карты',
                'price'           => 1,
                'quantity'        => 1,
                'amount'          => 1,
                'vat'             => 20,
                'method'          => 4,
                'object'          => 4,
                'measurementUnit' => 'ед',
            );

            $total_amount = 1;

            $items[] = $item;

            $receipt = array(
                'Items'         => $items,
                'taxationSystem'=> 0, //система налогообложения; необязательный, если у вас одна система налогообложения
                'customerInfo'     => $user->lastname.' '.$user->firstname.' '.$user->patronymic,
                'amounts'       =>array (
                    'electronic'     => $total_amount,
                    'advancePayment' => 0,
                    'credit'         => 0,
                    'provision'      => 0,
                )
            );
            if (!empty($user->email))
                $receipt['email'] = $user->email;
            if (!empty($user->phone_mobile))
                $receipt['phone'] = $user->phone_mobile;

            $data = array(
                'Inn'              => $this->ck_INN, //ИНН
                'AccountId'        => $user->id, //идентификатор пользователя, необязательный
                'Type'             => 'Income', //признак расчета
                'CustomerReceipt'  => $receipt,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD,$this->ck_PublicId. ':' . $this->ck_API);
            curl_setopt($ch, CURLOPT_URL, 'https://api.cloudpayments.ru/kkt/receipt');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array  (
                    'content-type: application/json',
                    'X-Request-ID:'.$user->id.md5(serialize($items)))
            );

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $res = curl_exec($ch);
            curl_close($ch);

            //        $this->logging(__METHOD__, 'https://api.cloudpayments.ru/kkt/receipt', (array)$data, (array)$res, 'service.log');

            return $res;


        }
        else
        {
            return 'undefined order';
        }
    }
       
    //ответ на запрос
    public function response($code)
    {
        header('Content-Type:application/json');
        echo json_encode(array('code'=>$code));
    }

    /**
     * @param $xRequestId
     * @param $data
     *
     * @return bool|string
     */
    public function getResource($xRequestId = '', $data = []) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->ck_PublicId . ':' . $this->ck_API);
        curl_setopt($ch, CURLOPT_URL, 'https://api.cloudpayments.ru/kkt/receipt');

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'content-type: application/json',
            'X-Request-ID:'. $xRequestId
        ]);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

}
