<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Location_reader;
use yii\helpers\ArrayHelper;

$this->title = 'Create Reader';
?>
<div class="category-create">

    <div class="category-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'label')->textInput(['maxlength' => true, 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'registration_code')->textInput(['maxlength' => true, 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'id_location')->dropDownList(ArrayHelper::map(Location_reader::find()->all(), 'id_stripe', 'name'), ['prompt' => '']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
