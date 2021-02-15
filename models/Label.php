<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\QueryInterface;
use Yii;

class Label extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_label';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'email'],
            [['label_name', 'country', 'twitter', 'website', 'genre'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'label_name' => Yii::t('app', 'Label Name'),
            'email' => Yii::t('app', 'E-mail'),
            'logo' => Yii::t('app', 'Logo'),
            'country' => Yii::t('app', 'Country'),
            'website' => Yii::t('app', 'Website'),
            'twitter' => Yii::t('app', 'Twitter'),
            'facebook' => Yii::t('app', 'Facebook'),
            'youtube' => Yii::t('app', 'YouTube'),
            'genre' => Yii::t('app', 'Genre'),
            'compilations_label' => Yii::t('app', 'Compilations Label'),
            'parent_label' => Yii::t('app', 'Parent Label'),
            'biography' => Yii::t('app', 'Biography'),
        ];
    }

    public static function getWritableColumns()
    {
        return [
            'label_name',
            'email',
            'country',
            'website',
            'facebook',
            'twitter',
            'youtube',
            'genre',
            'biography',

            'cabinet_id',
            'user_id',
            'logo',
            'compilations_label',
            'parent_label'
        ];
    }

    /**
     * @inheritdoc
     */

    public function search($params)
    {
        $query = self::find()->where(['cabinet_id' => yii::$app->user->identity['cabinet']]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'label_name', 'country', 'genre', 'name', 'email', 'phone_number'
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'label_name', $this->label_name])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'genre', $this->genre]);

        return $dataProvider;

    }
}
