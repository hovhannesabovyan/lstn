<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Readers;
use yii\web\Controller;
use yii\data\ActiveDataProvider;


class ReadersController extends AdminController
{
    public function actionIndex()
    {
        if ($this->user_role == 'admin') {
            $dataProvider = new ActiveDataProvider([
                'query' => Readers::find(),
                'sort' => [
                    'attributes' => [
                        'label', 'id_location'
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
            $model = new Readers();

            if ($model->load(Yii::$app->request->post())) {
                $id_stripe = $this->createReaderStripe(Yii::$app->request->post());
                if ($id_stripe) {
                    $model->id_stripe = $id_stripe;

                    if ($model->save()) return $this->redirect(['index']);
                    else return $this->render('create', [
                        'model' => $model,
                    ]);
                } else return $this->render('create', [
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
            $model = Readers::findOne($id);

            if ($model->load(Yii::$app->request->post())) {
                if ($this->updateReaderStripe(Yii::$app->request->post(), $model->id_stripe)) {
                    if ($model->save()) return $this->redirect(['index']);
                    else return $this->render('update', [
                        'model' => $model,
                    ]);
                } else return $this->render('update', [
                    'model' => $model,
                ]);
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
            $model = Readers::findOne($id);
            if ($this->deleteReaderStripe($model->id_stripe)) $model->delete();
            return $this->redirect(['index']);
        } else {
            $this->redirect('/admin');
        }
    }

    protected function createReaderStripe($arr)
    {
        $url = "https://api.stripe.com/v1/terminal/readers";

        $ch = curl_init();
        $post_data = 'label=' . $arr['Readers']['label'];
        $post_data .= '&registration_code=' . $arr['Readers']['registration_code'];
        $post_data .= '&location=' . $arr['Readers']['id_location'];

        $headers = [
            'Authorization: Bearer sk_test_51GvdnfJE5CBtc9z8Pf2RNQnSYZeiZUkw6QvlLePy85IdEKSEHWR32bwPTXoT6G1Eq2jKsVsCOjUzD6EamvStpfN5003dBcEjO2'
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $t = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if (isset($t['id'])) return $t['id'];
        else return '';
    }

    protected function updateReaderStripe($arr, $id_stripe)
    {
        $url = "https://api.stripe.com/v1/terminal/readers/'" . $id_stripe . "'";

        $ch = curl_init();
        $post_data = 'label=' . $arr['Readers']['label'];
        $post_data .= '&registration_code=' . $arr['Readers']['registration_code'];
        $post_data .= '&location=' . $arr['Readers']['id_location'];

        $headers = [
            'Authorization: Bearer sk_test_51GvdnfJE5CBtc9z8Pf2RNQnSYZeiZUkw6QvlLePy85IdEKSEHWR32bwPTXoT6G1Eq2jKsVsCOjUzD6EamvStpfN5003dBcEjO2'
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $t = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if (isset($t['id'])) return $t['id'];
        else return '';
    }

    protected function deleteReaderStripe($id_stripe)
    {
        $url = "https://api.stripe.com/v1/terminal/readers/'" . $id_stripe . "'";

        $ch = curl_init();


        $headers = [
            'Authorization: Bearer sk_test_51GvdnfJE5CBtc9z8Pf2RNQnSYZeiZUkw6QvlLePy85IdEKSEHWR32bwPTXoT6G1Eq2jKsVsCOjUzD6EamvStpfN5003dBcEjO2'
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $t = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if (isset($t['deleted'])) return $t['deleted'];
        else return false;
    }
}
