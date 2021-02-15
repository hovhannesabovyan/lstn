<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use \yii\base\ErrorException;
use yii\web\IdentityInterface;
use \yii\base\BaseObject;

class User extends ActiveRecord implements IdentityInterface
{

    public $profile;

    /**
     * с какой таблицей будем работать
     */
    public static function tableName()
    {
        return 'tbl_users';
    }

    public static function findIdentity($id)
    {

        if (Yii::$app->getSession()->has('user-' . $id)) {
            return new self(Yii::$app->getSession()->get('user-' . $id));
        } else {
            return static::findOne($id);
        }


    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',

        ];
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        # return $this->password === $password;

        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function generateAuthKey()
    {
        $this->authKey = \Yii::$app->security->generateRandomString();
    }

}
