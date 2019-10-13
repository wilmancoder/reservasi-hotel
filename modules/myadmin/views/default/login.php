<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Millenia';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-box">
    <div class="login-logo">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
  <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Control Management System</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="form-group has-feedback">
                <input type="text" name="LoginForm[username]" class="form-control" placeholder="Username">
                <!-- <span class="fa fa-envelope form-control-feedback"></span> -->
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
                <!-- <span class="fa fa-lock form-control-feedback"></span> -->
                <p class="help-block help-block-error" style="color:#fff!important">
                    <?php
                    if (!empty($model->errors)) {
                      if (isset($model->errors['password'][0]))
                          echo $model->errors['password'][0];
                    }
                    ?>
                </p>
            </div>
            <div class="row">
                <!-- /.col -->
                <!-- <div class="col-4"> -->
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                <!-- </div> -->
                <!-- /.col -->
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
