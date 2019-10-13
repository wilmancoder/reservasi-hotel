<?php


/* @var $this yii\web\View */
/* @var $model app\models\Artikel */

?>
<div class="pricesetting-update">

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
        'listDataharga' => $listDataharga,
        'listDatatype' => $listDatatype
    ]) ?>

</div>
