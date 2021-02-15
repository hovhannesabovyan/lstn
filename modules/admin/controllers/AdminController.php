<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;

class AdminController extends Controller
{

    public $user_role = '';

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) $this->redirect('/site/login');
        else {
            $this->user_role = yii::$app->user->identity->attributes['role'];
            return parent::beforeAction($action);
        }
    }
}

function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
