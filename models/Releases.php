<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\QueryInterface;
use Yii;

class Releases extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_releases';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'catalog', 'exclusive', 'artist_name', 'title', 'primary_genre'], 'string', 'max' => 255],
            [['create_date'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'create_date' => Yii::t('app', 'Created Date'),
            'status' => Yii::t('app', 'Status'),
            'catalog' => Yii::t('app', 'Catalog'),
            'label' => Yii::t('app', 'Label'),
            'artist_name' => Yii::t('app', 'Artist Name'),
            'title' => Yii::t('app', 'Title'),
            'release_type' => Yii::t('app', 'Release Type'),
            'release_logo' => Yii::t('app', 'Release Logo'),
            'upc_code' => Yii::t('app', 'UPC Code'),
            'ean_code' => Yii::t('app', 'EAN Code'),
            'primary_genre' => Yii::t('app', 'Primary Genre'),
            'sub_genre' => Yii::t('app', 'Sub Genre'),
            'bundle_price' => Yii::t('app', 'Bundle Price'),
            'track_price' => Yii::t('app', 'Track Price'),
            'cover_image' => Yii::t('app', 'Cover Image'),
            'written_by' => Yii::t('app', 'Written By'),
            'published_by' => Yii::t('app', 'Published By'),
            'produced_by' => Yii::t('app', 'Produced By'),
            'language' => Yii::t('app', 'Language'),
            'explicit_lyrics' => Yii::t('app', 'Explicit Lyrics'),
            'explicit_artwork' => Yii::t('app', 'Explicit Artwork'),
            'exclusive' => Yii::t('app', 'Exclusive'),
            'exclusive_date' => Yii::t('app', 'Exclusive Date'),
            'exclusive_store' => Yii::t('app', 'Exclusive Store'),
            'exclusive_period' => Yii::t('app', 'Exclusive Period'),
            'sales_start_date' => Yii::t('app', 'Sales Start Date'),
            'description' => Yii::t('app', 'Description'),
            'territories' => Yii::t('app', 'Territories'),
            'territory_selection' => Yii::t('app', 'Territory Selection'),
        ];
    }

    /**
     * @inheritdoc
     */

    public function search($params)
    {
        $query = self::find()->where(['cabinet_id' => yii::$app->user->identity['cabinet'], 'user_id' => yii::$app->user->identity['id']]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'title', 'status', 'primary_genre', 'create_date', 'exclusive'
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'exclusive', $this->exclusive])
            ->andFilterWhere(['like', 'create_date', $this->create_date])
            ->andFilterWhere(['like', 'primary_genre', $this->primary_genre]);

        return $dataProvider;

    }

    public function getTracks()
    {
        return $this->hasMany(Track_release::className(),['releases_id'=>'id']);
    }
}
