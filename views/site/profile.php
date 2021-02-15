<?php

use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Profile');
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title"><?= Yii::t('app', 'Edit Profile'); ?></h4>
                <p class="card-category"><?= Yii::t('app', 'Complete your profile'); ?></p>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Company'); ?></label>
                            <input type="text" name="Profile[company]" class="form-control"
                                   value="<?= $model->company; ?>">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Email address'); ?></label>
                            <input type="email" name="email" value="<?= $email; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Fist Name'); ?></label>
                            <input type="text" name="Profile[name]" class="form-control" value="<?= $model->name; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Last Name'); ?></label>
                            <input type="text" name="Profile[surname]" class="form-control"
                                   value="<?= $model->surname; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Address'); ?></label>
                            <input type="text" name="Profile[address]" class="form-control"
                                   value="<?= $model->address; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'City'); ?></label>
                            <input type="text" name="Profile[city]" class="form-control" value="<?= $model->city; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Country'); ?></label>
                            <input type="text" name="Profile[country]" class="form-control"
                                   value="<?= $model->country; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= Yii::t('app', 'Postal Code'); ?></label>
                            <input type="text" name="Profile[postal_code]" class="form-control"
                                   value="<?= $model->postal_code; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= Yii::t('app', 'About Me'); ?></label>
                            <div class="form-group">
                                <label class="bmd-label-floating"><?= Yii::t('app', 'Tell us about yourself!'); ?></label>
                                <textarea class="form-control" name="Profile[about_me]"
                                          rows="5"><?= $model->about_me; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit"
                        class="btn btn-primary pull-right"><?= Yii::t('app', 'Update Profile'); ?></button>
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
