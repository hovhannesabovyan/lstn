<?php

use app\modules\admin\models\Items;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Update: ' . $order->number;
if ($items) {
    $mass = is_array('');
    foreach ($items as $item) {
        $mass[$item['id']] = $item;
    }
}

if ($variations) {
    $arr = is_array('');
    foreach ($variations as $variation) {
        $arr[$variation['id']] = $variation;
    }
}

if ($tax) {
    $array = is_array('');
    foreach ($tax as $ta) {
        $array[$ta['id']] = $ta;
    }
}
?>
    <input type="hidden" id="id_order" value="<?= $order->id; ?>">
    <input type="hidden" id="items" value="<?= htmlspecialchars(json_encode($mass)); ?>">
    <input type="hidden" id="variations_" value="<?= htmlspecialchars(json_encode($arr)); ?>">
    <input type="hidden" id="tax" value="<?= htmlspecialchars(json_encode($array)); ?>">

    <div class="product-update">
        <div class="product-form refund_blocks">
            <div class="refund_block">
                <div class="form-group">
                    <label class="control-label">Create Date: </label>
                    <span><?= $order->create_date; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Phone: </label>
                    <span><input type="text" class="form-control" id="phone" style="background-color: white;"
                                 value="<?= $order->phone; ?>"></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Status: </label>
                    <select class="form-control select2" name="status" style="width: 100%;">
                        <option value="<?= $order->status; ?>"><?= $order->status; ?></option>
                        <? if ($order->status == "New") echo '<option value="Cancelled">Cancelled</option>'; else '<option value="New">New</option>'; ?>
                    </select>
                </div>
            </div>
            <div class="refund_block">
                <div class="form-group">
                    <label class="control-label">Payment: </label>
                    <span><? if ($order->payment == 0) echo 'Not Paid'; else echo "Paid"; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Species Payment: </label>
                    <span><?= $order->species_payment; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Count: </label>
                    <span id="all_count"><?= $order->count; ?></span>
                </div>
            </div>
            <div class="refund_block">
                <div class="form-group">
                    <label class="control-label">Subtotal: </label>
                    $<span id="all_subtotal"><?= $order->subtotal / 100; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Tip Percent: </label>
                    <select class="form-control select2" id="all_tip_per" style="width: 100%;">
                        <option value="<?= $order->tip_per; ?>"><?= $order->tip_per; ?>%</option>
                        <? if ($order->tip_per != "0") echo '<option value="0">No Tip</option>'; ?>
                        <? if ($order->tip_per != "10") echo '<option value="10">10%</option>'; ?>
                        <? if ($order->tip_per != "15") echo '<option value="15">15%</option>'; ?>
                        <? if ($order->tip_per != "20") echo '<option value="20">20%</option>'; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Tip Total: </label>
                    $<span id="all_tip"><?= $order->tip_summ / 100; ?></span>
                </div>
            </div>
            <div class="refund_block">
                <div class="form-group">
                    <label class="control-label">Tax: </label>
                    $<span id="all_tax"><?= $order->tax / 100; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Fees: </label>
                    $<span id="all_fees"><?= $order->fees / 100; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Total: </label>
                    $<span id="all_total"><?= $order->total / 100; ?></span>
                </div>
            </div>
        </div>

        <input type="hidden" name="variations" value="<?= htmlspecialchars($order_variantions); ?>">
        <input type="hidden" id="edit_mass" value="">
        <div style="overflow: auto;padding: 15px;">
            <table style="min-width: 750px;border: 5px solid white;">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
                <tr id="tr_add" data-id="">
                    <td>
                        <div class="form-group">
                            <select class="form-control select2" name="product_id" style="width: 100%;">
                                <option></option>
                                <? if ($items) {
                                    foreach ($items as $item) {
                                        ?>
                                        <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                                    <?
                                    }
                                } ?>
                            </select>
                        </div>
                    </td>
                    <td><input type="number" min="1" name="qty" step="1"
                               style="background-color: white;height: 34px;vertical-align: unset;" value=""></td>
                    <td>

                        <div class="form-group">
                            <select class="form-control select2" name="variation_id" style="width: 100%;">

                            </select>
                        </div>
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
        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php
$this->registerJsFile('/modules/admin/views/orders/update.js', [
    'depends' => [
        'yii\web\YiiAsset'
    ]]);
