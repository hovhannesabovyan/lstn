<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Add tracks'); ?>

<?php $css = <<<CSS
 .loader{
         position:fixed; top:0;
         left:0; right:0; bottom:0;     
         background:rgba(255,255,255,.8);
          padding-top:150px ;
         padding-top:20px;
         z-index:99999;
         text-align: center;
         padding-top: 311px;
   }   

.loader div{
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    margin-left: 700px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
CSS;
$this->registerCss($css)
?>


    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('app', 'Back'), yii\helpers\Url::to(['releases/edit', 'id' => $_GET['id']])); ?>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12"></div>
                <div class="col-lg-12">
                    <div id="loader">
                        <div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </div>
    </div>

<?php if (Yii::$app->session->hasFlash('error_add_track')) : ?>
    <?php if (Yii::$app->session->hasFlash('error_add_track')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('error_add_track'); ?>
        </div>
    <?php endif; ?>
<?php else:; ?>
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
                        <div class="col-md-12">
                            <?= $form->field($model, 'track_artist')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'track_title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'mix_name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'track_price')->dropDownList(
                                $model::DataTracks()
                            ) ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'track')->fileInput() ?>
                            <p class="file-return"></p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"
                            id="loadd"><?= Yii::t('app', 'Add track'); ?></button>
                    <div class="clearfix"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

    <div class="row">
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
<?php $jsPree = <<<JS
         function show_loader(){
	        $("#loader").addClass("loader");
             //event.preventDefault();
        }
        
        function hide_loader(){
            $("#loader").removeClass("loader");
           //event.preventDefault();
        }
        
        if($("#loadd").length) {
            $("#loadd").click(function(event) {
                show_loader();
            wait(1000);
            setTimeout(hide_loader, 20000);
            hide_loader();
            
            });
        }

JS;
$this->registerJs($jsPree);
?>