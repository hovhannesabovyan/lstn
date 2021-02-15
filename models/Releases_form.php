<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\QueryInterface;
use Yii;

class Releases_form extends ActiveRecord
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
            [['status', 'catalog', 'exclusive', 'title', 'upc_code', 'ean_code', 'sub_genre', 'published_by', 'produced_by', 'language', 'exclusive_store',
                'exclusive_period', 'previously_released'], 'string', 'max' => 255],
            [['artist_name'], 'safe'],
            [['bundle_price'], 'double'],
            [['create_date', 'exclusive_date', 'sales_start_date', 'description', 'territories'], 'string'],
            [['label', 'artist_name', 'title', 'release_type', 'primary_genre', 'bundle_price',
                'explicit_lyrics', 'explicit_artwork', 'exclusive', 'sales_start_date'], 'required'],
            [['release_logo'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['cover_image'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['author_name', 'author_lastname'], 'string', 'max' => 255],
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

            'cover_image' => Yii::t('app', 'Cover Image'),

            'published_by' => Yii::t('app', 'Published By'),
            'produced_by' => Yii::t('app', 'Produced By'),
            'author_name' => Yii::t('app', 'Firstname'),
            'author_lastname' => Yii::t('app', 'Lastname'),
            'language' => Yii::t('app', 'Language'),
            'explicit_lyrics' => Yii::t('app', 'Explicit Lyrics'),
            'explicit_artwork' => Yii::t('app', 'Explicit Artwork'),
            'exclusive' => Yii::t('app', 'Exclusive'),
            'exclusive_date' => Yii::t('app', 'Exclusive Date'),
            'exclusive_store' => Yii::t('app', 'Exclusive Store'),
            'exclusive_period' => Yii::t('app', 'Exclusive Period'),
            'sales_start_date' => Yii::t('app', 'Sales Start Date'),
            'previously_released' => Yii::t('app', 'Previously Released?'),
            'description' => Yii::t('app', 'Description'),
            'territories' => Yii::t('app', 'Territories'),
            'territory_selection' => Yii::t('app', 'Territory Selection'),
        ];
    }

    public function upload($id)
    {
        if ($this->validate()) {
            $path = 'image/releases/' . $id . '/' . $this->release_logo->baseName . '.' . $this->release_logo->extension;
            $this->release_logo->saveAs($path);
            $this->release_logo->tempName = $path;
            return true;
        } else {
            return false;
        }
    }

    public function upload2($id)
    {
        if ($this->validate()) {
            $path = 'image/releases/' . $id . '/' . $this->cover_image->baseName . '.' . $this->cover_image->extension;
            $this->cover_image->saveAs($path);
            $this->cover_image->tempName = $path;
            return true;
        } else {
            return false;
        }
    }

    public function getTracks()
    {
        return $this->hasMany(Track_release::className(), ['releases_id' => 'id']);
    }
}
