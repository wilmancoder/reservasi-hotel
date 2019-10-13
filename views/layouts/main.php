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
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-yellow layout-top-nav">
<?php $this->beginBody() ?>
<div class="wrapper">
    <?//= $this->render('info_timer.php'); ?>
    <?php
        $jamlogin = \Yii::$app->user->identity->sign_in;
        $res_jamlogin = date("Y-m-d H:i:s",strtotime($jamlogin));

        // $modelJamkerja = Logic::durasikerja($res_jamlogin);
        // var_dump($modelJamkerja);exit;
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
        <strong>Copyright © 2014-2019 <a href="https://www.telkom.co.id/">Telkom</a>.</strong> All rights
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
