<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Location_reader;
use yii\web\Controller;
use yii\data\ActiveDataProvider;


class Location_readerController extends AdminController
{
    public function actionIndex()
    {
        if ($this->user_role == 'admin') {
            $dataProvider = new ActiveDataProvider([
                'query' => Location_reader::find(),
                'sort' => [
                    'attributes' => [
                        'name', 'line1', 'city', 'state', 'country', 'postal_code'
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
            $model = new Location_reader();

            if ($model->load(Yii::$app->request->post())) {
                $id_stripe = $this->createLocationStripe(Yii::$app->request->post());
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
            $model = Location_reader::findOne($id);

            if ($model->load(Yii::$app->request->post())) {
                if ($this->updateLocationStripe(Yii::$app->request->post(), $model->id_stripe)) {
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
            $model = Location_reader::findOne($id);
            if ($this->deleteLocationStripe($model->id_stripe)) $model->delete();
            return $this->redirect(['index']);
        } else {
            $this->redirect('/admin');
        }
    }

    protected function createLocationStripe($arr)
    {
        $url = "https://api.stripe.com/v1/terminal/locations";

        $ch = curl_init();
        $post_data = 'display_name=' . $arr['Location_reader']['name'] . '&address[line1]=' . $arr['Location_reader']['line1'] . '&address[city]=' . $arr['Location_reader']['city'] . '&address[state]=' . $arr['Location_reader']['state'] . '&address[country]=' . $arr['Location_reader']['country'] . '&address[postal_code]=' . $arr['Location_reader']['postal_code'];

        $headers = [
            //"Content-type: text/plain",
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

    protected function updateLocationStripe($arr, $id_stripe)
    {
        $url = "https://api.stripe.com/v1/terminal/locations/" . $id_stripe;

        $ch = curl_init();
        $post_data = 'display_name=' . $arr['Location_reader']['name'] . '&address[line1]=' . $arr['Location_reader']['line1'] . '&address[city]=' . $arr['Location_reader']['city'] . '&address[state]=' . $arr['Location_reader']['state'] . '&address[country]=' . $arr['Location_reader']['country'] . '&address[postal_code]=' . $arr['Location_reader']['postal_code'];

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

    protected function deleteLocationStripe($id_stripe)
    {
        $url = "https://api.stripe.com/v1/terminal/locations/" . $id_stripe;

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
