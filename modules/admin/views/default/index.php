<?php
$this->title = 'Dashboard';
?>

<div class="admin-default-index container">
    <? if (yii::$app->user->identity->attributes['role'] == 'admin') echo \Yii::$app->security->generatePasswordHash('Labonne-2018!');
    //\app\modules\admin\controllers\pre();?>
</div>
