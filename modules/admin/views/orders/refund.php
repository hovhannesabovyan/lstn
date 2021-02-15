<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Refund: ' . $order->number;
?>
    <input type="hidden" id="id_order" value="<?= $order->id; ?>">
    <div class="product-update">
        <div class="product-form refund_blocks">
            <div class="refund_block">
                <div class="form-group">
                    <label class="control-label">Create Date: </label>
                    <span><?= $order->create_date; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Phone: </label>
                    <span><?= $order->phone; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Status: </label>
                    <span><?= $order->status; ?></span>
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
                    <span><?= $order->count; ?></span>
                </div>
            </div>
            <div class="refund_block">
                <div class="form-group">
                    <label class="control-label">Subtotal: </label>
                    <span>$<?= $order->subtotal / 100; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Tip Percent: </label>
                    <span><?= $order->tip_per; ?>%</span>
                </div>
                <div class="form-group">
                    <label class="control-label">Tip Total: </label>
                    <span id="all_tip">$<?= $order->tip_summ / 100; ?></span>
                </div>
            </div>
            <div class="refund_block">
                <div class="form-group">
                    <label class="control-label">Tax: </label>
                    <span>$<?= $order->tax / 100; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Fees: </label>
                    <span id="all_fees">$<?= $order->fees / 100; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">Total: </label>
                    <span id="all_total">$<?= $order->total / 100; ?></span>
                </div>
            </div>
        </div>

        <? if ($order_variantions) {
            $i = 1; ?>
            <div class="refund_table">
                <div class="refund_table_row th">
                    <div class="refund_table_cell">#</div>
                    <div class="refund_table_cell"><a id="chek" data-value="all">Check All</a></div>
                    <div class="refund_table_cell">Refund,%</div>
                    <div class="refund_table_cell">Refund,$</div>
                    <div class="refund_table_cell">Item</div>
                    <div class="refund_table_cell">Quantity</div>
                    <div class="refund_table_cell">Amount</div>
                    <div class="refund_table_cell">Subtotal</div>
                    <div class="refund_table_cell">Total</div>
                    <div class="refund_table_cell">Refund Amount</div>
                </div>
                <? foreach ($order_variantions as $order_variantion) {
                    $subtotal = round($order_variantion['amount'] * $order_variantion['qty']) / 100;
                    $total = round($subtotal * (1 + $order_variantion['percentage'] / 100) + (100 * $subtotal / ($order->subtotal / 100)) * ($order->fees / 100) / 100, 2);
                    ?>
                    <div class="refund_table_row">
                        <div class="refund_table_cell"><?= $i; ?></div>
                        <div class="refund_table_cell"><input
                                    type="checkbox" <? if ($order_variantion['refund'] > 0) echo "checked"; ?>
                                    data-id="<?= $order_variantion['id']; ?>"></div>
                        <div class="refund_table_cell">
                            <div>
                                <input
                                        type="number"
                                        id="refund_persent"
                                        min="0" max="100"
                                        data-total="<?= $total; ?>"
                                    <? if ($order_variantion['refund'] == 0) echo 'disabled="disabled"'; ?>
                                        value="<? if ($order_variantion['refund_per'] > 0) echo $order_variantion['refund_per']; ?>"
                                        maxlength="3" data-id="<?= $order_variantion['id']; ?>">
                                <span>%</span>
                            </div>
                        </div>
                        <div class="refund_table_cell">
                            <div>
                                <span>$</span>
                                <input
                                        type="text" id="refund_dollar"
                                        min="0" max="<?= $total; ?>"
                                        value="<? if ($order_variantion['refund_dol'] > 0) echo $order_variantion['refund_dol'] / 100; ?>"
                                    <? if ($order_variantion['refund'] == 0) echo 'disabled="disabled"'; ?>
                                        data-id="<?= $order_variantion['id']; ?>">
                            </div>
                        </div>
                        <? if ($order_variantion['variation_name']) { ?>
                            <div class="refund_table_cell"><?= $order_variantion['name']; ?>
                                - <?= $order_variantion['variation_name']; ?></div>
                        <? } else { ?>
                            <div class="refund_table_cell"><?= $order_variantion['name']; ?></div>
                        <? } ?>
                        <div class="refund_table_cell"><?= $order_variantion['qty']; ?></div>
                        <div class="refund_table_cell">$<?= $order_variantion['amount'] / 100; ?></div>
                        <div class="refund_table_cell">$<?= $subtotal; ?></div>
                        <div class="refund_table_cell">$<?= $total; ?></div>
                        <div class="refund_table_cell"
                             data-id_return="<?= $order_variantion['id']; ?>"><? if ($order_variantion['refund'] > 0) echo "$" . $order_variantion['refund'] / 100; ?></div>
                    </div>
                    <? $i++;
                } ?>
            </div>
            <div class="form-group pull-right" style="margin-right: 5%;">
                <label class="control-label">Refund Total: </label>
                <span>$<span
                            id="refund_total"><? if ($order->refund > 0) echo $order->refund / 100; else echo "0.00"; ?></span></span>
            </div>
        <? } ?>
        <div class="form-group return_block_textarea">
            <label class="control-label">Money Back Reason: </label>
            <textarea class="refund_textarea" rows="5"><?= $order->refund_text; ?></textarea>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary">Return money</button>
        </div>
    </div>

<?php
/*
$js = <<<js

js;

$this->registerJs($js);*/

$this->registerJsFile('/modules/admin/views/orders/refund.js', [
    'depends' => [
        'yii\web\YiiAsset'
    ]]);
