<?php


/* @var $this yii\web\View */
/* @var $model app\models\Artikel */

?>
<div class="pricesetting-create">

    <?= $this->render('_form', [
        'model' => $model,
        'listDataharga' => $listDataharga,
        'listDatatype' => $listDatatype
    ]) ?>

</div>
