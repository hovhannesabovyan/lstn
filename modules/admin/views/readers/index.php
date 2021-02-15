<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Readers';
?>

<p>
    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'label',
        'registration_code',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} &nbsp;&nbsp;&nbsp; {delete}',
        ],
    ],
]); ?>
</div>
