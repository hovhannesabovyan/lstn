<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\Category;
use app\modules\admin\models\Tax;

$this->title = 'Orders';
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'number',
        [
            'attribute' => 'create_date',
            'format' => ['date', 'dd.MM.YYYY hh:mm:ss a'],
        ],
        'phone',
        [
            'attribute' => 'status',
            'content' => function ($data) {
                if ($data->status == 'New' || $data->status == 'Prepare' || $data->status == 'Cancel') {
                    $out = '<select class="form-control" id="status" style="width: 100%;">
                                    <option value="' . $data->status . '">' . $data->status . '</option>';
                    if ($data->status != "New") $out .= '<option value="New">New</option>';
                    if ($data->status != "Prepare") $out .= '<option value="Prepare">Prepare</option>';
                    if ($data->status != "Cancel") $out .= '<option value="Cancel">Cancel</option>';
                    $out .= '</select>';
                    return $out;
                } else {
                    return $data->status;
                }
            },
            'format' => 'html',
        ],
        'species_payment',
        [
            'attribute' => 'payment',
            'value' => function ($data) {
                if ($data->payment == 0) {
                    return 'Not Paid';
                } else {
                    return 'Paid';
                }
            },
            'format' => 'html',
        ],
        'total',
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'refund' => function ($url, $model) {
                    if ($model['payment'] == 1) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['admin/orders/refund', 'id' => $model['id']]); //$model->id для AR
                        return \yii\helpers\Html::a('<i class="fa fa-fw fa-money"></i>', $customurl,
                            ['title' => Yii::t('yii', 'Refund')]);
                    }
                }
            ],
            'template' => '{refund}',
        ],
    ],
]); ?>

<?php
$js = <<<JS
    $('[name="Order[number]"]').css({'background-color':'white'});
    $('[name="Order[create_date]"]').css({'background-color':'white'});
    $('[name="Order[phone]"]').css({'background-color':'white'});
    $('[name="Order[species_payment]"]').css({'background-color':'white'});
    $('[name="Order[status]"]').css({'background-color':'white'});
    
    $('body').on('change', '#status', function (e) {
        var status = $(this).val(),
            id = $(this).parent().parent().data('key');
        
        if (status&&id){
            $.ajax({
            type: "POST",
            url: "/admin/orders/update_status",
            data: {status:status, id:id},
            dataType: 'html',
            success: function(response) {
                location.reload();
            }
        });
        }
    });
JS;
$this->registerJs($js);
