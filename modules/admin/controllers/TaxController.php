<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Tax;
use yii\web\Controller;
use yii\data\ActiveDataProvider;


class TaxController extends AdminController
{
    public function actionIndex()
    {
        if ($this->user_role == 'admin') {
            $dataProvider = new ActiveDataProvider([
                'query' => Tax::find(),
                'sort' => [
                    'attributes' => [
                        'name'
                    ]
                ],
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionCreate()
    {
        if ($this->user_role == 'admin') {
            $model = new Tax();

            if ($model->load(Yii::$app->request->post())) {

                $model->updated_at = date('Y-m-d H:i:s');

                if ($model->save()) return $this->redirect(['index']);
                else return $this->render('create', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionUpdate($id)
    {
        if ($this->user_role == 'admin') {
            $model = Tax::findOne($id);

            if ($model->load(Yii::$app->request->post())) {
                $post = Yii::$app->request->post();
                $model->name = $post['Tax']['name'];
                $model->square_id = $post['Tax']['square_id'];
                $model->percentage = $post['Tax']['percentage'];
                $model->is_deleted = $post['Tax']['is_deleted'];
                $model->updated_at = date('Y-m-d H:i:s');

                if ($model->save()) return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            $this->redirect('/admin');
        }
    }

    public function actionDelete($id)
    {
        if ($this->user_role == 'admin') {
            Tax::findOne($id)->delete();
            return $this->redirect(['index']);
        } else {
            $this->redirect('/admin');
        }
    }
}
