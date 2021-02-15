<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\ActiveDataProvider;
use \yii\db\Query;

class Tax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_tax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['percentage'], 'double'],
            [['name', 'percentage'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Title',
            'square_id' => 'Square id',
            'is_deleted' => 'Published',
            'percentage' => 'Percentage',
        ];
    }
}
