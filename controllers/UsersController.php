<?php


namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\Users_form;
use app\models\Profile;
use app\models\Role;
use app\models\Event_log;


class UsersController extends AppController
{

    public function actionIndex()
    {
        $searchModel = new Users();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new Users_form();

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $user = Users_form::find()->where(['username' => $post['Users_form']['username']])->one();
            $mail = Users_form::find()->where(['email' => $post['Users_form']['email']])->one();

            if (!$user && !$mail) {
                $password = $this->generate_password(8);

                $model->load($post);
                $model->password = Yii::$app->security->generatePasswordHash($password);
                $model->accessToken = Yii::$app->security->generateRandomString();
                $model->cabinet = yii::$app->user->identity['cabinet'];
                if ($model->save()) {
                    $massege = '<p>' . Yii::t('app', 'Hello.') . '</p>';
                    $massege .= '<p>' . Yii::t('app', 'You have been registered on the lstn.pro website. To log in, go to ');
                    $massege .= '<a href="http://' . $_SERVER['SERVER_NAME'] . '/site/login">' . Yii::t('app', 'link') . '</a></p>';
                    $massege .= '<p><b>' . Yii::t('app', 'User Name') . '</b>: ' . $model->username . '</p>';
                    $massege .= '<p><b>' . Yii::t('app', 'Password') . '</b>: ' . $password . '</p>';
                    $this->event_log(Yii::t('app', 'Add'), Yii::t('app', 'Create User') . ' (' . $model->username . ')');

                    if ($this->Mails($model->email, Yii::t('app', 'LSTN invite'), $massege)) {
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Letter sent!'));
                        $model = new Users_form();
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    } else {
                        Yii::$app->session->setFlash('error', Yii::t('app', 'The letter did not go!'));
                    }
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Something went wrong. Try again.'));
                    $model->load($post);
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            } else {
                if ($user) {
                    Yii::$app->session->setFlash('error_login', Yii::t('app', 'A user with the same name already exists!'));
                }
                if ($mail) {
                    Yii::$app->session->setFlash('error_email', Yii::t('app', 'A user with the same E-mail already exists!'));
                }
                $model->load($post);
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $user = Users_form::findOne($id);
        $role = Role::find()->asArray()->all();
        $model = Profile::findOne(['id_user' => $id]);
        if (!$model) {
            $model = new Profile();
        }

        $rol = is_array('');
        foreach ($role as $value) {
            $rol[$value['id']] = $value['role'];
        }

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $user->load($post);
            $model->load($post);
            $model->id_user = $id;
            $t = 0;
            if ($user->save()) $t = 1;
            if ($model->save()) $t = 1;

            if ($t == 1) Yii::$app->session->setFlash('success', Yii::t('app', 'Save сhages!'));
            else Yii::$app->session->setFlash('error', Yii::t('app', 'Something went wrong. Try again.'));
        }


        return $this->render('edit', [
            'user' => $user,
            'model' => $model,
        ]);
    }

    public function actionLock($id)
    {
        $user = Users::findOne($id);
        if ($user) {
            if ($user->block == 1) $user->block = 0;
            else $user->block = 1;

            if ($user->save()) {
                if ($user->block == 1) {
                    $this->event_log(Yii::t('app', 'Block'), Yii::t('app', 'The user is blocked!') . ' (' . $user->username . ')');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'The user is blocked!'));
                } else {
                    $this->event_log(Yii::t('app', 'Unblock'), Yii::t('app', 'The user is unblocked!') . ' (' . $user->username . ')');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'The user is unblocked!'));
                }
            } else Yii::$app->session->setFlash('error', Yii::t('app', 'Something went wrong. Try again.'));
        } else Yii::$app->session->setFlash('error', Yii::t('app', 'Something went wrong. Try again.'));
        $this->redirect(\yii\helpers\Url::to(['users/index']));
    }

    public function actionDelete($id)
    {
        $user = Users::findOne($id);
        if ($user) {
            if ($user->del == 1) $user->del = 0;
            else $user->del = 1;

            if ($user->save()) {
                if ($user->del == 1) {
                    $this->event_log(Yii::t('app', 'Delete'), Yii::t('app', 'User deleted!') . ' (' . $user->username . ')');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'User deleted!'));
                } else {
                    $this->event_log(Yii::t('app', 'Restore'), Yii::t('app', 'User restore!') . ' (' . $user->username . ')');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'User restore!'));
                }
            } else Yii::$app->session->setFlash('error', Yii::t('app', 'Something went wrong. Try again.'));
        } else Yii::$app->session->setFlash('error', Yii::t('app', 'Something went wrong. Try again.'));
        $this->redirect(\yii\helpers\Url::to(['users/index']));
    }

    public function actionBlack_list()
    {
        $searchModel = new Users();
        $dataProvider = $searchModel->search_black(Yii::$app->request->get());

        return $this->render('black_list', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionEvent_log($id = '')
    {
        $searchModel = new Event_log();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), $id);

        return $this->render('event_log', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
