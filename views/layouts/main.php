<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\Logic;
use app\models\MShift;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php $this->registerCsrfMetaTags() ?>

  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>

</head>
<style type="text/css">
    .dashboard {
        background-color: red;
    }
    .desc {
        font-size: 14px;
    }
</style>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-yellow layout-top-nav">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?php
        $jamlogin = \Yii::$app->user->identity->sign_in;
        $res_jamlogin = date("Y-m-d H:i:s",strtotime($jamlogin));
        // $modelJamkerja = Logic::durasikerja($res_jamlogin);


        $modelReminderbooking = Logic::reminderBooking();
        $modelRemindercheckout = Logic::reminderCheckout();

        // var_dump($modelReminder);exit;
    ?>

  <!-- <header class="main-header"> -->


    <?= $this->render('nav.php',[
        // 'modelJamkerja' => $modelJamkerja
    ]); ?>
    <!-- </nav> -->
  <!-- </header> -->
  <!-- Full Width Column -->
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- <div class="container"> -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <div class="info-boxz bg-aqua">
                        <span class="info-boxz-icon"><i class="ion ion-android-clipboard"></i></span>
                        <div class="info-boxz-content">
                          <span class="info-boxz-text">Booking Reminder</span>
                          <span class="info-boxz-number">Total <?= !empty($modelReminderbooking[0]['total']) ? $modelReminderbooking[0]['total'] : 0; ?></span>
                          <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                          </div>
                          <span class="progress-description desc">
                            Checking in One Day Remaining
                          </span>
                      </div><!-- /.info-boxz-content -->
                  </div><!-- /.info-boxz -->
                </div>

                <div class="col-md-3">
                    <div class="info-boxz bg-aqua">
                        <span class="info-boxz-icon"><i class="ion ion-log-out"></i></span>
                        <div class="info-boxz-content">
                          <span class="info-boxz-text">Checkout Reminder</span>
                          <span class="info-boxz-number">Total <?= !empty($modelRemindercheckout[0]['total']) ? $modelRemindercheckout[0]['total'] : 0; ?></span>
                          <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                          </div>
                          <span class="progress-description desc">
                            Checking in One Day Remaining
                          </span>
                      </div><!-- /.info-boxz-content -->
                  </div><!-- /.info-boxz -->
                </div>
                <div class="col-md-3"></div>
            </div>
          <?= Alert::widget() ?>
        </section>
          <?= $content ?>
        <!-- </div> -->
    </div>
  <!-- /.content-wrapper -->

  <?php /*
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <!-- <b>Version</b> 2.4.13 -->
      </div>

      <strong>Copyright &copy; <?= date('Y') ?> <?= Yii::powered() ?>.</strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
  */ ?>
</div>

<?php $this->endBody() ?>
<footer class="main-footer">
    <div class="container">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright © 2019-2020 <a href="#">Millenia</a>.</strong> All rights
        reserved.
    </div>
    <!-- /.container -->
</footer>
</body>
</html>
<?php $this->endPage() ?>

<script type="text/javascript">
    // function cekjamkerja(){
    //     var tes = '<?//= $modelJamkerja?>';
    //     // return tes;
    //     console.log(tes);
    // }
    // setInterval(cekjamkerja, 1000);
</script>
