<?php


/* @var $this yii\web\View */
/* @var $model app\models\Artikel */

?>
<div class="pricesetting-update">

    <?= $this->render('_form', [
        'model' => $model,
        'mode' => 'update',
        'typekamar' => $typekamar,
        'kategoriharga' => $kategoriharga,
        'mappingharga' => $mappingharga,
        'id' => $id
    ]) ?>

</div>
