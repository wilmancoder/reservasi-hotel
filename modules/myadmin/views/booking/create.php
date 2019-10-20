<?php


/* @var $this yii\web\View */
/* @var $model app\models\Artikel */

?>
<div class="rooms-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
        'id' => $id,
        'listkamar' => $listkamar,
        'setharga' => $setharga
    ]) ?>

</div>
