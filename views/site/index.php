<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Dashboard');
?>


<?php
$js = <<<JS
JS;
$this->registerJs($js);
?>