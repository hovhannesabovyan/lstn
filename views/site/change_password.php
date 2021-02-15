<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Change password');
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title"><?= Yii::t('app', 'Change password'); ?></h4>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Password'); ?></label>
                            <input type="password" name="password" class="form-control"
                                   value="<?= $model['password']; ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Confirm password'); ?></label>
                            <input type="password" name="second_password" value="<?= $model['second_password']; ?>"
                                   class="form-control">
                        </div>
                    </div>
                    <? if (Yii::$app->session->hasFlash('error_change')) { ?>
                        <div class="col-md-12">
                            <p style="color: red; font-size: 18px;"><?= Yii::$app->session->getFlash('error_change'); ?></p>
                        </div>
                    <? } ?>
                </div>
                <button type="submit"
                        class="btn btn-primary pull-right"><?= Yii::t('app', 'Change password'); ?></button>
                <div class="clearfix"></div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <!--div class="col-md-4">
        <div class="card card-profile">
            <div class="card-avatar">
                <a href="javascript:;">
                    <img class="img" src="/image/faces/marc.jpg" />
                </a>
            </div>
            <div class="card-body">
                <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                <h4 class="card-title">Alec Thompson</h4>
                <p class="card-description">
                    Don't be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...
                </p>
                <a href="javascript:;" class="btn btn-primary btn-round">Follow</a>
            </div>
        </div>
    </div-->
</div>
