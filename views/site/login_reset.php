<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Restore password');
?>
    <div class="auth-header">
        <h1 class="auth-title"><?= Yii::t('app', 'Restore password'); ?></h1>
    </div>

<?php $form = ActiveForm::begin([
    'id' => 'reset-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\" style=\"color:red;\">{error}</div>",
        'template' => "{input}</div>\n<div class=\"col-lg-8\" style=\"color:red;\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label', 'style' => "min-width: 100px;"],
    ],
]); ?>
    <div class="auth-body">
        <div class="form-group" style="margin-bottom: 1.7em;">
            <label for="login_reset"><?= Yii::t('app', 'User Name'); ?></label>
            <div class="input-group input-group--custom">
                <div class="input-group-addon"><i class="input-icon input-icon--user"></i></div>
                <input type="text" id="login_reset" value="<?= $model->username; ?>"
                       class="form-control" name="Reset[username]" autofocus="" aria-invalid="false">
            </div>
            <? if (Yii::$app->session->hasFlash('error_username')) { ?>
                <div class="col-lg-8" style="color:red;"><?= Yii::$app->session->getFlash('error_username');; ?></div>
            <?
            } ?>
            <?//= $form->field($model, 'username')->textInput(['autofocus' => true, 'id'=>'login_reset', 'class'=>'form-control']) ?>
        </div>
        <div style="text-align: center;"><label>- <?= Yii::t('app', 'or'); ?> -</label></div>
        <div class="form-group" style="margin-bottom: 1.7em;">
            <label for="email_reset"><?= Yii::t('app', 'E-mail'); ?></label>
            <div class="input-group input-group--custom">
                <div class="input-group-addon"><i class="input-icon input-icon--mail"></i></div>
                <input type="text" id="email_reset" value="<?= $model->email; ?>" class="form-control"
                       name="Reset[email]" aria-invalid="true">
                <?//= $form->field($model, 'email')->textInput(['id'=>'email_reset', 'class'=>'form-control']) ?>
            </div>
            <? if (Yii::$app->session->hasFlash('error_email')) { ?>
                <div class="col-lg-8" style="color:red;"><?= Yii::$app->session->getFlash('error_email'); ?></div>
            <?
            } ?>
        </div>
        <div class="form-group form_group">
            <?= Html::submitButton(Yii::t('app', 'Restore password'), ['class' => 'btn btn-primary btn-block btn-spinner', 'name' => 'login-button']) ?>
        </div>
        <div class="form-group form_group text-center">
            <a href="<?= \yii\helpers\Url::to(['/site/login']) ?>"
               class="auth-ghost-link"><?= Yii::t('app', 'Sign In'); ?></a>
        </div>
        <div class="form-group form_group text-center">
            <a href="<?= \yii\helpers\Url::to(['/site/registration']) ?>"
               class="auth-ghost-link"><?= Yii::t('app', 'Sign Up'); ?></a>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?= app\modules\languages\widgets\ListWidget::widget() ?>

<?php
$js = <<<JS
    var login_reset = document.getElementById('login_reset').value,
        email_reset = document.getElementById('email_reset').value;

    if (login_reset){
        $('#email_reset').prop("disabled", true);
    }
    if (email_reset){
        $('#login_reset').prop("disabled", true);
    }
JS;
$this->registerJs($js);

$this->registerJsFile('https://cdn.polyfill.io/v2/polyfill.min.js', [
    'position' => yii\web\View::POS_END,
    'depends' => [
        'yii\web\YiiAsset'
    ]]);
