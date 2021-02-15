<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Users'); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Invite members'), \yii\helpers\Url::to(['/site/invitation']), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Black list'), ['black_list'], ['class' => 'btn btn-success']) ?>
    </p>
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
                            'username',
                            'email',
                            'role',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        $customurl = Yii::$app->getUrlManager()->createUrl(['users/edit', 'id' => $model['id']]); //$model->id для AR
                                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                            ['title' => Yii::t('yii', 'Edit')]);
                                    },
                                    'event_log' => function ($url, $model) {
                                        $customurl = Yii::$app->getUrlManager()->createUrl(['users/event_log', 'id' => $model['id']]); //$model->id для AR
                                        return \yii\helpers\Html::a('<i class="fa fa-fw fa-book"></i>', $customurl,
                                            ['title' => Yii::t('yii', 'Event log')]);
                                    },
                                    'lock' => function ($url, $model) {
                                        if ($model['block'] == 0) {
                                            $customurl = Yii::$app->getUrlManager()->createUrl(['users/lock', 'id' => $model['id']]);
                                            return \yii\helpers\Html::a('<i class="fa fa-fw fa-unlock"></i>', $customurl,
                                                ['title' => Yii::t('app', 'Block'), 'aria-label' => Yii::t('yii', 'Block'), 'data-pjax' => "0",
                                                    'data-confirm' => Yii::t('app', 'Are you sure you want to block this item?'),
                                                    'data-method' => "post"]);
                                        } else {
                                            $customurl = Yii::$app->getUrlManager()->createUrl(['users/lock', 'id' => $model['id']]);
                                            return \yii\helpers\Html::a('<i class="fa fa-fw fa-lock"></i>', $customurl,
                                                ['title' => Yii::t('app', 'Unblock'), 'aria-label' => Yii::t('app', 'Unblock'), 'data-pjax' => "0",
                                                    'data-confirm' => Yii::t('app', 'Are you sure you want to unblock this item?'),
                                                    'data-method' => "post"]);
                                        }
                                    },
                                    'delete' => function ($url, $model) {
                                        $customurl = Yii::$app->getUrlManager()->createUrl(['users/delete', 'id' => $model['id']]); //$model->id для AR
                                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                            ['title' => Yii::t('yii', 'Delete'), 'aria-label' => Yii::t('app', 'Delete'), 'data-pjax' => "0",
                                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                'data-method' => "post"]);
                                    },
                                ],
                                'template' => '{edit}  {delete}',
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
        $('#w0-filters td').eq(0).html('<i class="fa fa-filter" aria-hidden="true"> Фильтр</i>');
    }else {
         $('#w0-filters td').eq(0).html('<i class="fa fa-filter" aria-hidden="true"> Filter</i>');
    }
JS;
$this->registerJs($script);
?>
