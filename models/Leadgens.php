<?php

class Leadgens extends Core
{
    public function send_pending_postback($click_id, $sub_id)
    {
        $this->send_pending_postback_leadcraft($click_id, $sub_id);
    }

    public function send_approved_postback($click_id, $sub_id, $order_id)
    {
        $this->send_approved_postback_leadcraft($click_id, $sub_id, $order_id);
    }

    public function send_cancelled_postback($click_id, $sub_id, $order_id)
    {
        $this->send_cancelled_postback_leadcraft($click_id, $sub_id, $order_id);
    }

    public function send_pending_postback_leadcraft($click_id, $sub_id)
    {
        //?utm_source=leadcraft&wm_id=3a110c07-53aa-4a31-a807-7c8b002f4602&clickid=557700e6-6cd4-4e6f-8e95-f229c498e5f6

        //https://api.leadcraft.ru/v1/advertisers/actions?token=421d8f9cb297854371a4b4371fd2413d4a1a0c5bdc7ba681687d60545c7e30d5&actionID=274&status=pending&clickID=[ID КЛИКА]&advertiserID=[ВАШ ID]&reviseDate=[ВАША ДАТА]&price=0
        $reviseDate = date("Y-m-d");
        $link_lead = 'https://api.leadcraft.ru/v1/advertisers/actions?token=421d8f9cb297854371a4b4371fd2413d4a1a0c5bdc7ba681687d60545c7e30d5&actionID=274&status=pending&clickID=' . $click_id . '&advertiserID=' . $sub_id . '&reviseDate=' . $reviseDate;

        $ch = curl_init($link_lead);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        file_put_contents($this->config->root_dir . 'logs/leadcraft.txt', date('d-m-Y H:i:s') . ' pending' . PHP_EOL . $link_lead . PHP_EOL . PHP_EOL . var_export($res) . PHP_EOL . PHP_EOL, FILE_APPEND);
        //$this->logging(__METHOD__, 'account_view_zayavka', $link_lead, $res, 'leadcraft.txt');
    }

    public function send_approved_postback_leadcraft($click_id, $sub_id, $order_id)
    {
        $counter = 1;

        $file = 'logs/lead_counter.txt';

        if (file_exists($file)) {
            $counter += file_get_contents($file);
        }

        file_put_contents($file, $counter);
        $reviseDate = date("Y-m-d");
        $link_lead = 'https://api.leadcraft.ru/v1/advertisers/actions?token=421d8f9cb297854371a4b4371fd2413d4a1a0c5bdc7ba681687d60545c7e30d5&actionID=274&status=approved&clickID=' . $click_id . '&advertiserID=' . $sub_id . '&reviseDate=' . $reviseDate;

        $ch = curl_init($link_lead);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        file_put_contents($this->config->root_dir . 'logs/leadcraft.txt', date('d-m-Y H:i:s') . ' approved ' . $counter . PHP_EOL . $link_lead . PHP_EOL . PHP_EOL . var_export($res) . PHP_EOL . PHP_EOL, FILE_APPEND);
        //$this->logging(__METHOD__, 'account_view_zayavka', $link_lead, $res, 'leadcraft.txt');

        $this->orders->update_order($order_id, array('leadcraft_postback_date' => date('Y-m-d H:i'), 'leadcraft_postback_type' => 'approved'));
    }

    public function send_cancelled_postback_leadcraft($click_id, $sub_id, $order_id)
    {
        //https://api.leadcraft.ru/v1/advertisers/actions?token=421d8f9cb297854371a4b4371fd2413d4a1a0c5bdc7ba681687d60545c7e30d5&actionID=274&status=cancelled&clickID=[ID КЛИКА]&advertiserID=[ВАШ ID]&reviseDate=[ВАША ДАТА]

        $reviseDate = date("Y-m-d");
        $link_lead = 'https://api.leadcraft.ru/v1/advertisers/actions?token=421d8f9cb297854371a4b4371fd2413d4a1a0c5bdc7ba681687d60545c7e30d5&actionID=274&status=cancelled&clickID=' . $click_id . '&advertiserID=' . $sub_id . '&reviseDate=' . $reviseDate;

        $ch = curl_init($link_lead);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        file_put_contents($this->config->root_dir . 'logs/leadcraft.txt', date('d-m-Y H:i:s') . ' cancelled' . PHP_EOL . $link_lead . PHP_EOL . PHP_EOL . var_export($res) . PHP_EOL . PHP_EOL, FILE_APPEND);
        //$this->logging(__METHOD__, 'account_view_zayavka', $link_lead, $res, 'leadcraft.txt');

        $this->orders->update_order($order_id, array('leadcraft_postback_date' => date('Y-m-d H:i'), 'leadcraft_postback_type' => 'cancelled'));
    }

