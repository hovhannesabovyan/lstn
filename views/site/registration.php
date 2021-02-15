<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Sign Up');
?>
    <div class="auth-header">
        <h1 class="auth-title"><?= Yii::t('app', 'Sign Up'); ?></h1>
    </div>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\" style=\"color:red;\">{error}</div>",
        'template' => "{input}</div>\n<div class=\"col-lg-8\" style=\"color:red;\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label', 'style' => "min-width: 100px;"],
    ],
]);
?>
    <div class="auth-body">
<? if ($q) { ?>
    <input type="hidden" name="Registration[cabinet]" value="<?= htmlspecialchars($model->cabinet); ?>">
    <input type="hidden" name="Registration[role]" value="<?= htmlspecialchars($model->role); ?>">
<? } ?>
<? if (Yii::$app->session->hasFlash('error_reg_link')) { ?>
    <div class="form-group">
        <div class="col-lg-8" style="color:red;"><p
                    class="help-block help-block-error "><?= Yii::$app->session->getFlash('error_reg_link'); ?></p>
        </div>
    </div>
<? } ?>
    <div class="form-group">
    <label for="loginform-username"><?= Yii::t('app', 'User Name'); ?></label>
    <div class="input-group input-group--custom">
        <div class="input-group-addon"><i class="input-icon input-icon--user"></i></div>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'pattern' => '^[a-zA-Z0-9]+$']) ?>
    </div>
<? if (Yii::$app->session->hasFlash('error_login')) { ?>
    <div class="form-group">
        <div class="col-lg-8" style="color:red;"><p
                    class="help-block help-block-error "><?= Yii::$app->session->getFlash('error_login'); ?></p></div>
    </div>
<? } ?>
    <div class="form-group">
    <label for="loginform-password"><?= Yii::t('app', 'E-mail'); ?></label>
    <div class="input-group input-group--custom">
        <div class="input-group-addon"><i class="input-icon input-icon--mail"></i></div>
        <?= $form->field($model, 'email')->input('email') ?>
    </div>
<? if (Yii::$app->session->hasFlash('error_email')) { ?>
    <div class="form-group">
        <div class="col-lg-8" style="color:red;"><p
                    class="help-block help-block-error "><?= Yii::$app->session->getFlash('error_email'); ?></p></div>
    </div>
<? } ?>
    <div class="form-group">
    <label for="loginform-password"><?= Yii::t('app', 'Password'); ?></label>
    <div class="input-group input-group--custom">
        <div class="input-group-addon"><i class="input-icon input-icon--lock"></i></div>
        <?= $form->field($model, 'password')->passwordInput() ?>
    </div>
    <div class="form-group">
        <label for="loginform-password"><?= Yii::t('app', 'Confirm password'); ?></label>
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="input-icon input-icon--lock"></i></div>
            <?= $form->field($model, 'second_password')->passwordInput() ?>
        </div>
        <? if (Yii::$app->session->hasFlash('error_passwords')) { ?>
            <div class="form-group">
                <div class="col-lg-8" style="color:red;"><p
                            class="help-block help-block-error "><?= Yii::$app->session->getFlash('error_passwords'); ?></p>
                </div>
            </div>
        <? } ?>

        <div class="form-group form_group">
            <?= Html::submitButton(Yii::t('app', 'Sign Up'), ['class' => 'btn btn-primary btn-block btn-spinner', 'name' => 'login-button']) ?>
        </div>
        <div class="form-group form_group text-center">
            <a href="<?= \yii\helpers\Url::to(['/site/login']) ?>"
               class="auth-ghost-link"><?= Yii::t('app', 'Login'); ?></a>
        </div>
        <div class="form-group form_group text-center">
            <a href="<?= \yii\helpers\Url::to(['/site/reset']) ?>"
               class="auth-ghost-link"><?= Yii::t('app', 'Forgot your password?'); ?></a>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?= app\modules\languages\widgets\ListWidget::widget() ?>

<?
if (Yii::$app->session->hasFlash('error_login')) {
    $js = <<<JS
        $('.field-registration-username').addClass('has-error');
JS;
    $this->registerJs($js);
}
if (Yii::$app->session->hasFlash('error_email')) {
    $js = <<<JS
        $('.field-registration-email').addClass('has-error');
JS;
    $this->registerJs($js);
}
if (Yii::$app->session->hasFlash('error_passwords')) {
    $js = <<<JS
        $('.field-registration-password').addClass('has-error');
        $('.field-registration-second_password').addClass('has-error');
JS;
    $this->registerJs($js);
}
?>
