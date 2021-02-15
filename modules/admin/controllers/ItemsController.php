<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Items;
use app\modules\admin\models\Variations;
use yii\web\UploadedFile;

class ItemsController extends AdminController
{
    public function actionIndex()
    {
        if ($this->user_role == 'admin') {
            $searchModel = new Items();
            $dataProvider = $searchModel->search(Yii::$app->request->get());

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionCreate()
    {
        if ($this->user_role == 'admin') {
            $item = new Items();

            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();
                $variations = json_decode($post['variations'], true);
                unset($post['variations']);
                $item->load($post);
                $item->is_deleted = $post['Items']['is_deleted'];
                $item->tax_ids = $post['Items']['tax_ids'];
                $item->category_id = $post['Items']['category_id'];
                $item->description = $post['Items']['description'];
                $item->related_items = json_encode($post['Items']['related_items']);
                $item->save();

                $id = $item->id;
                $model = Items::findOne($id);

                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/items/' . $id . "/"))
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/web/image/items/' . $id . "/", 0777);

                $model->image = UploadedFile::getInstance($model, 'image');

                if ($model->image) {
                    $model->upload($id);
                } else {
                    unset($model->image);
                }

                $model->save();

                if ($variations) {
                    foreach ($variations as $variation) {
                        $var = new Variations();
                        if (isset($variation['id'])) {
                            $var->id = $variation['id'];
                        }
                        if (isset($variation['square_id'])) {
                            $var->square_id = $variation['square_id'];
                        }
                        if (isset($variation['is_deleted'])) {
                            $var->is_deleted = $variation['is_deleted'];
                        }
                        if (isset($variation['present_at_all_locations'])) {
                            $var->present_at_all_locations = $variation['present_at_all_locations'];
                        }
                        if (isset($variation['present_at_location_ids'])) {
                            $var->present_at_location_ids = $variation['present_at_location_ids'];
                        }
                        $var->item_id = $id;
                        if (isset($variation['name'])) {
                            $var->name = $variation['name'];
                        }
                        if (isset($variation['amount'])) {
                            $var->amount = $variation['amount'];
                        }
                        $var->updated_at = date('Y-m-d H:i:s');
                        $var->save();
                    }
                }
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $item,
                ]);
            }
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionUpdate($id)
    {
        if ($this->user_role == 'admin') {
            $model = Items::findOne($id);

            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();

                $variations = json_decode($post['variations'], true);
                unset($post['variations']);
                $model->load($post);

                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/items/' . $id . "/"))
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/web/image/items/' . $id . "/", 0777);

                $model->image = UploadedFile::getInstance($model, 'image');

                if ($model->image) {
                    $model->upload($id);
                } else {
                    unset($model->image);
                }
                $model->is_deleted = $post['Items']['is_deleted'];
                $model->category_id = $post['Items']['category_id'];
                $model->tax_ids = $post['Items']['tax_ids'];
                $model->description = $post['Items']['description'];
                $model->related_items = json_encode($post['Items']['related_items']);
                $model->save();

                Variations::deleteAll('item_id = ' . $id);
                if ($variations) {
                    foreach ($variations as $variation) {
                        $var = new Variations();
                        if (isset($variation['id'])) {
                            $var->id = $variation['id'];
                        }
                        if (isset($variation['square_id'])) {
                            $var->square_id = $variation['square_id'];
                        }
                        if (isset($variation['is_deleted'])) {
                            $var->is_deleted = $variation['is_deleted'];
                        }
                        if (isset($variation['present_at_all_locations'])) {
                            $var->present_at_all_locations = $variation['present_at_all_locations'];
                        }
                        if (isset($variation['present_at_location_ids'])) {
                            $var->present_at_location_ids = $variation['present_at_location_ids'];
                        }
                        $var->item_id = $id;
                        if (isset($variation['name'])) {
                            $var->name = $variation['name'];
                        }
                        if (isset($variation['amount'])) {
                            $var->amount = $variation['amount'];
                        }
                        $var->updated_at = date('Y-m-d H:i:s');
                        $var->save();
                    }
                }
                return $this->redirect(['update', 'id' => $model->id]);
            } else {

                return $this->render('update', [
                    'model' => $model,
                    'variations' => json_encode(Variations::find()->where(['item_id' => $id])->asArray()->all()),
                ]);
            }
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionDelete($id)
    {
        if ($this->user_role == 'admin') {
            $this->delImageProd($id);
            Items::findOne($id)->delete();
            Variations::deleteAll('item_id = ' . $id);
            return $this->redirect(['index']);
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionDeleteimage()
    {
        if (yii::$app->user->identity->attributes['role'] == 'admin') {
            if (Yii::$app->request->isAjax) {
                $post = Yii::$app->request->post();
                $this->delImageProd($post['id']);
            }
        }
    }

    protected function delImageProd($id)
    {
        $model = Items::findOne($id);
        if ($model->image) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/items/' . $id . '/' . $model->image))
                unlink($_SERVER['DOCUMENT_ROOT'] . '/web/image/items/' . $id . '/' . $model->image);
            $model->image = '';
            $model->save();
        }
    }
}
