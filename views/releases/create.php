<?

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Artist;
use app\models\Label;
use kartik\select2\Select2;
use app\models\Country;
use yii\helpers\Html;

use app\models\TblReleaseTypes;

$this->title = Yii::t('app', 'Add release');
?>

    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('app', 'Back'), yii\helpers\Url::to(['releases/index'])); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= Yii::t('app', 'Add release'); ?></h4>
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
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'cover_image')->fileInput() ?>
                            <p class="file-return1"></p>
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
                            <?
                            $data = is_array('');
                            $data['Final Release'] = Yii::t('app', 'Final Release');
                            $data['Unreleased'] = Yii::t('app', 'Unreleased');
                            $data['Draft'] = Yii::t('app', 'Draft…');
                            ?>
                            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                                'data' => $data,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Select') . ' ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <?
                            $data_r = TblReleaseTypes::GetAll();

                            //                            $data['Single'] = Yii::t('app', 'Single');
                            //                            $data['EP'] = Yii::t('app', 'EP');
                            //                            $data['Album'] = Yii::t('app', 'Album');
                            //                            $data['Compilation'] = Yii::t('app', 'Compilation');
                            ?>


                            <?= $form->field($model, 'release_type')->widget(Select2::classname(), [
                                'data' => $data_r,
                                'value' => $model->release_type,
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
                            <?= $form->field($model, 'exclusive_date')->textInput(['maxlength' => true]); ?>
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
                            class="btn btn-primary pull-right"><?= Yii::t('app', 'Add release'); ?></button>
                    <div class="clearfix"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS
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
