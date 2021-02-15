<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update Location a Reader';
?>
<div class="category-create">

    <div class="category-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'required' => 'required', 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'line1')->textInput(['maxlength' => true, 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'state')->textInput(['maxlength' => true, 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'country')->textInput(['maxlength' => true, 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>
        <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true, 'style' => 'background-color: white;border: 1px solid #d2d6de;']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
