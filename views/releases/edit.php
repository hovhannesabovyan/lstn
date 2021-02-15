<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Artist;
use app\models\Label;
use kartik\select2\Select2;
use app\models\Country;
use yii\grid\GridView;
use yii\helpers\Html;

use app\models\TblReleaseTypes;

$this->title = Yii::t('app', 'Edit release');

?>
<?php if (Yii::$app->session->hasFlash('error_edit_rel')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo Yii::$app->session->getFlash('error_edit_rel'); ?>
    </div>
<?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('app', 'Back'), yii\helpers\Url::to(['releases/index'])); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= Yii::t('app', 'Edit release'); ?></h4>
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
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-7">
                            <?= $form->field($model, 'catalog')->textInput(['maxlength' => true, 'onkeyup' => 'limitInput(this);']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'release_logo')->fileInput() ?>
                            <p class="file-return"></p>
                            <? if ($model->release_logo) {
                                echo "<div id='logo' style='width: 180px;text-align: center;margin: 10px;'>";
                                echo "    <div>";
                                echo Html::img('@web/image/releases/' . $model->id . '/' . $model->release_logo, ['style' => 'max-width: 180px; max-height: 150px;']);
                                echo "    </div>";
                                echo "    <div>";
                                echo "<button type='button' class='btn btn-primary' id='del_logo' data-id='" . $model->id . "'>" . Yii::t('app', 'Delete') . "</button>";
                                echo "    </div>";
                                echo "</div>";
                            } ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'cover_image')->fileInput() ?>
                            <p class="file-return1"></p>
                            <? if ($model->cover_image) {
                                echo "<div id='image' style='width: 180px;text-align: center;margin: 10px;'>";
                                echo "    <div>";
                                echo Html::img('@web/image/releases/' . $model->id . '/' . $model->cover_image, ['style' => 'max-width: 180px; max-height: 150px;']);
                                echo "    </div>";
                                echo "    <div>";
                                echo "<button type='button' class='btn btn-primary' id='del_image' data-id='" . $model->id . "'>" . Yii::t('app', 'Delete') . "</button>";
                                echo "    </div>";
                                echo "</div>";
                            } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'label')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Label::find()->where(['cabinet_id' => yii::$app->user->identity['cabinet'], 'user_id' => yii::$app->user->identity['id']])->all(), 'label_name', 'label_name'),
                                'options' => ['placeholder' => Yii::t('app', 'Select') . '...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'artist_name')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Artist::find()->where(['cabinet_id' => yii::$app->user->identity['cabinet'], 'user_id' => yii::$app->user->identity['id']])->all(), 'name', 'name'),
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'multiple' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?php
                            $data = is_array('');
                            $data['Final Release'] = Yii::t('app', 'Final Release');
                            $data['Unreleased'] = Yii::t('app', 'Unreleased');
                            $data['Draft'] = Yii::t('app', 'Draft…');

                            if (empty($model->tracks)) {
                                $disabled = true;
                            } else {
                                $disabled = false;
                            }
                            ?>
                            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                                'data' => $data,
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => Yii::t('app', 'Select') . ' ...',
                                    'disabled' => $disabled
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,

                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">

                            <?php $data_r = TblReleaseTypes::GetAll(); ?>

                            <?= $form->field($model, 'release_type')->widget(Select2::classname(), [
                                'data' => $data_r,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Select') . ' ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>

                        </div>
                        <div class="col-md-4">
                            <?
                            $data = is_array('');
                            $data['No'] = Yii::t('app', 'No');
                            $data['Yes'] = Yii::t('app', 'Yes');
                            ?>
                            <?= $form->field($model, 'exclusive')->widget(Select2::classname(), [
                                'data' => $data,
                                'hideSearch' => true,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="row" id="exlusive_true" style="display: none;">
                        <div class="col-md-4">
                            <?= $form->field($model, 'exclusive_date')->textInput(['maxlength' => true, 'readonly' => true]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'exclusive_store')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'exclusive_period')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'upc_code')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'ean_code')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-4">
                            <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'primary_genre')->dropDownList(
                                \app\models\Genre::AllGenre()
                            ) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'sub_genre')->dropDownList(
                                \app\models\Subgenre::AllSubGenre()
                            ) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'bundle_price')->dropDownList(
                                \app\models\RelBundlePrice::GetAllSum()
                            ) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'produced_by')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'author_lastname')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'published_by')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'explicit_lyrics')->widget(Select2::classname(), [
                                'data' => $data,
                                'hideSearch' => true,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'explicit_artwork')->widget(Select2::classname(), [
                                'data' => $data,
                                'hideSearch' => true,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'previously_released')->widget(Select2::classname(), [
                                'data' => $data,
                                'hideSearch' => true,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'sales_start_date')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?
                            $data = is_array('');
                            $data['Worldwide release'] = Yii::t('app', 'Worldwide release');
                            $data['Only Selected Territories'] = Yii::t('app', 'Only Selected Territories');
                            $data['Worldwide except selected territories'] = Yii::t('app', 'Worldwide except selected territories');
                            ?>
                            <?= $form->field($model, 'territories')->widget(Select2::classname(), [
                                'data' => $data,
                                'hideSearch' => true,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="territory_selection_" style="display: none;">
                            <?= $form->field($model, 'territory_selection')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Country::find()->all(), 'id', $_SESSION['language']),
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'multiple' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="bmd-label-floating"><?= Yii::t('app', 'Description'); ?></label>
                                    <textarea name="Releases_form[description]" class="form-control"
                                              rows="5"><?= $model->description; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                            class="btn btn-primary pull-right"><?= Yii::t('app', 'Edit release'); ?></button>
                    <div class="clearfix"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= Html::a(Yii::t('app', 'Add tracks'), ['tracks/create', 'id' => $model->id], ['class' => 'btn btn-primary pull-right']) ?>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <? echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}",
                        'tableOptions' => [
                            'class' => 'table'
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'track_artist',
                            'track_title',
                            'mix_name',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'buttons' => [
                                    'edit' => function ($url, $model) {
                                        $customurl = Yii::$app->getUrlManager()->createUrl(['tracks/edit', 'id' => $model['id']]); //$model->id для AR
                                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                            ['title' => Yii::t('app', 'Edit')]);
                                    },
                                    'delete' => function ($url, $model) {
                                        $customurl = Yii::$app->getUrlManager()->createUrl(['tracks/delete', 'id' => $model['id']]); //$model->id для AR
                                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                            ['title' => Yii::t('yii', 'Delete'), 'aria-label' => Yii::t('app', 'Delete'), 'data-pjax' => "0",
                                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                'data-method' => "post"]);
                                    },
                                ],
                                'template' => '{edit} {delete}',
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS
if ($('#releases_form-exclusive').val()=='Yes'){ 
    $('#exlusive_true').css({'display':'flex'});
    $('#releases_form-exclusive_date').prop('required', true);
        $('#releases_form-exclusive_store').prop('required', true);
        $('#releases_form-exclusive_period').prop('required', true);
}
if (document.getElementById('releases_form-territories').value=='Only Selected Territories'||document.getElementById('releases_form-territories').value=='Worldwide except selected territories'){
    $('#territory_selection_').css({'display':'block'});
    $('#releases_form-territory_selection').prop('required', true);
}

    $('#releases_form-exclusive_date').pickadate({
        today: 'Today',
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
        dateMin: true,
        clear: false,
    });

    $('#releases_form-sales_start_date').pickadate({
        today: 'Today',
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
        dateMin: true,
        clear: false,
    });
JS;
$this->registerJs($js);
$this->registerJsFile('/js/pickadate.legacy.js', [
    'depends' => [
        'yii\web\YiiAsset'
    ]]);

$this->registerCSSFile('/css/calendar/classic.css?n=' . date('Ymd'));
$this->registerCSSFile('/css/calendar/classic.date.css?n=' . date('Ymd'));
$this->registerJsFile('/js/release/script.js?n=' . date('His'), [
    'depends' => [
        'yii\web\YiiAsset'
    ]]);
