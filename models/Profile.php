<?php

namespace app\models;

use Yii;
use yii\base\Model;


class Profile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tbl_profile';
    }

    public function rules()
    {
        return [
            [['company', 'name', 'surname', 'address', 'city', 'country'], 'string', 'max' => 255],
            [['about_me'], 'string'],
            [['postal_code'], 'string', 'max' => 50],
        ];
    }
}