    public function send_pending_postback_bankiru($order)
    {

        $base_link = 'http://tracking.banki.ru/SP2IS';
        $link_lead = $base_link . '?transaction_id=' . $order->click_hash . '&adv_sub=' . $order->id_1c;

        $ch = curl_init($link_lead);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        //TODO: логирование
    }

    public function send_approved_postback_bankiru($order_id, $order)
    {
        $counter = 1;

        var_dump($order_id);
        var_dump($order);

        $file = 'logs/lead_banki_counter.txt';

        if (file_exists($file)) {
            $counter += file_get_contents($file);
        }

        file_put_contents($file, $counter);
        $base_link = 'http://tracking.banki.ru/GP2Ii';
        $link_lead = $base_link . '?transaction_id=' . $order->click_hash . '&adv_sub=' . $order->id_1c;

        $ch = curl_init($link_lead);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        var_dump($ch);

        $result = $this->orders->update_order($order_id, array('leadcraft_postback_date' => date('Y-m-d H:i'), 'leadcraft_postback_type' => 'approved'));

        var_dump($result);

        //file_put_contents($this->config->root_dir.'logs/lead_bankiru.txt', date('d-m-Y H:i:s').' approved '.$counter.PHP_EOL.$link_lead.PHP_EOL.PHP_EOL.var_export($res).PHP_EOL.PHP_EOL, FILE_APPEND);

        //логирование (больше информации)
        $this->to_log(__METHOD__, 'approved', $link_lead, $res, 'lead_bankiru.txt');

    }

    public function send_cancelled_postback_bankiru($order_id, $order)
    {
        $base_link = 'http://tracking.banki.ru/GP2Il';
        $link_lead = $base_link . '?transaction_id=' . $order->click_hash . '&adv_sub=' . $order->id_1c;

        $ch = curl_init($link_lead);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        $this->orders->update_order($order_id, array('leadcraft_postback_date' => date('Y-m-d H:i'), 'leadcraft_postback_type' => 'cancelled'));

        //file_put_contents($this->config->root_dir.'logs/lead_bankiru.txt', date('d-m-Y H:i:s').' cancelled'.PHP_EOL.$link_lead.PHP_EOL.PHP_EOL.var_export($res).PHP_EOL.PHP_EOL, FILE_APPEND);
        //$this->logging(__METHOD__, 'account_view_zayavka', $link_lead, $res, 'leadcraft.txt');

        //логирование (больше информации)
        $this->to_log(__METHOD__, 'cancelled', $link_lead, $res, 'lead_bankiru.txt');
    }

    public function send_pending_postback_click2money($order)
    {

        $base_link = 'https://c2mpbtrck.com/cpaCallback';
        $link_lead = $base_link . '?cid=' . $order->click_hash . '&action=hold&partner=finfive&lead_id=' . $order->id_1c;

        $ch = curl_init($link_lead);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        $this->to_log(__METHOD__, 'hold', $link_lead, $res, 'lead_click2money.txt');
    }

    public function send_approved_postback_click2money($order_id, $order)
    {
        $counter = 1;

        $file = 'logs/lead_click2money_counter.txt';

        var_dump($order_id);
        var_dump($order);

        if (file_exists($file)) {
            $counter += file_get_contents($file);
        }

        file_put_contents($file, $counter);
        $base_link = 'https://c2mpbtrck.com/cpaCallback';
        $link_lead = $base_link . '?cid=' . $order->click_hash . '&action=approve&partner=finfive&lead_id=' . $order->id_1c;

        $ch = curl_init($link_lead);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        var_dump($ch);

        $result = $this->orders->update_order($order_id, array('leadcraft_postback_date' => date('Y-m-d H:i'), 'leadcraft_postback_type' => 'approved'));

        var_dump($result);

        //логирование
        $this->to_log(__METHOD__, 'approved', $link_lead, $res, 'lead_click2money.txt');

    }

