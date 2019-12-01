<?php

use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-4 col-md-push-7">
        <div class="site-name wow fadeInDown" data-wow-delay="0.5s">
            MILLENIA<br>
            <small style="font-size:23px">Aplikasi Manajemen Hotel</small>
        </div>
        <div class="login-box wow flipInX">
            <!-- <div class="login-logo wow flipInX" data-wow-delay="1s">
              <a href="#">e<b>Proposal</b> <br> <span>Spending Analysis Tools</span></a>
            </div> -->
            <!-- /.login-logo -->
            <div class="login-box-body">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <div class="form-group has-feedback">
                    <input type="text" name="LoginForm[username]" class="form-control" placeholder="Username">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    <p class="help-block help-block-error" style="color:#fff!important">
                        <?php
                        if (!empty($model->errors)) {
                            if (isset($model->errors['username'][0]))
                                echo $model->errors['username'][0];
                        }
                        ?>
                    </p>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="LoginForm[password]" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <p class="help-block help-block-error" style="color:#fff!important">
                        <?php
                        if (!empty($model->errors)) {
                            if (isset($model->errors['password'][0]))
                                echo $model->errors['password'][0];
                        }
                        ?>
                    </p>
                </div>
                <div class="form-group has-feedback">
                    <?= $form->field($model, 'id_shift')->dropDownList($listShift, ['name' => 'LoginForm[id_shift]', 'class' => 'form-control select validate[required]', 'prompt' => 'Pilih Shift ...'])->label(false); ?>
                    <p class="help-block help-block-error" style="color:#fff!important">
                        <?php
                        if (!empty($model->errors)) {
                            if (isset($model->errors['id_shift'][0]))
                                echo $model->errors['id_shift'][0];
                        }
                        ?>
                    </p>
                </div>
                <div>
                    <button type="submit" class="btn btn-login btn-block"><i class="fa fa-sign-in"></i> Sign In</button>
                </div>
                <?php ActiveForm::end(); ?>
                <!-- <span class="pull-right" style="margin-top: 15px"><small></small></span> -->
            </div>
            <div class="text-right smaller" style="padding-right: 20px;"></div>
            <!-- /.login-box-body -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".select").select2();
    });
</script>
