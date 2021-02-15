<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Category;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;

class CategoryController extends AdminController
{
    public function actionIndex()
    {
        if ($this->user_role == 'admin') {
            $searchModel = new Category();
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
            $model = new Category();

            if ($model->load(Yii::$app->request->post())) {
                if (!$model->rank) {
                    $rank = Category::find()->select('rank')->orderBy('rank DESC')->asArray()->one();
                    $model->rank = $rank['rank'] + 1;
                }
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
            $model = Category::findOne($id);

            if ($model->load(Yii::$app->request->post())) {
                $post = Yii::$app->request->post();
                $model->name = $post['Category']['name'];
                $model->is_deleted = $post['Category']['is_deleted'];
                $model->square_id = $post['Category']['square_id'];
                if (!$post['Category']['rank']) {
                    $rank = Category::find()->select('rank')->orderBy('rank DESC')->asArray()->one();
                    $model->rank = $rank['rank'];
                }

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
            Category::findOne($id)->delete();
            return $this->redirect(['index']);
        } else {
            $this->redirect('/admin');
        }
    }
}
