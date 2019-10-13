<?php

use app\assets\AppAssetLogin;
use app\components\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

AppAssetLogin::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="fullHeight">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= (is_null($this->title)) ? "MILLENIA" : $this->title . " | MILLENIA" ?></title>
    <link rel="shortcut icon" href="<?= url::to('@web/favicon.ico') ?>"/>
    <?php $this->head() ?>
</head>
<body class="loginPage">

<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
<script type="text/javascript">
    new WOW().init();
</script>
</body>
</html>
<?php $this->endPage() ?>
