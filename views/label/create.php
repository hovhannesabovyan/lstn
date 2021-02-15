<?

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Role;
use kartik\select2\Select2;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Add label'); ?>
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('app', 'Back'), yii\helpers\Url::to(['label/index'])); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= Yii::t('app', 'Add label'); ?></h4>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'options' =>
                            ['enctype' => 'multipart/form-data'],
                        'fieldConfig' => [
                            'template' => "{label}{input}\n<div class=\"col-lg-8\" style=\"color:red;\">{error}</div>",
                            'labelOptions' => ['class' => 'bmd-label-floating'],
                        ],
                    ]); ?>
                    <div class="row">
                        <div class="col-md-5">
                            <?= $form->field($model, 'label_name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-7">
                            <?= $form->field($model, 'email')->Input('email', ['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'logo')->fileInput() ?>
                            <p class="file-return"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'youtube')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?
                            $data = is_array('');
                            $data['no'] = Yii::t('app', 'No');
                            $data['yes'] = Yii::t('app', 'Yes');
                            ?>
                            <?= $form->field($model, 'compilations_label')->widget(Select2::classname(), [
                                'data' => $data,
                                'hideSearch' => true,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?
                            $datas = ArrayHelper::map(\app\models\Label_form::find()->where(['compilations_label' => 'yes'])->all(), 'id', 'label_name');
                            $datas[0] = Yii::t('app', 'Select') . '...';
                            ksort($datas); ?>
                            <?= $form->field($model, 'parent_label')->widget(Select2::classname(), [
                                'data' => $datas,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="display: flex;width: 100%;flex-wrap: wrap;">
                            <div class="form-group field-label_form-genre bmd-form-group" style="width: 90%;">
                                <label class="bmd-label-floating" for="genre"><?= Yii::t('app', 'Genre'); ?></label>
                                <input type="hidden" class="form-control" id="label_form-genre" required
                                       name="Label_form[genre]" value="<?= $model->genre; ?>" maxlength="255"
                                       aria-invalid="false">
                                <input type="text" data-id="" id="genre" class="form-control" maxlength="255"
                                       aria-invalid="false">
                                <div class="col-lg-8" style="color:red;">
                                    <p class="help-block help-block-error" style="display: none;"
                                       id="genre_error"><?= Yii::t('app', 'Genre cannot be blank.'); ?></p>
                                </div>
                                <div class="col-lg-8" style="color:red;"><p class="help-block help-block-error" style="display: none;" id="mass_genre_error"><?= Yii::t('app', 'Maximum three genres'); ?></p>
                                </div>
                            </div>
                            <button type="button" class="btn" id="add_genre"><?= Yii::t('app', 'Add'); ?></button>
                            <table class="table">
                                <tbody id="genre_table">

                                </tbody>
                            </table>
                            <div id=""></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="bmd-label-floating"><?= Yii::t('app', 'Biography'); ?></label>
                                    <?= $form->field($model, 'biography')->textarea([
                                        'class' => 'form-control',
                                        'rows' => 5,
                                        'value' => $model->biography
                                    ]) ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><?= Yii::t('app', 'Add label'); ?></button>
                    <div class="clearfix"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile('/js/label/script.js?n=' . date('His'), [
    'depends' => [
        'yii\web\YiiAsset'
    ]]);
