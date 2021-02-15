<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Black list'); ?>
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . Yii::t('app', 'Back'), yii\helpers\Url::to(['users/index'])); ?>
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
                            'username',
                            'email',
                            'role',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'buttons' => [
                                    'recover' => function ($url, $model) {
                                        $customurl = Yii::$app->getUrlManager()->createUrl(['users/delete', 'id' => $model['id']]); //$model->id для AR
                                        return \yii\helpers\Html::a('<i class="fa fa-fw fa-undo"></i>', $customurl,
                                            ['title' => Yii::t('app', 'Restore'), 'aria-label' => Yii::t('app', 'Restore'), 'data-pjax' => "0",
                                                'data-confirm' => Yii::t('app', 'Are you sure you want to restore this item?'),
                                                'data-method' => "post"]);
                                    },
                                ],
                                'template' => '{recover}',
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
JS;
$this->registerJs($js);
?>
