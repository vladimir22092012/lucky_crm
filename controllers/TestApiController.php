<?php

set_time_limit(300);

class TestApiController extends Controller
{
    public function fetch()
    {
        //var_dump(111111111111111111);
        //$res = $this->YandexMetrik->getData('today', 'today');
        $res = $this->YandexMetrik->getData('2022-04-05', 'today');
        var_dump($res);
        //$order = $this->orders->get_order(216039);
        //$this->leadgens->send_approved_postback_bankiru(216039, $order);
        /*$arrayApprove = [216291];

        $arrayCancell = [216277,
216253,
216249,
216285,
216342,
216248,
216378,
216377,
216371,
216370,
216368,
216364,
216357,
216353,
216351,
216340,
216339,
216338,
216337,
216332,
216329,
216327,
216314,
216307,
216304,
216298,
216297,
216296,
216295,
216294,
216283,
216271,
216270,
216269,
216268,
216266,
216265,
216264,
216263,
216259,
216257,
216256,
216255,
216252,
216246,
216244,
216242,
216241,
216240,
216237,
216236,
216235,
216234,
216232,
216227,
216224,
216223,
216222,
216221,
216219,
216217,
216215,
216214,
216211,
216207,
216206,
216205,
216204,
216203,
216196,
216195,
216194,
216192,
216191,
216188,
216187,
216185,
216181,
216179,
216178,
216176,
216175,
216174,
216173,
216167];

        foreach ($arrayApprove as $key => $value) {
            $order = $this->orders->get_order($value);
            $this->leadgens->send_approved_postback_bankiru($value, $order);
        }

        foreach ($arrayCancell as $key => $value) {
            $order = $this->orders->get_order($value);
            $this->leadgens->send_cancelled_postback_bankiru($value, $order);
        }*/
    }

    private function send()
    {
        $token = 'AQAAAAAQAlkcAAfSB5x-OyP-zkqTlKLAyicpmNI';
 
        $params = array(
            'ids'     => '78433342', 
            'metrics' => 'ym:s:visits,ym:s:users',
            'date1'   => 'today', // 7daysAgo - неделя, 30daysAgo - месяц, 365daysAgo - год
            'date2'   => 'today',
            'preset'   => 'tags_u_t_m',
            'dimensions'   => 'ym:s:lastSignUTMSource',
        );
         
        $ch = curl_init('https://api-metrika.yandex.net/stat/v1/data/bytime?' . urldecode(http_build_query($params)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
         
        $res = json_decode($res, true); 
        print_r($res);
         
        /*// Визиты   
        echo $res['totals'][0][0];
         
        // Просмотры    
        echo $res['totals'][0][1];
         
        // Посетители   
        echo $res['totals'][0][2];
         
        // Отказы, %
        echo $res['totals'][0][3];
         
        // Глубина просмотра    
        echo $res['totals'][0][4];
         
        // Время на сайте, сек.
        echo $res['totals'][0][5];*/
    }

}