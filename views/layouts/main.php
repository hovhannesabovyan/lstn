<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\Menu;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">

        <title><?= Html::encode($this->title) ?></title>
        
        <?= Html::csrfMetaTags() ?>
        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css"
              href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <!-- Material Kit CSS -->
        <link href="/css/material-dashboard.css?v=2.1.2" rel="stylesheet"/>
        <link href="/css/ionicons.min.css" rel="stylesheet"/>
        <link href="/css/stylesheet.css?n=<?= date('His'); ?>" rel="stylesheet"/>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="wrapper ">
        <div class="sidebar" data-color="purple" data-background-color="white">
            <!--
            Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

            Tip 2: you can also add an image using data-image tag
        -->
            <div class="logo">
                <a href="<?= \yii\helpers\Url::to(['/']); ?>" class="simple-text logo-mini">
                    LSTN
                </a>
            </div>
            <div class="sidebar-wrapper">
                <?
                echo Menu::widget([
                    'items' => [
                        ['label' => Yii::t('app', 'Dashboard'),
                            'url' => ['site/index'],
                            'options' => ['class' => 'nav-item'],
                            'template' => '<a class="nav-link" href="{url}"><i class="material-icons">dashboard</i><p>{label}</p></a>',
                        ],
                        ['label' => Yii::t('app', 'Artists'),
                            'url' => ['artist/index'],
                            'options' => ['class' => 'nav-item'],
                            'template' => '<a class="nav-link" href="{url}"><i class="fa fa-fw fa-microphone"></i><p>{label}</p></a>',
                        ],
                        ['label' => Yii::t('app', 'Labels'),
                            'url' => ['label/index'],
                            'options' => ['class' => 'nav-item'],
                            'template' => '<a class="nav-link" href="{url}"><i class="fa fa-fw fa-image"></i><p>{label}</p></a>',
                        ],
                        ['label' => Yii::t('app', 'Releases'),
                            'url' => ['releases/index'],
                            'options' => ['class' => 'nav-item'],
                            'template' => '<a class="nav-link" href="{url}"><i class="fa fa-play-circle"></i><p>{label}</p></a>',
                        ],
                        ['label' => Yii::t('app', 'Users'),
                            'url' => ['users/index'],
                            'options' => ['class' => 'nav-item'],
                            'template' => '<a class="nav-link" href="{url}"><i class="fa fa-fw fa-users"></i><p>{label}</p></a>',
                        ],
                    ],
                    'options' => [
                        'class' => 'nav',
                    ],
                    'activeCssClass' => 'active',
                    'submenuTemplate' => "\n<ul class='nav'>\n{items}\n</ul>\n",
                ]);
                ?>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-brand" href="javascript:;"><?= Html::encode($this->title) ?></div>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person</i>
                                    <p class="d-lg-none d-md-block">
                                        Account
                                    </p>
                                    <div class="ripple-container"></div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item"
                                       href="<?= \yii\helpers\Url::to(['/site/profile']); ?>"><?= Yii::t('app', 'Profile'); ?></a>
                                    <a class="dropdown-item"
                                       href="<?= \yii\helpers\Url::to(['/site/change_password']); ?>"><?= Yii::t('app', 'Change password'); ?></a>
                                    <a class="dropdown-item"
                                       href="<?= \yii\helpers\Url::to(['/users/event_log']); ?>"><?= Yii::t('app', 'Event log'); ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                       href="<?= \yii\helpers\Url::to(['/site/logout']); ?>"><?= Yii::t('app', 'Log out'); ?></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <?= $content; ?>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid" style="display: flex; justify-content: space-between;">
                    <?= app\modules\languages\widgets\ListWidget::widget() ?>
                    <div class="copyright float-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                    </div>
                    <!-- your footer here -->
                </div>
            </footer>
        </div>
    </div>

    <div class="modal modal-success fade in" id="modal-success" style="padding-right: 17px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="background-color: #00a65a !important;">
                    <? if (Yii::$app->session->hasFlash('success')) { ?>
                        <p style="color: white"><?= Yii::$app->session->getFlash('success'); ?></p>
                    <? } ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-success fade in" id="modal-error" style="padding-right: 17px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="background-color: #dd4b39 !important;">
                    <? if (Yii::$app->session->hasFlash('error')) { ?>
                        <p style="color: white"><?= Yii::$app->session->getFlash('error'); ?></p>
                    <? } ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <?php $this->endBody() ?>

    <script src="/js/core/popper.min.js"></script>
    <script src="/js/core/bootstrap-material-design.min.js"></script>
    <script src="/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="/js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="/js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="/js/plugins/arrive.min.js"></script>
    <!-- Chartist JS -->
    <script src="/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <!--script src="/demo/demo.js"></script-->
    <? if (Yii::$app->session->hasFlash('success')) { ?>
        <script>
            $(document).ready(function () {
                $('#modal-success').modal('show');
                setTimeout(function () {
                    $('#modal-success').modal('hide');
                }, 3000);
            });
        </script>
    <? } ?>
    <? if (Yii::$app->session->hasFlash('error')) { ?>
        <script>
            $(document).ready(function () {
                $('#modal-error').modal('show');
                setTimeout(function () {
                    $('#modal-error').modal('hide');
                }, 3000);
            });
        </script>
    <? } ?>
    <script>
        $(document).ready(function () {
            $().ready(function () {
                $sidebar = $('.sidebar');

                $sidebar_img_container = $sidebar.find('.sidebar-background');

                $full_page = $('.full-page');

                $sidebar_responsive = $('body > .navbar-collapse');

                window_width = $(window).width();

                fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                $('.grid-view').addClass('table-responsive');
                $('.table-responsive').removeClass('grid-view');

                if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                    if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                        $('.fixed-plugin .dropdown').addClass('open');
                    }

                }

                $('.fixed-plugin a').click(function (event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .active-color span').click(function () {
                    $full_page_background = $('.full-page-background');

                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-color', new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data-color', new_color);
                    }
                });

                $('.fixed-plugin .background-color .badge').click(function () {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('background-color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });

                $('.fixed-plugin .img-holder').click(function () {
                    $full_page_background = $('.full-page-background');

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function () {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function () {
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            $full_page_background.fadeIn('fast');
                        });
                    }

                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                    }
                });

                $('.switch-sidebar-image input').change(function () {
                    $full_page_background = $('.full-page-background');

                    $input = $(this);

                    if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar_img_container.fadeIn('fast');
                            $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page_background.fadeIn('fast');
                            $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                    } else {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar.removeAttr('data-image');
                            $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page.removeAttr('data-image', '#');
                            $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                    }
                });

                $('.switch-sidebar-mini input').change(function () {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function () {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function () {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function () {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });
            });

            $('.languages-klisl').css({'max-width': '200px', 'margin': 'auto 0'})
        });
    </script>
    </body>
    </html>
<?php $this->endPage() ?>
