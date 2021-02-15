<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Category';
?>
<div class="category-create">

    <div class="category-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'required' => 'required', 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'rank')->textInput(['maxlength' => true, 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'square_id')->textInput(['maxlength' => true, 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'is_deleted')->dropDownList([
            '0' => 'Yes',
            '1' => 'No',
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
