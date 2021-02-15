<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\Category;
use app\modules\admin\models\Tax;

$this->title = 'Items';
?>

    <p>
        <?= Html::a('Create item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'image',
            'value' => function ($data) {
                if ($data->image) {
                    if (strpos($data->image, 'http') === false) {
                        return "<div style='width: 100%;text-align: center;'><img style='max-width: 130px;max-height: 98px;' src='/web/image/items/" . $data->id . "/" . $data->image . "'></div>";
                    } else {
                        return "<div style='width: 100%;text-align: center;'><img style='max-width: 130px;max-height: 98px;' src='" . $data->image . "'></div>";
                    }
                } else {
                    return "<div style='width: 100%;text-align: center;'><img style='max-width: 130px;max-height: 98px;' src='/web/image/no_image.png'></div>";
                }
            },
            'format' => 'html',
        ],
        'name',
        [
            'attribute' => 'category_id',
            'value' => function ($data) {
                if ($data->category_id != 0) {
                    $name = Category::find()->select('name')->where(['id' => $data->category_id])->asArray()->one();
                    return $name['name'];
                } else {
                    return '';
                }
            },
        ],
        [
            'attribute' => 'tax_ids',
            'value' => function ($data) {
                if ($data->tax_ids == 0) {
                    return '';
                } else {
                    $name = Tax::find()->select('name')->where(['id' => $data->tax_ids])->asArray()->one();
                    return $name['name'];
                }
            },
        ],
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
    $('[name="Items[name]"]').css({'background-color':'white'});
    $('[name="Items[category_id]"]').css({'background-color':'white'});
    $('[name="Items[image]"]').prop('disabled',true);
JS;
$this->registerJs($js);
