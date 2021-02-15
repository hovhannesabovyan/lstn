<?php


namespace app\models;

use Yii;

class Registration extends \yii\db\ActiveRecord
{
    public $second_password;

    public static function tableName()
    {
        return 'tbl_users';
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'User Name'),
            'email' => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Password'),
            'second_password' => Yii::t('app', 'Confirm password'),
        ];
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'second_password'], 'required'],
            [['username', 'password', 'second_password'], 'string'],
            [['email'], 'email', 'message' => Yii::t('app', 'Incorrectly entered data in the field E-mail')],
            [['del'], 'integer'],
        ];
    }

}
