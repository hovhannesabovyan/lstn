<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Event log'); ?>
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
                            'date',
                            'act',
                            'object',
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
