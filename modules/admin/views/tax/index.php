<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Tax';
?>

<p>
    <?= Html::a('Create tax', ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        'percentage',
        [
            'attribute' => 'is_deleted',
            'value' => function ($data) {
                if ($data->is_deleted == 0) {
                    return 'Yes';
                } else {
                    return 'No';
                }
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} &nbsp;&nbsp;&nbsp; {delete}',
        ],
    ],
]); ?>
</div>
