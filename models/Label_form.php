<?php


namespace app\models;


use yii\db\ActiveRecord;
use Yii;

class Label_form extends ActiveRecord
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
            [['label_name', 'country', 'twitter', 'website', 'facebook', 'youtube', 'genre', 'compilations_label', 'parent_label'], 'string', 'max' => 255],
            [['biography'], 'string'],
            [['logo'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['label_name', 'email', 'country', 'website', 'genre', 'compilations_label'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
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

    public function upload($id)
    {
        if ($this->validate()) {
            $path = 'image/label/' . $id . '/' . $this->logo->baseName . '.' . $this->logo->extension;
            $this->logo->saveAs($path);
            $this->logo->tempName = $path;
            return true;
        } else {
            return false;
        }
    }
}
