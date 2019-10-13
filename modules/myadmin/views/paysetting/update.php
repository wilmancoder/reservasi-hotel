<?php


/* @var $this yii\web\View */
/* @var $model app\models\Artikel */

?>
<div class="paysetting-update">

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
        'listDatametode' => $listDatametode,
        'listDatajenis' => $listDatajenis
    ]) ?>

</div>
