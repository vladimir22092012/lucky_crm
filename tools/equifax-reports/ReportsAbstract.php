<?php

abstract class ReportsAbstract implements ToolsInterface
{
    abstract static function processing($data);

    protected static function sendFile($file)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://51.250.97.26/send/history',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('file' => new CURLFILE($file)),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    protected static function deleteDir($path)
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

    protected static function logging($log)
    {
        EquifaxReports::insert($log);

        return 'success';
    }

    public static function checkUploads($date = '')
    {
        $curl = curl_init();

        $period = !empty($date) ? '?day=' . date('d.m.Y', strtotime($date)) : '';

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://51.250.97.26/report/result' . $period,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        curl_close($curl);

        echo '<pre>';
        print_r($response);
    }
}