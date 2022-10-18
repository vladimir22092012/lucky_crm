<?php

class YandexMetrik extends Core
{
    private $token;
    private $ids; //номер счетчика
    private $params;
    private $date1;
    private $date2;
    private $res;

    public function __construct()
    {
    	parent::__construct();

        $this->token = 'AQAAAAAQAlkcAAfSB5x-OyP-zkqTlKLAyicpmNI';
        $this->ids = '78433342';
        $this->date1 = 'today';  // 7daysAgo - неделя, 30daysAgo - месяц, 365daysAgo - год
        $this->date2 = 'today';

    }

    public function getData($date1, $date2)
    {
        $this->date1 = $date1;
        $this->date2 = $date2;

        $this->sendRequest();

        return $this->res;
    }

    public function sendRequest()
    {
        $this->params = array(
            'ids'     => $this->ids,
            'metrics' => 'ym:s:visits,ym:s:users',
            'date1'   => $this->date1,
            'date2'   => $this->date2,
            'preset'   => 'tags_u_t_m',
            'group'   => 'day',
            'dimensions'   => 'ym:s:lastSignUTMSource',
        );

		$ch = curl_init('https://api-metrika.yandex.net/stat/v1/data/bytime?' . urldecode(http_build_query($this->params)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($res, true);
        $this->res = $res;
    }

}