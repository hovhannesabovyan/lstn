<?php

namespace app\components;

use http\Url;
use SebastianBergmann\CodeCoverage\TestFixture\C;
use yii\base\Component;
use app\models\Releases;
use yii\helpers\Json;
use yii\web\NotAcceptableHttpException;

class Common extends Component
{
    public static function checkTrackCount($release_id)
    {
        if ($release_id) {
            $rel = Releases::find()->where(['release_type' => $release_id]);
            Common::Debug($rel);
        } else {
            throw new NotAcceptableHttpException('Id not found');
        }
    }


    public static function Debug($arr)
    {
        echo "<pre>" . print_r($arr, true) . "</pre>";
    }


    public static function CheckTrack($url_t)
    {
        $curl = curl_init();

        $url_1 = 'https://lstn.web-devel.ru/' . $url_t;

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.righters.pro/check/music',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"key":"vTMHhJ0921eOQYQyIEEu9JHJpc","url":"' . $url_1 . '","meta":{"some":"meta"}}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            )
        ));

        $response = curl_exec($curl);

        curl_close($curl);
       return $response;

    }

}