    public function send_cancelled_postback_click2money($order_id, $order)
    {
        $base_link = 'https://c2mpbtrck.com/cpaCallback';
        $link_lead = $base_link . '?cid=' . $order->click_hash . '&action=reject&partner=finfive&lead_id=' . $order->id_1c;

        $ch = curl_init($link_lead);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        $this->orders->update_order($order_id, array('leadcraft_postback_date' => date('Y-m-d H:i'), 'leadcraft_postback_type' => 'cancelled'));

        //логирование (больше информации)
        $this->to_log(__METHOD__, 'cancelled', $link_lead, $res, 'lead_click2money.txt');
    }

    public function to_log($method, $url, $request, $response, $log_filename = 'leads.txt')
    {
        $log = 1; // 1 - включить логирование, 0 - выключить

        if (empty($log))
            return false;

        $filename = $this->config->root_dir . 'logs/' . $log_filename;

        if (date('d', filemtime($filename)) != date('d')) {
            $file_basename = pathinfo($log_filename, PATHINFO_BASENAME);
            $archive_filename = $this->config->root_dir . 'logs/archive/' . $file_basename . '_' . date('ymd', filemtime($filename));
            rename($filename, $archive_filename);
            file_put_contents($filename, "\xEF\xBB\xBF");
        }


        $string = '';
        $string .= PHP_EOL . '******************************************************' . PHP_EOL;
        $string .= date('d.m.Y H:i:s') . PHP_EOL;
        $string .= $method . PHP_EOL;
        $string .= $url . PHP_EOL;

        if (!empty($_SERVER['REMOTE_ADDR']))
            $string .= PHP_EOL . 'IP: ' . $_SERVER['REMOTE_ADDR'];
        if (!empty($_SESSION['referer']))
            $string .= PHP_EOL . 'SESSION_REFERER: ' . $_SESSION['referer'];
        if (isset($_SERVER['HTTP_REFERER']))
            $string .= PHP_EOL . 'REFERER: ' . $_SERVER['HTTP_REFERER'] . PHP_EOL;
        if (isset($_SESSION['admin']))
            $string .= PHP_EOL . 'IS_ADMIN: ' . PHP_EOL;

        $string .= PHP_EOL . 'REQUEST:' . PHP_EOL;
        if (is_array($request) || is_object($request)) {
            foreach ($request as $rkey => $ritem) {
                if (is_array($ritem) || is_object($ritem)) {

                    $string .= $rkey . ' => (' . PHP_EOL;
                    foreach ($ritem as $subrkey => $subritem)
                        $string .= '    ' . $subrkey . ' => ' . strval($subritem) . PHP_EOL;

                    $string .= ')' . PHP_EOL;
                } else {
                    $string .= $rkey . ' => ' . $ritem . PHP_EOL;
                }
            }
        } else {
            $string .= $request . PHP_EOL;
        }

        $string .= PHP_EOL . 'RESPONSE:' . PHP_EOL;
        if (is_array($response) || is_object($response)) {
            foreach ($response as $key => $item) {
                if (is_array($item) || is_object($item)) {
                    $string .= $key . ' => (' . PHP_EOL;
                    foreach ($item as $subkey => $subitem) {
                        if (is_array($subitem) || is_object($subitem)) {
                            $string .= '    ' . $subkey . ' => (' . PHP_EOL;
                            foreach ($subitem as $subsubkey => $subsubitem)
                                @$string .= '        ' . $subsubkey . ' => ' . strval($subsubitem) . PHP_EOL;

                            $string .= '    )' . PHP_EOL;
                        } else {
                            $string .= '    ' . $subkey . ' => ' . strval($subitem) . PHP_EOL;
                        }
                    }
                    $string .= ')' . PHP_EOL;
                } else {
                    $string .= $key . ' => ' . $item . PHP_EOL;
                }
            }
        } else {
            $string .= $response . PHP_EOL;
        }


        $string .= PHP_EOL . 'END' . PHP_EOL;
        $string .= PHP_EOL . '******************************************************' . PHP_EOL;

        file_put_contents($filename, $string, FILE_APPEND);
    }
}
