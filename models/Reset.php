<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Reset extends Model
{
    public $username;
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username'], 'string'],
            [['email'], 'email', 'message' => Yii::t('app', 'Incorrectly entered data in the field E-mail')],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'User Name'),
            'email' => Yii::t('app', 'E-mail'),
        ];
    }
}
