<?php


namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Event_log;

class AppController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            if (strpos($_SERVER['REQUEST_URI'], 'site/login') !== false) {
                return parent::beforeAction($action);
            } elseif (strpos($_SERVER['REQUEST_URI'], 'site/reset') !== false) {
                return parent::beforeAction($action);
            } elseif (strpos($_SERVER['REQUEST_URI'], 'site/registration') !== false) {
                return parent::beforeAction($action);
            } elseif (strpos($_SERVER['REQUEST_URI'], 'languages') !== false) {
                return parent::beforeAction($action);
            } else $this->redirect('/site/login');
        } else {
            if (empty($_SESSION['language'])) {
                if (yii::$app->user->identity['language'])
                    $_SESSION['language'] = yii::$app->user->identity['language'];
            }
            if (yii::$app->user->identity['del'] == 1 || yii::$app->user->identity['block'] == 1) {
                $this->redirect(\yii\helpers\Url::to(['/site/logout']));
            }
            return parent::beforeAction($action);
        }
    }


    protected function Mails($mail_to, $subject, $massege)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . "/commands/PHPMailer/PHPMailerAutoload.php";

        $mail = new \PHPMailer;
        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;

        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'no-reply@lstn.pro';
        $mail->Password = 'Q3m-HUK-j2J-bb8';

        $mail->setFrom('no-reply@lstn.pro', 'LSTN');

        $mail->addAddress($mail_to, '');

        $mail->Subject = $subject;
        $mail->msgHTML($massege);

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    protected function generate_password($number)
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
            '7', '8', '9', '0', '.', ',',
            '(', ')', '[', ']', '!', '?',
            '&', '^', '%', '@', '*', '$',
            '<', '>', '/', '|', '+', '-',
            '{', '}', '`', '~');
        // Генерируем пароль
        $pass = "";
        for ($i = 0; $i < $number; $i++) {
            // Вычисляем случайный индекс массива
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

    protected function encodeData($plaintext)
    {
        if (!defined('ENCRYPTION_KEY')) define('ENCRYPTION_KEY', 'ab86d144xdfghe3f080b61c7c2e48');

        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, ENCRYPTION_KEY, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, ENCRYPTION_KEY, $as_binary = true);
        $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
        return $ciphertext;
    }

    protected function decodeData($ciphertext)
    {
        if (!defined('ENCRYPTION_KEY')) define('ENCRYPTION_KEY', 'ab86d144xdfghe3f080b61c7c2e48');

        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $plaintext = openssl_decrypt($ciphertext_raw, $cipher, ENCRYPTION_KEY, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, ENCRYPTION_KEY, $as_binary = true);
        if (hash_equals($hmac, $calcmac)) {
            return $plaintext;
        } else {
            return '';
        }
    }

    protected function event_log($act, $object)
    {
        $event_log = new Event_log();

        $event_log->id_user = yii::$app->user->identity['id'];
        $event_log->date = date('Y-m-d H:i:s');
        $event_log->act = $act;
        $event_log->object = $object;
        $event_log->save();
    }
}

function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
