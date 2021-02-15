<?php


namespace app\models;


use yii\db\ActiveRecord;
use Yii;

class Artist_form extends ActiveRecord
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
            [['name', 'first_name', 'last_name', 'website', 'twitter', 'apple_music', 'soundcloud', 'spotify', 'street'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 20],
            [['gender', 'country', 'town', 'building'], 'string', 'max' => 50],
            [['biography'], 'string'],
            [['postcode'], 'integer'],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['name', 'email', 'first_name', 'last_name', 'gender', 'phone_number', 'country', 'town', 'building', 'street', 'postcode'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
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

    public function upload($id)
    {
        if ($this->validate()) {
            $path = 'image/artist/' . $id . '/' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($path);
            $this->image->tempName = $path;
            return true;
        } else {
            return false;
        }
    }
}
