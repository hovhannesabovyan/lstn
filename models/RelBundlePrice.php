<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rel_bundle_price".
 *
 * @property int $id
 * @property int|null $rel_id
 * @property int|null $sum
 */
class RelBundlePrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rel_bundle_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rel_id', 'sum'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'rel_id' => Yii::t('app', 'Rel ID'),
            'sum' => Yii::t('app', 'Sum'),
        ];
    }

    public static function GetAllSum()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'sum', 'sum');
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\RelBundlePriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\RelBundlePriceQuery(get_called_class());
    }
}
