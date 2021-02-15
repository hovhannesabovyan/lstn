<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Locations a reader';
?>

<p>
    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        'line1',
        'city',
        'state',
        'country',
        'postal_code',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} &nbsp;&nbsp;&nbsp; {delete}',
        ],
    ],
]); ?>
</div>
