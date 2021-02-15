<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string $name
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name','name_en'], 'string', 'max' => 255],
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
            'name_en' => Yii::t('app', 'Name'),
        ];
    }

    public static function AllGenre()
    {
        if (Yii::$app->language==='en') {
            return ArrayHelper::map(self::find()->asArray()->all(),'name_en','name_en');
        }else{
            return ArrayHelper::map(self::find()->asArray()->all(),'name','name');
        }

    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\GenreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\GenreQuery(get_called_class());
    }
}
