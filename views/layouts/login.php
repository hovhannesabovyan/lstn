<?php

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link href="/css/admin.css" rel="stylesheet">
    </head>

    <body class="app header-fixed sidebar-fixed sidebar-lg-show">
    <?php $this->beginBody() ?>
    <div class="container" id="app">
        <div class="row align-items-center justify-content-center auth">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-block">
                        <?= $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage() ?>
