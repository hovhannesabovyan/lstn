<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Items;
use app\modules\admin\models\Variations;
use app\modules\admin\models\Tax;
use Yii;
use app\modules\admin\models\Order;
use app\modules\admin\models\Order_variantions;
use yii\web\Controller;
use yii\data\ActiveDataProvider;


class OrdersController extends AdminController
{
    public function actionIndex()
    {
        $searchModel = new Order();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionRefund($id)
    {
        $order = Order::findOne($id);
        $order_variantions = Order_variantions::find()->where(['order_id' => $id])->asArray()->all();
        return $this->render('refund', [
            'order' => $order,
            'order_variantions' => $order_variantions,
        ]);
    }

    public function actionUpdate($id)
    {
        if ($this->user_role == 'admin' || $this->user_role == 'sales') {
            $order = Order::findOne($id);
            $order_variantions = Order_variantions::find()->where(['order_id' => $id])->asArray()->all();
            return $this->render('update', [
                'order' => $order,
                'order_variantions' => json_encode($order_variantions),
                'items' => Items::find()->where(['is_deleted' => 0])->asArray()->All(),
                'variations' => Variations::find()->where(['is_deleted' => 0])->asArray()->All(),
                'tax' => Tax::find()->where(['is_deleted' => 0])->asArray()->All(),
            ]);
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionUpdate_order()
    {
        if ($this->user_role == 'admin' || $this->user_role == 'sales') {
            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();

                $order = Order::findOne($post['order']['id']);
                $order->phone = $post['order']['phone'];
                $order->status = $post['order']['status'];
                $order->tip_per = $post['order']['tip_per'];
                $order->tip_summ = $post['order']['tip_summ'];
                $order->count = $post['order']['count'];
                $order->subtotal = $post['order']['subtotal'];
                $order->tax = round($post['order']['tax']);
                $order->fees = $post['order']['fees'];
                $order->total = $post['order']['total'];
                $order->save();

                foreach ($post['order_variations'] as $order_variations) {
                    if (isset($order_variations['id'])) {
                        $variation = Order_variantions::findOne($order_variations['id']);
                        $variation->order_id = $order_variations['order_id'];
                        $variation->product_id = $order_variations['product_id'];
                        $variation->name = $order_variations['name'];
                        $variation->tax_id = $order_variations['tax_id'];
                        $variation->percentage = $order_variations['percentage'];
                        $variation->qty = $order_variations['qty'];
                        $variation->amount = $order_variations['amount'];
                        $variation->variation_id = $order_variations['variation_id'];
                        $variation->variation_name = $order_variations['variation_name'];
                        $variation->refund = $order_variations['refund'];
                        $variation->refund_per = $order_variations['refund_per'];
                        $variation->refund_dol = $order_variations['refund_dol'];
                        $variation->save();
                    } else {
                        $variation = new Order_variantions();
                        $variation->order_id = $order_variations['order_id'];
                        $variation->product_id = $order_variations['product_id'];
                        $variation->name = $order_variations['name'];
                        $variation->tax_id = $order_variations['tax_id'];
                        $variation->percentage = $order_variations['percentage'];
                        $variation->qty = $order_variations['qty'];
                        $variation->amount = $order_variations['amount'];
                        $variation->variation_id = $order_variations['variation_id'];
                        $variation->variation_name = $order_variations['variation_name'];
                        $variation->save();
                    }
                }
                $this->redirect('/admin/orders');
            }
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionRefund_update()
    {
        if ($this->user_role == 'admin' || $this->user_role == 'sales') {
            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();

                $order = Order::findOne($post['id']);
                $order->refund = $post['refund_total'];
                $order->refund_text = $post['textarea'];
                $order->save();

                foreach ($post['arr'] as $arr) {
                    $variation = Order_variantions::findOne($arr['id']);
                    $variation->refund = round($arr['refund']);
                    if ($arr['refund_dol']) $variation->refund_dol = round($arr['refund_dol'], 2);
                    else $variation->refund_dol = 0;
                    if ($arr['refund_per']) $variation->refund_per = round($arr['refund_per'], 2);
                    else $variation->refund_per = 0;
                    $variation->save();
                }
            }
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionAmount()
    {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $variations = Variations::find()->select('id, amount')->where(['item_id' => $post['id'], 'is_deleted' => 0])->asArray()->All();

            return json_encode($variations);
        }
    }

    public function actionUpdate_status()
    {
        if ($this->user_role == 'admin' || $this->user_role == 'sales') {
            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();
                $order = Order::findOne($post['id']);
                $order->status = $post['status'];
                $order->save();
            }
        } else {
            $this->redirect('/admin');
        }
    }
}
