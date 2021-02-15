<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Labels'); ?>

<p>
    <?= Html::a(Yii::t('app', 'Add label'), ['create'], ['class' => 'btn btn-success']) ?>
</p>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <?php if (Yii::$app->session->hasFlash('success_import')): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo Yii::$app->session->getFlash('success_import'); ?>
                    </div>
                <?php endif; ?>

                <form action="/label/import" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
                    <input type="file" name="import">
                    <button  class="btn btn-primary"><?=Yii::t('app','Import')?></button>

                    <?php if ($_SESSION['language']=='en'):?>
                        <a href="/web/files/label-en.xlsx" class="btn btn-primary" >
                            <?=Yii::t('app','Example for import')?>
                        </a>
                    <?php else:?>
                        <a href="/web/files/label-ru.xlsx" class="btn btn-primary" >
                            <?=Yii::t('app','Example for import')?>
                        </a>
                    <?php endif;?>


                </form>

                <?= \kartik\export\ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'header' => Yii::t('app', 'Label Name'),
                            'value' => function ($data) {
                                return $data['label_name'];
                            },
                        ],
                        [
                            'header' => Yii::t('app', 'E-mail'),
                            'value' => function ($data) {
                                return $data['email'];
                            },
                        ],
                        [
                            'header' => Yii::t('app', 'Country'),
                            'value' => function ($data) {
                                return $data['country'];
                            },
                        ],
                        [
                            'header' => Yii::t('app', 'Website'),
                            'value' => function ($data) {
                                return $data['website'];
                            },
                        ],
                        [
                            'header' => Yii::t('app', 'Facebook'),
                            'value' => function ($data) {
                                return $data['facebook'];
                            },
                        ],
                        [
                            'header' => Yii::t('app', 'Twitter'),
                            'value' => function ($data) {
                                return $data['twitter'];
                            },
                        ],
                        [
                            'header' => Yii::t('app', 'YouTube'),
                            'value' => function ($data) {
                                return $data['youtube'];
                            },
                        ],
                        [
                            'header' => Yii::t('app', 'Genre'),
                            'value' => function ($data) {
                                return str_replace(['[', ']', '"'], ' ', $data['genre']);

                            },
                        ],

                        [
                            'header' => Yii::t('app', 'Biography'),
                            'value' => function ($data) {
                                return $data['biography'];
                            },
                        ],
                    ],
                    'dropdownOptions' => [
                        'label' => Yii::t('app', 'Export'),
                        'class' => 'btn btn-outline-secondary'
                    ]
                ]); ?>

                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => [
                        'class' => 'table'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'logo',
                            'value' => function ($data) {
                                if ($data['logo']) {
//                                    if ($data['logo'] == 'noPhoto.svg') {
//                                        return "<div style='width: 100%;text-align: center;'><img style='max-width: 130px;max-height: 98px;' src='/web/image/label/nofoto.png'></div>";
//                                    }
                                    return "<div style='width: 100%;text-align: center;'><img style='max-width: 130px;max-height: 98px;' src='/web/image/label/" . $data['id'] . "/" . $data['logo'] . "'></div>";
                                } else {
                                    $out = '<div class="image_info">';
                                    $out .= substr($data['label_name'], 0, 1);
                                    $out .= '</div>';
                                    return $out;
                                }
                            },
                            'format' => 'html',
                        ],
                        'label_name',
                        'country',
                        [
                            'attribute' => 'genre',
                            'value' => function ($data) {
                                return str_replace(['[', ']', '"'], ' ', $data['genre']);
                            },
                            'format' => 'html',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'buttons' => [
                                'edit' => function ($url, $model) {
                                    $customurl = Yii::$app->getUrlManager()->createUrl(['label/edit', 'id' => $model['id']]); //$model->id для AR
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                        ['title' => Yii::t('app', 'Edit')]);
                                },
                                'delete' => function ($url, $model) {
                                    $customurl = Yii::$app->getUrlManager()->createUrl(['label/delete', 'id' => $model['id']]); //$model->id для AR
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
$('.grid-view').addClass('table-responsive');
$('.table-responsive').removeClass('grid-view');
JS;
$this->registerJs($js);
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
        $('#w4-filters td').eq(0).html('<i class="fa fa-filter" aria-hidden="true"> Фильтр</i>');
    }else {
         $('#w4-filters td').eq(1).html('<i class="fa fa-filter" aria-hidden="true"> Filter</i>');
    }
JS;
$this->registerJs($script);
?>
