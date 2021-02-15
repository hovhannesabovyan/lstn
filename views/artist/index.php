<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Artists'); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Add artist'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php if (Yii::$app->session->hasFlash('success_import')): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <?php echo Yii::$app->session->getFlash('success_import'); ?>
                        </div>
                    <?php endif; ?>

                    <form action="/artist/import" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
                        <input type="file" name="import">
                        <button class="btn btn-primary"><?= Yii::t('app', 'Import') ?></button>

                        <?php if ($_SESSION['language'] == 'en'): ?>
                            <a href="/web/files/artist-en.xlsx" class="btn btn-primary">
                                <?= Yii::t('app', 'Example for import') ?>
                            </a>
                        <?php else: ?>
                            <a href="/web/files/artist-ru.xlsx" class="btn btn-primary">
                                <?= Yii::t('app', 'Example for import') ?>
                            </a>
                        <?php endif; ?>
                    </form>

                    <?= \kartik\export\ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'header' => Yii::t('app', 'User Name'),
                                'value' => function ($data) {
                                    return $data['name'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'E-mail'),
                                'value' => function ($data) {
                                    return $data['email'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Fist Name'),
                                'value' => function ($data) {
                                    return $data['first_name'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Last Name'),
                                'value' => function ($data) {
                                    return $data['last_name'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Gender'),
                                'value' => function ($data) {
                                    return $data['gender'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Phone'),
                                'value' => function ($data) {
                                    return $data['phone_number'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Biography'),
                                'value' => function ($data) {
                                    return $data['biography'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Website'),
                                'value' => function ($data) {
                                    return $data['website'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Twitter'),
                                'value' => function ($data) {
                                    return $data['twitter'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Apple Music'),
                                'value' => function ($data) {
                                    return $data['apple_music'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'SoundCloud'),
                                'value' => function ($data) {
                                    return $data['soundcloud'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Spotify'),
                                'value' => function ($data) {
                                    return $data['spotify'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Country'),
                                'value' => function ($data) {
                                    return $data['country'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Town'),
                                'value' => function ($data) {
                                    return $data['town'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Street'),
                                'value' => function ($data) {
                                    return $data['street'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Building Name / No'),
                                'value' => function ($data) {
                                    return $data['building'];
                                },
                            ],
                            [
                                'header' => Yii::t('app', 'Postcode'),
                                'value' => function ($data) {
                                    return $data['postcode'];
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
                                'attribute' => 'image',
                                'value' => function ($data) {
                                    if ($data['image']) {
                                        return "<div style='width: 100%;text-align: center;'><img style='max-width: 130px;max-height: 98px;' src='/web/image/artist/" . $data['id'] . "/" . $data['image'] . "'></div>";
                                    } else {
                                        $out = '<div class="image_info">';
                                        $out .= substr($data['first_name'], 0, 1) . substr($data['last_name'], 0, 1);
                                        $out .= '</div>';
                                        return $out;
                                    }
                                },
                                'format' => 'html',
                            ],
                            'first_name',
                            'last_name',
                            'email',
                            'phone_number',
                            'country',
                            'town',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'buttons' => [
                                    'edit' => function ($url, $model) {
                                        $customurl = Yii::$app->getUrlManager()->createUrl(['artist/edit', 'id' => $model['id']]); //$model->id для AR
                                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                            ['title' => Yii::t('app', 'Edit')]);
                                    },
                                    'delete' => function ($url, $model) {
                                        $customurl = Yii::$app->getUrlManager()->createUrl(['artist/delete', 'id' => $model['id']]); //$model->id для AR
                                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                            ['title' => Yii::t('yii', 'Delete'), 'aria-label' => Yii::t('app', 'Delete'), 'data-pjax' => "0",
                                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                'data-method' => "post"]);
                                    },
                                ],
                                'template' => '{edit} {delete}',
                            ],
                        ],
                    ]); ?>

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
        $('#w4-filters td').eq(1).html('<i class="fa fa-filter" aria-hidden="true"> Фильтр</i>');
    }else {
         $('#w4-filters td').eq(1).html('<i class="fa fa-filter" aria-hidden="true"> Filter</i>');
    }
    
   
JS;
$this->registerJs($script);
?>


