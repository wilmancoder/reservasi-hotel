<?php


/* @var $this yii\web\View */
/* @var $model app\models\Artikel */

?>
<div class="paysetting-create">

    <?= $this->render('_form', [
        'model' => $model,
        'listDatametode' => $listDatametode,
        'listDatajenis' => $listDatajenis
    ]) ?>

</div>
