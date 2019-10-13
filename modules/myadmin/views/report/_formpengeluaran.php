<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<style type="text/css">
    .mr_tombol {
        margin-left: 5px;
    }
    #garis {
        padding: 20px;
        margin: 0px;
        margin-top: 25px;
    }
    .fit {
        margin: 0px;
    }
    .fitappend {
        margin: 10px;
    }
    .textColor {
        color: #A9A9A9;
        background-color: white;
    }
    .borderColor {
        border-width: 3px;
        border-style: solid;
        border-color: #A9A9A9;
        margin-bottom: 5px;
    }
    .btnbatal {
        margin: 8px;
    }
    .btnadd {
        margin-top: 5px;
    }
</style>

<div class="box box-warning">
    <div class="box-body">
        <div class="pengeluaran-form">

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
                    "id" => "form-createpengeluaran",
                    "class" => "",
                    'onsubmit'=>'return false;',
                    // "data-parsley-validate" => "",
                    // 'enctype'=>'multipart/form-data',
                    // 'novalidate' => 'novalidate'
                ]
            ]); ?>
            <div class="row">
                <div class="col-md-12" id="kolomrole">
                    <div class="row fit" id="kolomrole0">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label class="control-label" required>Jenis Item </label>
                                <?= $form->field($model, 'item')->textInput(['name' => 'TPengeluaranPetugas[item][]', 'maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Masukkan item ...'])->label(false); ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group required">
                                <label class="control-label" required>Jumlah Item </label>
                                <?= $form->field($model, 'qty')->textInput(['name' => 'TPengeluaranPetugas[qty][]', 'maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Masukkan jumlah ...'])->label(false); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group required">
                                <label class="control-label" required>Harga per Item </label>
                                <?= $form->field($model, 'harga_per_item')->textInput(['name' => 'TPengeluaranPetugas[harga_per_item][]', 'maxlength' => true, 'class' => 'form-control hargaitem', 'placeholder' => 'Masukkan harga per item ...'])->label(false); ?>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group required">
                                <label class="control-label" required>SubTotal Harga per Item </label>
                                <?//= $form->field($model, 'total_harga_item')->textInput(['name' => 'TPengeluaranPetugas[total_harga_item][]', 'maxlength' => true, 'class' => 'form-control', 'readonly' => true])->label(false); ?>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 btnadd">
                    <button type="button" onclick="addForm(id='kolomrole0')" class='btn btn-fill btn-info btn-sm' id="btnaddform"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?=Html::a('<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan', 'javascript:savepengeluaran("'.$idpetugas.'")', ['class' => 'btn btn-success pull-right mr_tombol', 'id'=>'saveaddpengeluaran']) ?>
        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> -->
        <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Close', ['class' => 'btn btn-danger pull-right geserkanan', 'data-dismiss' => 'modal']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script type="text/javascript">
var vv = 0;
$(document).ready(function () {
    $('.hargaitem').number( true );
});

function addForm() {

    var valueT = document.getElementById("comcounter").innerHTML;
    valueT = Number(valueT) + 1;
    var divid = 'kolomrole'+valueT;
    document.getElementById("comcounter").innerHTML = valueT;
    // vv = Number(valueT);
    vv++;
    $('#kolomrole').append(
        '<div id=garis'+valueT+' class="textColor borderColor">'+
            '<div class="row" id=remove_role'+valueT+'>'+
                '<div class="col-md-12">'+
                    '<button style="float:right;" id="btnbatal" name="button" type="button" class="btnbatal btn btn-sm btn-danger" id="remove_role'+valueT+'" onClick="delRec('+valueT+')"><span class="fa fa-times"></span></button>'+
                '</div>'+
                '<div class="col-md-12">' +
                    '<div class="row fitappend">' +
                        '<div class="col-md-6">' +
                            '<div class="form-group required">' +
                                '<label class="control-label" required>Jenis Item </label>' +
                                '<input type="text" name="TPengeluaranPetugas[item][]" id="tpengeluaranpetugas-item" class="form-control" placeholder="Masukkan item ..." >' +
                            '</div>' +
                        '</div>'+
                        '<div class="col-md-3">' +
                            '<div class="form-group required">' +
                                '<label class="control-label" required>Jumlah Item </label>' +
                                '<input type="text" name="TPengeluaranPetugas[qty][]" id="tpengeluaranpetugas-qty" class="form-control" placeholder="Masukkan jumlah ..." >' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-3">' +
                            '<div class="form-group required">' +
                                '<label class="control-label" required>Harga per Item </label>' +
                                '<input type="text" name="TPengeluaranPetugas[harga_per_item][]" id="tpengeluaranpetugas-harga_per_item" class="form-control hargaitem" placeholder="Masukkan harga per item ..." >' +
                            '</div>' +
                        '</div>' +
                        // '<div class="col-md-4">' +
                        //     '<div class="form-group required">' +
                        //         '<label class="control-label" required>SubTotal Harga per Item </label>' +
                        //         '<input type="text" name="TPengeluaranPetugas[total_harga_item][]" id="tpengeluaranpetugas-total_harga_item" class="form-control" readonly="true" >' +
                        //     '</div>' +
                        // '</div>' +


                    '</div>' +
                '</div>' +
                '<div class="waw" id="'+divid+'"></div>'+
            '</div>'+
        '</div>'
    );

    $(document).ready(function () {
        $('.hargaitem').number( true );
    });
}

function delRec(valueT){
    vv--;
    $('#garis'+valueT).remove();
    $('#kolomrole'+valueT).remove();
    $('#remove_role'+valueT).remove();
}
</script>
<div id="comcounter" hidden>0</div>
