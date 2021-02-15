<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

/* @var $model app\modules\admin\models\Product */

use app\modules\admin\models\Category;
use app\modules\admin\models\Tax;
use app\modules\admin\models\Items;

if ($model->related_items) $model->related_items = json_decode($model->related_items, true);
$this->title = 'Update item: ' . $model->name;
?>
    <div class="product-update">
        <div class="product-form">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'square_id')->textInput(['maxlength' => true, 'style' => 'background-color: white;']) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style' => 'background-color: white;']) ?>


            <?= $form->field($model, 'image')->fileInput() ?>

            <div style="display: flex;flex-wrap: wrap;">
                <? if ($model->image) {
                    if (strpos($model->image, 'http') === false) {
                        echo "<div id='image' style='width: 180px;text-align: center;margin: 10px;'>";
                        echo "    <div>";
                        echo Html::img('@web/image/items/' . $model->id . '/' . $model->image, ['class' => 'img-responsive second-img']);
                        echo "    </div>";
                        echo "    <div>";
                        echo "<button type='button' style='padding: 5px 10px; margin-top: 10px;' id='del_img' data-id='" . $model->id . "'>Delete</button>";
                        echo "    </div>";
                        echo "</div>";
                    } else {
                        echo "<div id='image' style='width: 180px;text-align: center;margin: 10px;'>";
                        echo "    <div>";
                        echo Html::img($model->image, ['class' => 'img-responsive second-img']);
                        echo "    </div>";
                        echo "    <div>";
                        echo "<button type='button' style='padding: 5px 10px; margin-top: 10px;' id='del_img' data-id='" . $model->id . "'>Delete</button>";
                        echo "    </div>";
                        echo "</div>";
                    }
                } ?>
            </div>

            <?= $form->field($model, 'is_deleted')->dropDownList(['0' => 'Yes', '1' => 'No',]) ?>

            <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name'), ['prompt' => '']) ?>

            <?= $form->field($model, 'tax_ids')->dropDownList(ArrayHelper::map(Tax::find()->all(), 'id', 'name'), ['prompt' => '']) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 3, 'cols' => 5, 'style' => 'background-color: white;']) ?>


            <input type="hidden" name="variations" value="<?= htmlspecialchars($variations); ?>">
            <input type="hidden" id="edit_mass" value="">
            <div style="overflow: auto;">
                <table style="min-width: 750px;border: 5px solid white;">
                    <thead>
                    <tr>
                        <th>Square id</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Published</th>
                        <th></th>
                    </tr>
                    <tr id="tr_add" data-id="">
                        <td><input type="text" id="square_id" name="square_id"
                                   style="background-color: white;height: 34px;vertical-align: unset;" maxlength="255"
                                   value=""></td>
                        <td><input type="text" name="name"
                                   style="background-color: white;height: 34px;vertical-align: unset;" maxlength="255"
                                   value=""></td>
                        <td><input type="number" min="0" step="0.01"
                                   style="background-color: white;height: 34px;vertical-align: unset;" name="amount"
                                   value="" maxlength="255"></td>
                        <td>
                            <select class="form-control" name="is_deleted">
                                <option value="0" selected="">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </td>
                        <td>
                            <button type='button' style='padding: 5px 10px; margin-top: 10px;vertical-align: unset;'
                                    id='add' data-id=''>Add
                            </button>
                        </td>
                    </tr>
                    </thead>
                    <tbody id="variations">

                    </tbody>
                </table>
            </div>


            <div style="margin-top: 25px;">
                <?= $form->field($model, 'related_items')->checkboxList(ArrayHelper::map(Items::find()->where('id !=' . $model->id)->asArray()->all(), 'id', 'name'),
                    [
                        'class' => 'related_items'
                    ]) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
<?php
/*
$js = <<<js

js;

$this->registerJs($js);*/

$this->registerJsFile('/modules/admin/views/items/item.js', [
    'depends' => [
        'yii\web\YiiAsset'
    ]]);
