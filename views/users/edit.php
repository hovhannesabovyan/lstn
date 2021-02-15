<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Role;
use kartik\select2\Select2;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Edit user profile'); ?>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('app', 'Back'), yii\helpers\Url::to(['users/index'])); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title"><?= Yii::t('app', 'Edit Profile'); ?></h4>
                <p class="card-category"><?= Yii::t('app', 'Complete your profile'); ?></p>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => "{input}\n<div class=\"col-lg-8\" style=\"color:red;\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-1 control-label', 'style' => "min-width: 100px;"],
                    ],
                ]); ?>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Company'); ?></label>
                            <input type="text" name="Profile[company]" class="form-control"
                                   value="<?= $model->company; ?>">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Email address'); ?></label>
                            <input type="email" disabled value="<?= $user->email; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Fist Name'); ?></label>
                            <input type="text" name="Profile[name]" class="form-control" value="<?= $model->name; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Last Name'); ?></label>
                            <input type="text" name="Profile[surname]" class="form-control"
                                   value="<?= $model->surname; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Address'); ?></label>
                            <input type="text" name="Profile[address]" class="form-control"
                                   value="<?= $model->address; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'City'); ?></label>
                            <input type="text" name="Profile[city]" class="form-control" value="<?= $model->city; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Country'); ?></label>
                            <input type="text" name="Profile[country]" class="form-control"
                                   value="<?= $model->country; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Postal Code'); ?></label>
                            <input type="text" name="Profile[postal_code]" class="form-control"
                                   value="<?= $model->postal_code; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= Yii::t('app', 'About Me'); ?></label>
                            <div class="form-group">
                                <label class="bmd-label-floating"><?= Yii::t('app', 'Tell us about yourself!'); ?></label>
                                <textarea name="Profile[about_me]" class="form-control"
                                          rows="5"><?= $model->about_me; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'User Name'); ?></label>
                            <input type="text" disabled class="form-control" value="<?= $user->username; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Role'); ?></label>
                            <?= $form->field($user, 'role')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Role::find()->all(), 'id', 'role'),
                                'language' => 'en',
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
                <button type="submit"
                        class="btn btn-primary pull-right"><?= Yii::t('app', 'Update Profile'); ?></button>
                <div class="clearfix"></div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
