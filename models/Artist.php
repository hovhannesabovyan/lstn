<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\QueryInterface;
use Yii;

class Artist extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_artist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'email'],
            [['name', 'first_name', 'last_name', 'website', 'street'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 20],
            [['gender', 'country', 'town', 'building'], 'string', 'max' => 50],
            [['postcode'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'User Name'),
            'email' => Yii::t('app', 'E-mail'),
            'first_name' => Yii::t('app', 'Fist Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'image' => Yii::t('app', 'Image'),
            'gender' => Yii::t('app', 'Gender'),
            'phone_number' => Yii::t('app', 'Phone'),
            'biography' => Yii::t('app', 'Biography'),
            'website' => Yii::t('app', 'Website'),
            'twitter' => Yii::t('app', 'Twitter'),
            'apple_music' => Yii::t('app', 'Apple Music'),
            'soundcloud' => Yii::t('app', 'SoundCloud'),
            'spotify' => Yii::t('app', 'Spotify'),
            'country' => Yii::t('app', 'Country'),
            'town' => Yii::t('app', 'Town'),
            'street' => Yii::t('app', 'Street'),
            'building' => Yii::t('app', 'Building Name / No'),
            'postcode' => Yii::t('app', 'Postcode'),
        ];
    }

    public static function getWritableColumns()
    {
        return [
            'name',
            'email',
            'first_name',
            'last_name',
            'gender',
            'phone_number',
            'biography',
            'website',
            'twitter',
            'apple_music',
            'soundcloud',
            'spotify',
            'country',
            'town',
            'street',
            'building',
            'postcode',
            'cabinet_id',
            'user_id',
            'image'

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
                    'first_name', 'last_name', 'country', 'town', 'name', 'email', 'phone_number'
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'town', $this->town]);

        return $dataProvider;

    }


}
