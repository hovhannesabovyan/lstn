<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
?>
    <div class="auth-header">
        <h1 class="auth-title"><?= Yii::t('app', 'Login'); ?></h1>
    </div>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\" style=\"color:red;\">{error}</div>",
        'template' => "{input}</div>\n<div class=\"col-lg-8\" style=\"color:red;\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label', 'style' => "min-width: 100px;"],
    ],
]); ?>
    <div class="auth-body">
    <div class="form-group">
    <label for="loginform-username"><?= Yii::t('app', 'User Name'); ?></label>
    <div class="input-group input-group--custom">
        <div class="input-group-addon"><i class="input-icon input-icon--user"></i></div>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    </div>
    <div class="form-group">
        <label for="loginform-password"><?= Yii::t('app', 'Password'); ?></label>
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="input-icon input-icon--lock"></i></div>
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\" style='display: flex;'>{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group form_group">
            <?= Html::submitButton(Yii::t('app', 'Sign In'), ['class' => 'btn btn-primary btn-block btn-spinner', 'name' => 'login-button']) ?>
        </div>
        <div class="form-group form_group text-center">
            <a href="<?= \yii\helpers\Url::to(['/site/reset']) ?>"
               class="auth-ghost-link"><?= Yii::t('app', 'Forgot your password?'); ?></a>
        </div>
        <div class="form-group form_group text-center">
            <a href="<?= \yii\helpers\Url::to(['/site/registration']) ?>"
               class="auth-ghost-link"><?= Yii::t('app', 'Sign Up'); ?></a>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?= app\modules\languages\widgets\ListWidget::widget() ?>
