<?php

namespace app\controllers;

use app\components\Common;
use app\models\Country;
use app\models\Releases;
use app\models\Releases_form;
use app\models\Track_release;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use Yii;

class ReleasesController extends AppController
{
    public function actionIndex()
    {
        $searchModel = new Releases();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new Releases_form();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->create_date = date('Y-m-d');
            $model->cabinet_id = yii::$app->user->identity['cabinet'];
            $model->user_id = yii::$app->user->identity['id'];
            $model->artist_name = json_encode($post['Releases_form']['artist_name']);

            if ($post['Releases_form']['exclusive_date']) {
                $model->exclusive_date = $post['Releases_form']['exclusive_date'];
            } else {
                $model->exclusive_date = date('Y-m-d');
            }
            $model->save();

            $id = $model->id;

            if ($id) {
                $img = Releases_form::findOne($id);

                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . "/"))
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . "/", 0755);

                $img->release_logo = UploadedFile::getInstance($img, 'release_logo');

                if ($img->release_logo) {
                    $img->upload($id);
                } else {
                    unset($img->release_logo);
                }

                $img->cover_image = UploadedFile::getInstance($img, 'cover_image');
                if ($img->cover_image) {
                    $img->upload2($id);
                } else {
                    unset($img->cover_image);
                }

                $img->save();

                return $this->redirect(['tracks/create', 'id' => $model->id]);

            } else {
                return $this->render('create', compact('model'));
            }
        }

        return $this->render('create', compact('model'));
    }

    public function actionEdit($id)
    {
        $model = Releases_form::findOne($id);
        $model->artist_name = json_decode($model->artist_name, true);
        $model->territory_selection = json_decode($model->territory_selection, true);
        if ($model->exclusive_date == '0000-00-00') $model->exclusive_date = '';
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $r_type = $post['Releases_form']['release_type'];

            $data = Releases::find()->where(['tbl_releases.id' => $id])->joinWith('tracks')->asArray()->one();

            if ($r_type == 1 && count($data['tracks']) >= 5) {
                Yii::$app->session->setFlash('error_edit_rel', 'Вы не можете менять тип , пока не удалили треков ');
            }
            if ($r_type == 2 && count($data['tracks']) >= 20) {
                Yii::$app->session->setFlash('error_edit_rel', 'Вы не можете менять тип , пока не удалили треков ');
            }
            if ($r_type == 3 && count($data['tracks']) >= 20) {
                Yii::$app->session->setFlash('error_edit_rel', 'Вы не можете менять тип , пока не удалили треков ');
            } else {
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . "/"))
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . "/", 0755);

                $model->release_logo = UploadedFile::getInstance($model, 'release_logo');

                if ($model->release_logo) {
                    $model->upload($id);
                } else {
                    unset($model->release_logo);
                }

                $model->cover_image = UploadedFile::getInstance($model, 'cover_image');
                if ($model->cover_image) {
                    $model->upload2($id);
                } else {
                    unset($model->cover_image);
                }
                $model->artist_name = json_encode($post['Releases_form']['artist_name']);
                $model->territory_selection = json_encode($post['Releases_form']['territory_selection']);
               if ($model->save()) {
                   Yii::$app->db->createCommand()->update('tbl_releases', ['ftp_status' => 1], 'id = \'' . $id . '\'')->execute();
               }
                return $this->redirect(['index']);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Track_release::find()->where(['releases_id' => $id])
        ]);

        return $this->render('edit', compact('model', 'dataProvider'));
    }

    public function actionDeleteimage()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $this->delImageProd($post['id']);
        }
    }

    public function actionDeletelogo()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $this->delLogoProd($post['id']);
        }
    }

    public function actionDelete($id)
    {
        $this->delImageProd($id);
        $this->delLogoProd($id);
        Releases_form::findOne($id)->delete();
        return $this->redirect(['index']);
    }

    protected function delLogoProd($id)
    {
        $model = Releases_form::findOne($id);
        if ($model->release_logo) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . '/' . $model->release_logo))
                unlink($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . '/' . $model->release_logo);
            $model->release_logo = '';
            $model->save();
        }
    }

    protected function delImageProd($id)
    {
        $model = Releases_form::findOne($id);
        if ($model->cover_image) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . '/' . $model->cover_image))
                unlink($_SERVER['DOCUMENT_ROOT'] . '/web/image/releases/' . $id . '/' . $model->cover_image);
            $model->cover_image = '';
            $model->save();
        }
    }

    public function actionXml($id)
    {
        if ($id) {
            $xml_header = '<?xml version="1.0"?>';

            $ftp = new \yii2mod\ftp\FtpClient();

            $host = 'u220909.your-storagebox.de';
            $login = 'u220909-sub16';
            $password = 'yb87vMxFXeBHU1Jh';
            $ftp->connect($host);
            $ftp->login($login, $password);


            $release = Releases::find()
                ->joinWith('tracks')
                ->where(['tbl_releases.id' => $id])->asArray()->one();

            $country = Country::find()->asArray()->all();

            if (empty($release['tracks'])) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Not tracks'));
                return $this->redirect($_SERVER['HTTP_REFERER']);
            }

            $data = $this->renderPartial('xml', [
                'release' => $release,
                'country' => $country,
                'xml_header' => $xml_header
            ]);

            $root = "image/releases/" . $id . "/tracks";


            copy('image/releases/'.$id.'/'.$release['release_logo'],'image/releases/'.$id.'/tracks/'.$release['release_logo']);

            if ($release['ftp_status'] === '0') {
                $createFtpDirectory = '/' . $release['label'] . ' - ' . date("Y-m-d") . ' - created';
            } elseif ($release['ftp_status'] === '1') {
                $createFtpDirectory = '/' . $release['label'] . ' - ' . date("Y-m-d") . ' - updated';
            } elseif ($release['ftp_status'] === '2') {
                $createFtpDirectory = '/' . $release['label'] . ' - ' . date("Y-m-d") . ' - deleted';
            }

            $renderXml = fopen("image/releases/" . $id . "/tracks/" . $release['cabinet_id'] . ".xml", "w") or die("Unable to open file!");
            fopen("image/releases/" . $id . "/tracks/" .  "delivery.complete", "w") or die("Unable to open file!");
            fwrite($renderXml, $data);

            $ftp->mkdir($createFtpDirectory);

            if ($ftp->putAll($root, $createFtpDirectory)) {
                $ftp->put($root_i, $createFtpDirectory,FTP_IMAGE);

                Yii::$app->session->setFlash('success', Yii::t('app', 'Success upload'));
                return $this->redirect($_SERVER['HTTP_REFERER']);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error upload'));
                return $this->redirect($_SERVER['HTTP_REFERER']);
            }

        } else {
            throw new HttpException('404');
        }

    }
}
