<?php

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class Efrsb_scoring extends Core
{
    public function run_scoring($scoring_id)
    {
        $scoring = $this->scorings->get_scoring($scoring_id);

        $order = $this->orders->get_order((int)$scoring->order_id);


        if (empty($order->inn)) {
            $update = array(
                'status' => 'error',
                'string_result' => 'Не найден ИНН'
            );
        }
        elseif (empty($order->lastname) || empty($order->firstname) || empty($order->patronymic) || empty($order->passport_serial) || empty($order->passport_date) || empty($order->birth))
        {
            $update = array(
                'status' => 'error',
                'string_result' => 'в заявке не достаточно данных для проведения скоринга'
            );
        }
        else {

            $birthday = date('d.m.Y', strtotime($order->birth));
            $passportdate = date('d.m.Y', strtotime($order->passport_date));
            $fns = $this->get_inn($order->lastname, $order->firstname, $order->patronymic, $birthday, 21, $order->passport_serial, $passportdate);

            $response = $this->getting_html(
                $fns->inn
            );

            if (isset($response[0]) & isset($response[1])) {
                $search = 'Вся информация';
                $serch_url = 'person';
                $searchString = 'Ничего не найдено';

                if (preg_match("/{$searchString}/i", $response[0]) & !preg_match("/{$search}/i", $response[0])) {
                    $update = array(
                        'status' => 'completed',
                        'body' => $response[1],
                        'success' => 1,
                        'string_result' => 'банкротства не найдены'
                    );
                } elseif (preg_match("/{$serch_url}/i", $response[1])) {
                    $update = array(
                        'status' => 'completed',
                        'body' => serialize([$response[1]]),
                        'success' => 0,
                        'string_result' => 'банкротства найдены'
                    );
                } else {
                    $update = array(
                        'status' => 'error',
                        'body' => $response[0],
                        'string_result' => 'неудачный парсинг'
                    );
                }
            } else {
                $update = array(
                    'status' => 'error',
                    'string_result' => 'При запросе произошла ошибка'
                );
            }

        }

        if (!empty($update)) {
            $this->scorings->update_scoring($scoring_id, $update);
        }

        return $update;
    }

    public function getting_html($inn)
    {
        try {
            $host = 'http://' . $this->settings->selenoid . ':4444/wd/hub';

            $capabilities = DesiredCapabilities::chrome();

            $driver = RemoteWebDriver::create($host, $capabilities);

            $driver->get('https://bankrot.fedresurs.ru/bankrupts?searchString=' . $inn);


            sleep(4);

            $html = $driver->getPageSource();

            $search = 'Вся информация';

            if (preg_match("/{$search}/i", $html)) {
                $driver->findElement(
                    WebDriverBy::xpath("//span[contains(.,'Вся информация')]")
                )->click();

                sleep(4);
            }

            $HandleCount = $driver->getWindowHandles();

            if (isset($HandleCount[1])) {
                $driver->switchTo()->window($HandleCount[1]);
            }

            $url = $driver->getCurrentURL();
            $driver->quit();

            $response = [$html, $url];
        } catch (Exception $e) {
            $response = [$e->getMessage()];
        }
        return $response;
    }

    public function get_inn($surname, $name, $patronymic, $birthdate, $doctype, $docnumber, $docdate)
    {
        $docnumber_clear = str_replace(array('-', ' '), '', $docnumber);
        $docno = substr($docnumber_clear, 0, 2).' '.substr($docnumber_clear, 2, 2).' '.substr($docnumber_clear, 4, 6);

        $data = array(
            "fam" => $surname,
            "nam" => $name,
            "otch" => $patronymic,
            "bdate" => $birthdate,
            "bplace" => "",
            "doctype" => $doctype,
            "docno" => $docno,
            "docdt" => $docdate,
            "c" => "innMy",
            "captcha" => "",
            "captchaToken" => ""
        );


        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resp = curl_exec($ch);

        return json_decode($resp);
    }
}