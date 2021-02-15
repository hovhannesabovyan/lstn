<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\ActiveDataProvider;
use \yii\db\Query;

class Readers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_readers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration_code', 'label', 'id_location'], 'required'],
            [['registration_code', 'label', 'id_location', 'id_stripe'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'label' => 'Title',
            'registration_code' => 'Registration Code',
            'id_location' => 'Location',
        ];
    }
}
