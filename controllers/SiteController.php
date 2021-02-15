<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;
use app\models\Reset;
use app\models\Registration;
use app\models\Profile;
use app\models\Role;
use yii\helpers\Html;

class SiteController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $this->event_log(Yii::t('app', 'Login'), Yii::t('app', 'Logged into personal account'));
                $this->redirect(\yii\helpers\Url::to(['/']));
            }

            $model->password = '';

            $this->layout = '@app/views/layouts/login';
            return $this->render('login', [
                'model' => $model,
            ]);

        } else {
            $this->redirect(\yii\helpers\Url::to(['/']));
        }
    }

    public function actionReset()
    {
        $model = new Reset();
        $this->layout = '@app/views/layouts/login';

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $password = $this->generate_password(8);

            if (isset($post['Reset']['username'])) {
                $user = User::find()->where(['username' => trim($post['Reset']['username'])])->one();
                if ($user) {
                    if ($user->del == 0) {
                        $massege = '<p><b>' . Yii::t('app', 'User Name') . '</b>: ' . $user->username . '</p>';
                        $massege .= '<p><b>' . Yii::t('app', 'Password') . '</b>: ' . htmlspecialchars($password) . '</p>';

                        if ($this->Mails($user['email'], Yii::t('app', 'Restore password'), $massege)) {
                            $user->password = \Yii::$app->security->generatePasswordHash($password);
                            $user->save();
                            $this->event_log(Yii::t('app', 'Edit'), Yii::t('app', 'Restore password'));
                            $this->redirect(\yii\helpers\Url::to(['/site/login']));
                        } else {
                            Yii::$app->session->setFlash('error_username', Yii::t('app', 'Something went wrong. Try again.'));
                            return $this->render('login_reset', [
                                'model' => $model,
                            ]);
                        }
                    } else {
                        Yii::$app->session->setFlash('error_username', yii::t('app', 'User deleted!'));
                        return $this->render('login_reset', [
                            'model' => $model,
                        ]);
                    }
                } else {
                    Yii::$app->session->setFlash('error_username', Yii::t('app', 'This user does not exist.'));
                    return $this->render('login_reset', [
                        'model' => $model,
                    ]);
                }
            }
            if (isset($post['Reset']['email'])) {
                if ($model->validate()) {
                    $user = User::find()->where(['email' => trim($post['Reset']['email'])])->one();
                    if ($user) {
                        $massege = '<b>' . Yii::t('app', 'User Name') . '</b>: ' . $user->username . '<br>';
                        $massege .= '<b>' . Yii::t('app', 'Password') . '</b>: ' . htmlspecialchars($password);

                        echo $user['email'] . "<br>" . Yii::t('app', 'Restore password') . "<br>" . $massege;
                        if ($this->Mails($user['email'], Yii::t('app', 'Restore password'), $massege)) {
                            $user->password = \Yii::$app->security->generatePasswordHash($password);
                            $user->save();
                            $this->event_log(Yii::t('app', 'Edit'), Yii::t('app', 'Restore password'));
                            $this->redirect(\yii\helpers\Url::to(['/site/login']));
                        } else {
                            Yii::$app->session->setFlash('error_email', Yii::t('app', 'Something went wrong. Try again.'));
                            return $this->render('login_reset', [
                                'model' => $model,
                            ]);
                        }
                    } else {
                        Yii::$app->session->setFlash('error_email', Yii::t('app', 'This user does not exist.'));
                        return $this->render('login_reset', [
                            'model' => $model,
                        ]);
                    }
                } else {
                    Yii::$app->session->setFlash('error_email', Yii::t('app', Yii::t('app', 'Invalid email address entered.')));
                    return $this->render('login_reset', [
                        'model' => $model,
                    ]);
                }
            }
        } else {
            return $this->render('login_reset', [
                'model' => $model,
            ]);
        }
    }

    public function actionRegistration()
    {
        $model = new Registration();
        $this->layout = '@app/views/layouts/login';
        $q = 0;
        if ($_GET) {
            $get = $_GET;
            $model->cabinet = $get['t'];
            $model->role = str_replace(' ', '+', $get['q']);
            $q = 1;
        }

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $password = trim($post['Registration']['password']);
            $second_password = trim($post['Registration']['second_password']);

            if ($password) {
                if ($password == $second_password) {

                    if (isset($post['Registration']['cabinet']) && isset($post['Registration']['role'])) {
                        $q = 1;
                        $cab = $post['Registration']['cabinet'];
                        $ro = $post['Registration']['role'];
                        $rol = $this->decodeData($post['Registration']['role']);
                        if (Role::findOne($rol)) $post['Registration']['role'] = $rol; else $post['Registration']['role'] = '';
                        if (!Registration::find()->where(['cabinet' => $post['Registration']['cabinet']])->one()) $post['Registration']['cabinet'] = '';
                        if (!$post['Registration']['cabinet'] || !$post['Registration']['role']) {
                            Yii::$app->session->setFlash('error_reg_link', Yii::t('app', 'An error has occurred. Please return to the received registration letter and follow the link again. If the same error occurs again, then contact the owner of the letter to re-generate the link.'));
                            pre($post);
                            $model->load($post);
                            $model->cabinet = $cab;
                            $model->role = $ro;
                            return $this->render('registration', [
                                'model' => $model,
                                'q' => 1,
                            ]);
                        }
                    }
                    $user_login = Registration::find()->select('id, del')->where(['username' => $post['Registration']['username']])->asArray()->one();
                    $user_mail = Registration::find()->select('id, del')->where(['email' => $post['Registration']['email']])->asArray()->one();
                    if (!$user_login && !$user_mail) {
                        $post['Registration']['password'] = \Yii::$app->security->generatePasswordHash($password);

                        $model->load($post);
                        $model->accessToken = \Yii::$app->security->generateRandomString();

                        if ($q == 0) {
                            $model->role = 1;
                            $t = 0;
                            while ($t == 0) {
                                $cabinet = $this->generate_cabinet(25);
                                $cab = Registration::find()->select('id')->where(['cabinet' => $cabinet])->asArray()->one();
                                if (!$cab) $t = 1;
                            }
                            $model->cabinet = $cabinet;
                        } else {
                            $model->role = $post['Registration']['role'];
                        }
                        if (isset($_SESSION['language'])) $model->language = $_SESSION['language'];
                        else $model->language = '';

                        if ($model->save()) {
                            $login = new LoginForm();
                            $log = is_array('');
                            $log['LoginForm']['username'] = $model->username;
                            $log['LoginForm']['password'] = $password;
                            $log['LoginForm']['rememberMe'] = 1;

                            if ($login->load($log) && $login->login()) {
                                $this->event_log(Yii::t('app', 'Sign Up'), Yii::t('app', 'Sign up in of personal account'));
                                $this->redirect(\yii\helpers\Url::to(['/']));
                            } else {
                                $model->password = $password;
                                $model->second_password = $second_password;
                                return $this->render('registration', [
                                    'model' => $model,
                                    'q' => $q,
                                ]);
                            }
                        } else {
                            $model->password = $password;
                            $model->second_password = $second_password;
                            return $this->render('registration', [
                                'model' => $model,
                                'q' => $q,
                            ]);
                        }
                    } else {
                        if ($user_login) {
                            if ($user_login['del'] == 1) {
                                Yii::$app->session->setFlash('error_login', Yii::t('app', 'This user is not eligible to register'));
                            } else {
                                Yii::$app->session->setFlash('error_login', Yii::t('app', 'A user with the same name already exists!'));
                            }
                        }
                        if ($user_mail) {
                            if ($user_mail['del'] == 1) {
                                Yii::$app->session->setFlash('error_email', Yii::t('app', 'This user is not eligible to register'));
                            } else {
                                Yii::$app->session->setFlash('error_email', Yii::t('app', 'A user with the same E-mail already exists!'));
                            }
                        }
                        $model->load($post);
                        return $this->render('registration', [
                            'model' => $model,
                            'q' => $q,
                        ]);
                    }
                } else {
                    Yii::$app->session->setFlash('error_passwords', Yii::t('app', 'Password mismatch!'));
                    $model->load($post);
                    return $this->render('registration', [
                        'model' => $model,
                        'q' => $q,
                    ]);
                }
            } else {
                Yii::$app->session->setFlash('error_passwords', Yii::t('app', 'Fill in all your passwords!'));
            }
        } else {
            return $this->render('registration', [
                'model' => $model,
                'q' => $q,
            ]);
        }
    }

    public function actionLogout()
    {
        $this->event_log(Yii::t('app', 'Log out'), Yii::t('app', 'Logged out of personal account'));
        Yii::$app->user->logout();

        $this->redirect(\yii\helpers\Url::to(['/site/login']));
    }

    public function actionProfile()
    {
        if (Profile::findOne(['id_user' => Yii::$app->user->identity['id']])) {
            $model = Profile::findOne(['id_user' => Yii::$app->user->identity['id']]);
        } else {
            $model = new Profile;
        }

        $email = Yii::$app->user->identity['email'];

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $user_mail = User::find()->select('id')->where('email ="' . $post['email'] . '" and id!=' . Yii::$app->user->identity['id'])->asArray()->one();

            if (!$user_mail) {
                $user_data = User::findOne(Yii::$app->user->identity['id']);
                $user_data->email = $post['email'];
                if ($user_data->save()) {
                    $email = $post['email'];
                    $model->load($post);
                    $model->id_user = Yii::$app->user->identity['id'];

                    if ($model->save()) {
                        $this->event_log(Yii::t('app', 'Edit'), Yii::t('app', 'Update Profile'));
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Save сhages!'));
                    } else {
                        Yii::$app->session->setFlash('error', Yii::t('app', 'Something went wrong. Try again.'));
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'A user with the same E-mail already exists!'));
            }
        }

        return $this->render('profile', [
            'model' => $model,
            'email' => $email,
        ]);
    }

    public function actionChange_password()
    {
        $model = User::findOne(Yii::$app->user->identity['id']);
        $post['password'] = '';
        $post['second_password'] = '';

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            if ($post['password'] && $post['second_password']) {
                if ($post['password'] == $post['second_password']) {
                    $model->password = Yii::$app->security->generatePasswordHash($post['password']);
                    if ($model->save()) {
                        $this->event_log(Yii::t('app', 'Edit'), Yii::t('app', 'Change password'));
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Save сhages!'));
                    } else {
                        Yii::$app->session->setFlash('error', Yii::t('app', 'Something went wrong. Try again.'));
                    }
                } else {
                    Yii::$app->session->setFlash('error_change', Yii::t('app', 'Password mismatch!'));
                }
            } else {
                Yii::$app->session->setFlash('error_change', Yii::t('app', 'Fill in all your passwords!'));
            }
        }

        return $this->render('change_password', [
            'model' => $post,
        ]);
    }

    public function actionInvitation()
    {
        $role = Role::find()->asArray()->all();
        $profile = Profile::find()->where(['id_user' => Yii::$app->user->identity['id']])->asArray()->one();
        $array_lang = is_array('');
        $lang = Yii::$app->language;
        $role_id = '';

        foreach (Yii::$app->getModule('languages')->languages as $key => $value) {
            $array_lang[$value] = $key;
        }

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            if ($post['variations']) {
                $arr = json_decode($post['variations'], true);
                $w = 0;
                foreach ($arr as $val) {
                    foreach ($array_lang as $key => $vall) {
                        if ($val['language'] == $vall) Yii::$app->language = $key;
                    }

                    foreach ($role as $rol) {
                        if ($rol['role'] == $val['role']) $role_id = $this->encodeData($rol['id']);
                    }

                    $massege = Yii::t('app', 'Hello.') . "<br>";
                    if ($profile) {
                        $t = 0;
                        if ($profile['name']) {
                            $massege .= $profile['name'] . " ";
                            $t = 1;
                        }
                        if ($profile['surname']) {
                            $massege .= $profile['surname'] . ' ';
                            $t = 1;
                        }

                        if ($t == 1) {
                            $massege .= Yii::t('app', 'invites') . ' ';
                        } else {
                            $massege .= Yii::t('app', 'Invite') . ' ';
                        }
                    } else {
                        $massege .= Yii::t('app', 'Invite') . ' ';
                    }

                    $massege .= Yii::t('app', 'you to register on the lstn.pro website for further collaboration.<br>To register, follow the') . ' ';
                    $massege .= '<a href="http://' . $_SERVER['SERVER_NAME'] . '/site/registration?t=' . Yii::$app->user->identity['cabinet'] . '&q=' . $role_id . '">' . Yii::t('app', 'link') . '</a>';
                    if ($this->Mails($val['email'], Yii::t('app', 'Registration Invitation'), $massege)) $w = 1;
                }
                Yii::$app->language = $lang;
                if ($w == 1) {
                    $this->event_log(Yii::t('app', 'Submit'), Yii::t('app', 'Invite members to a team'));
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Letters sent!'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'The letters did not go!'));
                }
            }
        }


        Yii::$app->language = $lang;

        return $this->render('invitation', [
            'role' => $role,
            'lang' => $array_lang,
        ]);
    }

    protected function generate_cabinet($number)
    {
        $arr = array('a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'v', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'R', 'S',
            'T', 'U', 'V', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6',
            '7', '8', '9', '0');
        // Генерируем пароль
        $pass = "";
        for ($i = 0; $i < $number; $i++) {
            // Вычисляем случайный индекс массива
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }
}
