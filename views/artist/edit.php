<?

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Role;
use kartik\select2\Select2;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Edit artist'); ?>
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('app', 'Back'), yii\helpers\Url::to(['artist/index'])); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= Yii::t('app', 'Add artist'); ?></h4>
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
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-7">
                            <?= $form->field($model, 'email')->Input('email', ['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'image')->fileInput() ?>
                            <p class="file-return"></p>
                            <? if ($model->image) {
                                echo "<div id='image' style='width: 180px;text-align: center;margin: 10px;'>";
                                echo "    <div>";
                                echo Html::img('@web/image/artist/' . $model->id . '/' . $model->image, ['style' => 'max-width: 180px; max-height: 150px;']);
                                echo "    </div>";
                                echo "    <div>";
                                echo "<button type='button' class='btn btn-primary' id='del_img' data-id='" . $model->id . "'>" . Yii::t('app', 'Delete') . "</button>";
                                echo "    </div>";
                                echo "</div>";
                            } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?
                            $data = is_array('');
                            $data[''] = 'Select';
                            $data['man'] = Yii::t('app', 'Man');
                            $data['woman'] = Yii::t('app', 'Woman');
                            ?>
                            <?= $form->field($model, 'gender')->widget(Select2::classname(), [
                                'data' => $data,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Select') . ' ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="bmd-label-floating"><?= Yii::t('app', 'Biography'); ?></label>
                                    <textarea name="Artist_form[biography]" class="form-control"
                                              rows="5"><?= $model->biography; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'apple_music')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'soundcloud')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'spotify')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'town')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'building')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <button type="submit"
                            class="btn btn-primary pull-right"><?= Yii::t('app', 'Edit artist'); ?></button>
                    <div class="clearfix"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<js

    $('body').on('change', '[name="Artist_form[image]"]', function(e) {
        var val = $(this).val();
        if (val){
            val = val.replace('fakepath','');
            val = val.replace("C:",'');  
        }
        $('.file-return').html(val.slice(2));
    }); 

    $('body').on('click', '#del_img', function (e) {
        var id = $(this).data('id');
    
        $.ajax({
            type: "POST",
            url: "/artist/deleteimage",
            data: {id:id},
            dataType: 'html',
            success: function(response) {
                $('#image').html('');
            }
        });
    });
js;

$this->registerJs($js);
