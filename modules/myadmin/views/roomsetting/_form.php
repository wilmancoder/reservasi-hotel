<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<style type="text/css">
    .geserkanan {
        margin-right: 5px;
    }
</style>
<div class="box box-warning">
    <div class="box-body">
        <div class="rooms-form">

            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-4',
                        'wrapper' => 'col-sm-7',
                        // 'label' => 'col-md-4 col-sm-4 col-xs-12',
                        // 'wrapper' => 'col-md-6 col-sm-6 col-xs-12',
                    ],
                ],
                "options" => [
                    "id" => "form-roomsetting",
                    "class" => "",
                    'onsubmit'=>'return false;',
                    // "data-parsley-validate" => "",
                    // 'enctype'=>'multipart/form-data',
                    // 'novalidate' => 'novalidate'
                ]
            ]); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <?= $form->field($model, 'nomor_kamar')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Masukkan nomor kamar ...']); ?>
                            </div>
                            <div class="form-group required">
                                <?php if($mode == 'create') { ?>
                                    <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Klik untuk setting harga ...']); ?>
                                <?php } else { ?>
                                    <?= $form->field($typekamar, 'type')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Klik untuk setting harga ...']); ?>
                                <?php } ?>
                                <?= $form->field($model, 'id_mapping_harga')->hiddenInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <?php if($mode == 'create') { ?>
                                    <?= $form->field($model, 'kategori_harga')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Terisi Otomatis', 'readonly' => true]); ?>
                                <?php } else { ?>
                                    <?= $form->field($kategoriharga, 'kategori_harga')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Terisi Otomatis', 'readonly' => true]); ?>
                                <?php } ?>
                            </div>
                            <div class="form-group required">
                                <?php if($mode == 'create') { ?>
                                    <?= $form->field($model, 'harga')->textInput(['maxlength' => true, 'class' => 'form-control hargakamar', 'placeholder' => 'Terisi Otomatis', 'readonly' => true]); ?>
                                <?php } else { ?>
                                    <?= $form->field($mappingharga, 'harga')->textInput(['maxlength' => true, 'class' => 'form-control hargakamar', 'placeholder' => 'Terisi Otomatis', 'readonly' => true]); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- <?//=Html::a('<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan', 'javascript:savesetharga()', ['class' => 'btn btn-success pull-right mr_tombol', 'id'=>'saveaddpengeluaran']) ?> -->
        <?= Html::a($model->isNewRecord ? '<i class="fa fa-floppy-o" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil" aria-hidden="true"></i> Update', $model->isNewRecord ? 'javascript:savesetroom()' : 'javascript:updatesetharga("' . $id . '")', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-success pull-right']) ?>
        <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Close', ['class' => 'btn btn-danger pull-right geserkanan', 'data-dismiss' => 'modal']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script type="text/javascript">
var mode = '<?= $mode?>';
$(document).ready(function () {
    $('.hargakamar').number( true );
    $(".select").select2();

});
if(mode == 'create'){
    $('#mmappingkamar-type').on('click', function() {
        var url = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/ceksettingharga']);?>?mode="+mode;
        var title = "List Setting Harga";
        showModalharga(url,title);
    });
} else {
    $('#mtype-type').on('click', function() {
        var url = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/ceksettingharga']);?>?mode="+mode;
        var title = "List Setting Harga";
        showModalharga(url,title);
    });
}



</script>
