<?php


/* @var $this yii\web\View */
/* @var $model app\models\Artikel */

?>
<div class="done-create">

    <?= $this->render('_formdone', [
        'ambilDatatamu' => $ambilDatatamu,
        'ambilDatatamusatuan' => $ambilDatatamusatuan,
        'idbiodata' => $idbiodata,
        'idkamar' =>$idkamar,
        'tipe' => $tipe,
        'cektbed' => $cektbed,
        'resultbed' => $resultbed,
        'model' => $model,
        'getsessionharga' => $getsessionharga
    ]) ?>

</div>
