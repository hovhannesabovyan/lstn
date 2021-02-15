<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Category';
?>

    <p>
        <?= Html::a('Create category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'rank',
        'name',
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

<?php
$js = <<<JS
    $('[name="Category[rank]"]').css({'background-color':'white'});
    $('[name="Category[name]"]').css({'background-color':'white'});
JS;
$this->registerJs($js);
