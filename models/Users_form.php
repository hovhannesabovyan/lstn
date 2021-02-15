<?php


namespace app\models;


use yii\db\ActiveRecord;
use Yii;

class Users_form extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'role'], 'required'],
            [['email'], 'email'],
            [['username'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'User Name'),
            'role' => Yii::t('app', 'Role'),
            'email' => Yii::t('app', 'E-mail'),
        ];
    }
}
