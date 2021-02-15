<?php


namespace app\controllers;


use app\components\Common;
use app\components\Request;
use app\models\Releases;
use app\models\Track_release;
use yii\base\Component;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use Yii;

class TracksController extends AppController
{
    public function actionIndex($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Track_release::find()->where(['releases_id' => $id]),
            /*'sort' => [
                'attributes' => [
                    'name'
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],*/
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($id)
    {
        $model = new Track_release();

        $releases = Releases::find()
            ->joinWith('tracks')
            ->where(['tbl_releases.id' => $id])->asArray()->one();

        if ($releases['release_type'] === "1") {
            $countTrack = count($releases['tracks']);
            if ($countTrack >= 1) {
                Yii::$app->session->setFlash('error_add_track', Yii::t('app', 'You cant add tracks, the limit is exceeded'));
            }
        } elseif ($releases['release_type'] === "2") {
            $countTrack = count($releases['tracks']);
            if ($countTrack >= 5) {
                Yii::$app->session->setFlash('error_add_track', Yii::t('app', 'You cant add tracks, the limit is exceeded'));
            }
        } elseif ($releases['release_type'] === "3") {
            $countTrack = count($releases['tracks']);
            if ($countTrack >= 20) {
                Yii::$app->session->setFlash('error_add_track', Yii::t('app', 'You cant add tracks, the limit is exceeded'));
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->releases_id = $id;

            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . "/tracks/"))
                mkdir($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . "/tracks/", 0755);

            $model->track = UploadedFile::getInstance($model, 'track');

            if ($model->track) {
                $model->upload($id);
            } else {
                unset($model->track);
            }

            $model->save();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Track_release::find()->where(['releases_id' => $id]),
        ]);

        return $this->render('create', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = Track_release::findOne($id);

        $dataProvider = new ActiveDataProvider([
            'query' => Track_release::find()->where(['releases_id' => $id]),
        ]);

        return $this->render('create', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Track_release::find()->where(['tbl_track_releases.id' => $id])->joinWith('releases')->asArray()->one();

        if ($model['track']) {
            Track_release::findOne($id)->delete();
            if (file_exists('image/releases/' . $model['releases']['id'] . '/tracks/' . $model['track'])) {
                if (unlink('image/releases/' . $model['releases']['id'] . '/tracks/' . $model['track'])) {
                    return $this->redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Something went wrong. Try again.'));
        }
    }

    protected function delTrack($id)
    {
        $model = Track_release::findOne($id);
        if ($model->track) {
            if (file_exists('image/releases/' . $id . '/tracks/' . $model->track))
                if (unlink('image/releases/' . $id . '/tracks/' . $model->track)) return true;
        }
    }
}
