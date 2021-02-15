<?php


namespace app\controllers;


use app\components\Common;
use app\models\Artist;
use app\models\Artist_form;
use app\models\Label;
use arogachev\excel\import\basic\Importer;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use yii\web\UploadedFile;
use Yii;

class ArtistController extends AppController
{
    public function actionIndex()
    {
        $searchModel = new Artist();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new Artist_form();

        if ($model->load(Yii::$app->request->post())) {
            $model->cabinet_id = yii::$app->user->identity['cabinet'];
            $model->user_id = yii::$app->user->identity['id'];
            $model->save();

            $id = $model->id;
            if ($id) {
                $img = Artist_form::findOne($id);

                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/artist/' . $id . "/"))
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/web/image/artist/' . $id . "/", 0755);

                $img->image = UploadedFile::getInstance($img, 'image');

                if ($img->image) {
                    $img->upload($id);
                } else {
                    unset($img->image);
                }

                $img->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('create', compact('model'));
            }
        }

        return $this->render('create', compact('model'));
    }

    public function actionEdit($id)
    {
        $model = Artist_form::findOne($id);
        $image = $model->image;
        if ($model->load(Yii::$app->request->post())) {
            $model->save();

            $id = $model->id;
            if ($id) {
                $img = Artist_form::findOne($id);

                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/artist/' . $id . "/"))
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/web/image/artist/' . $id . "/", 0755);
                if ($image != $img->image)
                    $img->image = UploadedFile::getInstance($img, 'image');

                if ($img->image) {
                    $img->upload($id);
                } else {
                    unset($img->image);
                }

                $img->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('create', compact('model'));
            }
        }

        return $this->render('edit', compact('model'));
    }

    public function actionDeleteimage()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $this->delImageProd($post['id']);
        }
    }

    public function actionDelete($id)
    {
        $this->delImageProd($id);
        Artist_form::findOne($id)->delete();
        return $this->redirect(['index']);
    }

    protected function delImageProd($id)
    {
        $model = Artist_form::findOne($id);
        if ($model->image) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/image/artist/' . $id . '/' . $model->image))
                unlink($_SERVER['DOCUMENT_ROOT'] . '/web/image/artist/' . $id . '/' . $model->image);
            $model->image = '';
            $model->save();
        }
    }

    public function actionImport()
    {
        $error = '';

        if (Yii::$app->request->isPost) {
            if (!isset($_FILES['import']['tmp_name']) or !$_FILES['import']['tmp_name']) {
                $error = 'Не передан файл импорта';
            } else {
                $filePath = $_FILES['import']['tmp_name'];

                ini_set('max_execution_time', 900);
                $excel = $this->parse($filePath);

                $sheetCount = $excel->getSheetCount();

                // Проверяем кол-во листов
                if ($sheetCount != 1) {
                    $error = 'Неверное кол-во листов<br>(должно быть 1)<br>Кол-во листов: ' . $sheetCount;
                }
            }
            if ($error) {
                return $this->render('index', [
                    'error' => $error
                ]);
            } else {
                $currentSheet = $excel->getSheet(0);
                $allProcessors = $this->getAllProcessors($currentSheet);

               $query= Yii::$app->db->createCommand()->batchInsert('tbl_artist', Artist::getWritableColumns(), $allProcessors);
               if ($query->execute()) {
                   Yii::$app->session->setFlash('success_import',Yii::t('app','Success Import'));
                   return  $this->redirect('/artist/index');
               }

            }
        }

    }

    // Парсинг Excel файла
    private function parse($filePath)
    {
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $sheet = $reader->load($filePath);

        return $sheet;
    }

    // Получить все процессоры
    private function getAllProcessors($currentSheet)
    {
        $cells = $currentSheet->getCellCollection();
        $values = [];

        // Далее перебираем все заполненные строки (столбцы B - O)
        for ($row = 2; $row <= $cells->getHighestRow(); $row++) {

            $string = [];

            foreach (range('A', 'Q') as $iCol) {
                $cell = $cells->get($iCol . $row);

                if ($cell) {
                    $string[] = $cell->getValue();
                } else {
                    $string[] = '';
                }
            }

            // Добавляем валюту по умолчанию
            $string[] = Yii::$app->user->identity['cabinet'];
            $string[] = Yii::$app->user->identity->id;
            $string[] = '';
            $values[] = $string;
        }

        return $values;
    }
}
