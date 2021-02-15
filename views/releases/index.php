<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Releases'); ?>
<p>
    <?= Html::a(Yii::t('app', 'Add release'), ['create'], ['class' => 'btn btn-success']) ?>
</p>

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
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <? echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => [
                        'class' => 'table'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'release_logo',
                            'value' => function ($data) {
                                if ($data['release_logo']) {
                                    return "<div style='width: 100%;text-align: center;'><img style='max-width: 130px;max-height: 98px;' src='/web/image/releases/" . $data['id'] . "/" . $data['release_logo'] . "'></div>";
                                } else {
                                    $out = '<div class="image_info">';
                                    $out .= substr($data['title'], 0, 1);
                                    $out .= '</div>';
                                    return $out;
                                }
                            },
                            'format' => 'html',
                        ],
                        'title',
                        'create_date',
                        'primary_genre',
                        [
                            'attribute' => 'status',
                            'value' => function ($data) {
                                return Yii::t('app', $data->status);
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'status', [
                                'Final Release' => Yii::t('app', 'Final Release'),
                                'Unreleased' => Yii::t('app', 'Unreleased'),
                                'Draft' => Yii::t('app', 'Draft…')
                            ], ['prompt' => '', 'class' => 'form-control']),
                        ],
                        [
                            'attribute' => 'exclusive',
                            'value' => function ($data) {
                                return Yii::t('app', $data->exclusive);
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'exclusive', ['1' => Yii::t('app', 'Yes'), '0' => Yii::t('app', 'No')], ['prompt' => '', 'class' => 'form-control']),
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'buttons' => [
                                'xml' => function ($url, $model) {
                                    if ($model->status !== 'Final Release') {
                                        return false;
                                    } else {
                                        $customurl = Yii::$app->getUrlManager()->createUrl(['releases/xml', 'id' => $model['id']]); //$model->id для AR
                                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-open"></span>', $customurl,
                                            ['title' => Yii::t('app', 'Xml')]);
                                    }

                                },
                                'edit' => function ($url, $model) {
                                    $customurl = Yii::$app->getUrlManager()->createUrl(['releases/edit', 'id' => $model['id']]); //$model->id для AR
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                        ['title' => Yii::t('app', 'Edit')]);
                                },
                                'delete' => function ($url, $model) {
                                    $customurl = Yii::$app->getUrlManager()->createUrl(['releases/delete', 'id' => $model['id']]); //$model->id для AR
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                        ['title' => Yii::t('yii', 'Delete'), 'aria-label' => Yii::t('app', 'Delete'), 'data-pjax' => "0",
                                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                            'data-method' => "post"]);
                                },
                            ],
                            'template' => '{edit} {delete} {xml}',
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
$('.grid-view').addClass('table-responsive');
$('.table-responsive').removeClass('grid-view');
JS;
$this->registerJs($js);

$js = <<<JS
    $('[name="Releases[create_date]"]').pickadate({
        today: 'Today',
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
    });
JS;
$this->registerJs($js);
$this->registerJsFile('/js/pickadate.legacy.js', [
    'depends' => [
        'yii\web\YiiAsset'
    ]]);

$this->registerCSSFile('/css/calendar/classic.css?n=' . date('Ymd'));
$this->registerCSSFile('/css/calendar/classic.date.css?n=' . date('Ymd'));
?>

<?php $jsPree = <<<JS
         function show_loader(){
	        $("#loader").addClass("loader");
             //event.preventDefault();
        }
        
        function hide_loader(){
            $("#loader").removeClass("loader");
           //event.preventDefault();
        }
        
        if($(".glyphicon-open").length) {
            $(".glyphicon-open").click(function(event) {
                show_loader();
            wait(1000);
            setTimeout(hide_loader, 20000);
            hide_loader();
            
            });
        }

JS;
$this->registerJs($jsPree);
?>

<?php
$script = <<<JS
     var removeSortIcon = function(event) {
            $('[data-sort]').each(function() {
                var element = $(this);
                
                if(element.hasClass('asc')) {
                    element.append('<span class="glyphicon glyphicon-arrow-up"></span>');
                }if(element.hasClass('desc')){
                     element.append('<span class="glyphicon glyphicon-arrow-down"></span>');
                }else {
                    element.remove('span');
                }
            });
    }    
    $(document).ready(removeSortIcon);
    $(document).on('ready pjax:success', removeSortIcon);
    
     if (document.documentElement.lang === 'ru'){
        $('#w0-filters td').eq(1).html('<i class="fa fa-filter" aria-hidden="true"> Фильтр</i>');
    }else {
         $('#w0-filters td').eq(1).html('<i class="fa fa-filter" aria-hidden="true"> Filter</i>');
    }
JS;
$this->registerJs($script);
?>
