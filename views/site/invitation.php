<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Invite members');
?>
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('app', 'Back'), yii\helpers\Url::to(['users/index'])); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= Yii::t('app', 'Invite members to a team'); ?></h4>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <input type="hidden" name="variations" value="">
                    <input type="hidden" id="edit_mass" value="">
                    <input type="hidden" id="lang" value="<?= $lang[Yii::$app->language]; ?>">
                    <input type="hidden" id="edit" value="<?= Yii::t('app', 'Edit'); ?>">
                    <input type="hidden" id="remove" value="<?= Yii::t('app', 'Remove'); ?>">
                    <div style="overflow: auto;">
                        <table style="width: 100%;min-width: 550px;border: 5px solid white;">
                            <thead>
                            <tr>
                                <th><label><?= Yii::t('app', 'E-mail'); ?></label></th>
                                <th><label><?= Yii::t('app', 'Role'); ?></label></th>
                                <th><label><?= Yii::t('app', 'Message Language'); ?></label></th>
                                <th></th>
                            </tr>
                            <tr id="tr_add" data-id="">
                                <td><input type="text" class="form-control" style="height: 41px;" id="email"
                                           name="email" maxlength="255" value=""></td>
                                <td>
                                    <select class="form-control" name="role">
                                        <option value=""></option>
                                        <? foreach ($role as $value) { ?>
                                            <option value="<?= $value['role']; ?>"><?= $value['role']; ?></option>
                                        <? } ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="language">
                                        <option value="<?= $lang[Yii::$app->language]; ?>"><?= $lang[Yii::$app->language]; ?></option>
                                        <? unset($lang[Yii::$app->language]);
                                        foreach ($lang as $key => $val) {
                                            ?>
                                            <option value="<?= $val; ?>"><?= $val; ?></option>
                                        <? } ?>
                                    </select>
                                </td>
                                <td>
                                    <button type='button' class="btn btn-primary" id='add'
                                            data-id=''><?= Yii::t('app', 'Add'); ?></button>
                                </td>
                            </tr>
                            </thead>
                            <tbody id="variations">

                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><?= Yii::t('app', 'Submit'); ?></button>
                    <div class="clearfix"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

<?php
/*
$js = <<<js

js;

$this->registerJs($js);*/

$this->registerJsFile('/js/invitation.js', [
    'depends' => [
        'yii\web\YiiAsset'
    ]]);
