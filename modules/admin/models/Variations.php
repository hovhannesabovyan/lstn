<?php


namespace app\modules\admin\models;


use yii\db\ActiveRecord;

class Variations extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tbl_variations';
    }
}
