<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\ActiveDataProvider;
use \yii\db\Query;

class Location_reader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_location_reader';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['postal_code'], 'integer'],
            [['name', 'line1', 'city', 'state', 'country'], 'required'],
            [['name', 'line1', 'city', 'state', 'country', 'id_stripe'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Title',
            'line1' => 'Street',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'postal_code' => 'Postal Code',
        ];
    }
}
