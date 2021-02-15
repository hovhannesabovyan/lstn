<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Role;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Create User'); ?>

<div class="row">
    <div class="col-md-12">
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('app', 'Back'), yii\helpers\Url::to(['users/index'])); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldConfig' => [
                        'template' => "{input}\n<div class=\"col-lg-8\" style=\"color:red;\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-1 control-label', 'style' => "min-width: 100px;"],
                    ],
                ]);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="loginform-username"><?= Yii::t('app', 'User Name'); ?></label>
                            <div class="form-group">
                                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'autocomplete' => 'off', 'pattern' => '^[a-zA-Z0-9]+$']) ?>
                            </div>
                        </div>
                        <? if (Yii::$app->session->hasFlash('error_login')) { ?>
                            <div class="form-group">
                                <div class="col-lg-8" style="color:red;"><p
                                            class="help-block help-block-error "><?= Yii::$app->session->getFlash('error_login'); ?></p>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="loginform-username"><?= Yii::t('app', 'E-mail'); ?></label>
                            <div class="form-group">
                                <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off']) ?>
                            </div>
                        </div>
                        <? if (Yii::$app->session->hasFlash('error_email')) { ?>
                            <div class="form-group">
                                <div class="col-lg-8" style="color:red;"><p
                                            class="help-block help-block-error "><?= Yii::$app->session->getFlash('error_email'); ?></p>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="loginform-username"><?= Yii::t('app', 'Role'); ?></label>
                            <div class="form-group">
                                <?= $form->field($model, 'role')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Role::find()->all(), 'id', 'role'),
                                    'language' => 'de',
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary pull-right"><?= Yii::t('app', 'Register'); ?></button>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
