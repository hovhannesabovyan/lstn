<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_release_types".
 *
 * @property int $id
 * @property string|null $name
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class TblReleaseTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_release_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public static function GetAll()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\TblReleaseTypesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\TblReleaseTypesQuery(get_called_class());
    }
}
