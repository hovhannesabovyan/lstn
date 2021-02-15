<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\admin\models\Pages;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,700">

    </head><!--/head-->

    <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="/" target="_blank" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>Site</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Site</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <!--a href="#" class="dropdown-toggle" data-toggle="dropdown"-->
                            <a href="<?= \yii\helpers\Url::to(['/site/logout']) ?>">
                                <span class="hidden-xs">Sign out</span>
                            </a>
                            <!--ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                    <p>
                                        Alexander Pierce - Web Developer
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Followers</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Sales</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Friends</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul-->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <? if (yii::$app->user->identity->attributes['role'] == 'admin') { ?>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin/category']) ?>"><i class="fa fa-list"></i> <span>Category</span></a>
                        </li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin/items']) ?>"><i class="fa fa-th"></i>
                                <span>Items</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin/tax']) ?>"><i class="fa fa-book"></i>
                                <span>Tax</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin/location_reader']) ?>"><span
                                        class="glyphicon glyphicon-map-marker"></span>
                                <span>Location a reader</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin/readers']) ?>"><i class="fa fa-credit-card"></i>
                                <span>Registering a reader</span></a></li>
                    <? } ?>
                    <li><a href="<?= \yii\helpers\Url::to(['/admin/orders']) ?>"><i class="fa fa-list"></i>
                            <span>Orders</span></a></li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= Html::encode($this->title) ?>
                </h1>
                <!--ol-- class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol-->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <?= $content; ?>
                </div>
                <!-- /.row -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">

        </footer>
    </div>
    <?php $this->endBody() ?>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/dist/js/adminlte.min.js"></script>
    </html>
<?php $this->endPage() ?>
