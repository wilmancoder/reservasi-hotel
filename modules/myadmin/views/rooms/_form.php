<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<style type="text/css">
    .geserkanan {
        margin-right: 5px;
    }
    /* #ttamu-harga {
        font-size: 20px;
        font-weight: bold;
        color: black;
        text-align: center;
        padding-top: 10px;
    } */
    #summaryttamu-total_bayar {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
    }
    #summaryttamu-dp {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
    }
    #summaryttamu-sisa {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
    }
    #summaryttamu-total_harga {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
        /* padding: 25px 50px 75px 100px; */
    }
    /* Hide the browser's default radio button */
    .container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 25px;
      width: 25px;
      background-color: #eee;
      border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
      background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked ~ .checkmark {
      background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked ~ .checkmark:after {
      display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after {
     	top: 9px;
    	left: 9px;
    	width: 8px;
    	height: 8px;
    	border-radius: 50%;
    	background: white;
    }
    .mright-rdio {
        margin-left: 15px !important;
    }


    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color: #00a65a !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fffeef !important;
        font-size: 24px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
      color: #dd4b39 !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        font-size: 20px !important;
    }

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
        border-width: 1px;
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
                    "id" => "form-rooms",
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'namatamu')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Masukkan nama ...', 'autocomplete' => 'off']) ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'nomor_kontak')->textInput(['maxlength' => true, 'class' => 'form-control numberinput', 'placeholder' => 'Masukkan Nomor Handphone ...', 'autocomplete' => 'off']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <?=
                                            $form->field($model, 'identitas')->dropDownList(
                                                [
                                                    'ktp' => 'KTP',
                                                    'sim' => 'SIM'
                                                ],
                                                ['class' => 'form-control pilih']
                                            );
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'nomor_identitas')->textInput(['maxlength' => true, 'class' => 'form-control numberinput', 'placeholder' => 'Masukkan Nomor Identitas ...', 'autocomplete' => 'off']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <?= $form->field($model, 'alamat')->textarea(['maxlength' => true, 'rows' => '5', 'class' => 'form-control', 'placeholder' => 'Masukkan alamat ...']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-warning">
                <div class="box-body">
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-info">
                              <h5>Informasi !</h5>
                              <p>Anda telah memilih <strong>kamar nomor <?//= $nomorkamar?> dengan harga <?//= "Rp. " . \app\components\Logic::formatNumber($ambilharga, 0);?> per hari</strong></p>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <!-- <div class="col-md-12">
                            <label class="control-label">Tambah Kamar</label>
                            <?//= $form->field($model, 'list_kamar')->dropDownList(Yii::$app->Logic->arrKamar($id), ['class' => 'form-control select validate[required]', 'multiple'=>'multiple'])->label(false); ?>
                            <input type="hidden" class="form-control" name="terpilih" id="terpilih" value="<?//= $id?>">
                            <input type="text" class="form-control" name="kamarterpilih" id="kamarterpilih" value="">
                            <input type="text" class="form-control" name="hargaterpilih" id="hargaterpilih" value="">
                        </div> -->
                        <div class="col-md-12" id="kolomrole">
                            <div class="row fit" id="kolomrole0">
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" required>List Kamar </label>
                                        <select class="form-control select validate[required] pilih_kamar" urutan='0' name="TTamu[list_kamar]">
                                        <option>Pilih Kamar ...</option>
                                        <?php
                                        foreach ($listkamar as $idx => $value) {
                                            $selected = '';
                                            if($value['id'] == $id){
                                                $selected = 'selected';
                                            }
                                        ?>
                                            <option value="<?php echo $value['id'];?>" harga="<?= $value['harga'] ?>" nomor_kamar="<?= $value['nomor_kamar'] ?>" <?= $selected ?>>Kamar <?php echo $value['nomor_kamar'];?> / <?php echo $value['type'];?></option>
                                        <?php } ?>

                                        </select>
                                        <input type="hidden" id="nomor_kamar0" name='TTamu[nomor_kamar]' value="<?= $nomorkamar ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'checkin')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal', 'id' =>'firstDate0', 'placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'checkout')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal secondDate', 'id' =>'secondDate0', 'urutan'=> '0','placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <?= $form->field($model, 'durasi')->textInput(['maxlength' => true, 'class' => 'form-control cl_durasi','id' => 'ttamu-durasi0', 'readonly' => true]); ?>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= $form->field($model, 'hargaperkamar')->textInput(['maxlength' => true, 'class' => 'form-control cl_hargaperkamar', 'id' => 'ttamu-hargaperkamar0', 'readonly' => true]); ?>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= $form->field($model, 'subtotalkamar')->textInput(['maxlength' => true, 'class' => 'form-control cl_subtotalkamar', 'id' => 'ttamu-subtotalkamar0', 'readonly' => true]); ?>
                                    </div>
                                </div>
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

            <div class="box box-warning">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" style="font-size:15px;">Jenis Pembayaran</label>
                            <div class="row mright-rdio">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="container">Lunas
                                          <input type="radio" checked="checked" name="TTamu[radio]" id="aydi" class="idradio" value="lunas">
                                          <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="container">Sebagian
                                            <input type="radio" name="TTamu[radio]" class="idradio" value="sebagian">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="container">Belum Bayar
                                            <input type="radio" name="TTamu[radio]" class="idradio" value="belumbayar">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <label class="control-label" style="font-size:15px;">Metode Pembayaran</label>
                            <div class="row mright-rdio">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="container">Cash
                                          <input type="radio" checked="checked" name="TTamu[radionm]" class="radioid" value="cash">
                                          <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="container">Debit
                                            <input type="radio" name="TTamu[radionm]" class="radioid" value="debit">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group required" id="idcarddebit" style="display:none">
                                            <?= $form->field($model, 'no_kartu_debit')->textInput(['maxlength' => true, 'class' => 'form-control']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required" id="idbayar">
                                <?= $form->field($model2, 'total_bayar')->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => true]) ?>
                            </div>
                            <div class="form-group required" id="iddp" style="display:none">
                                <?= $form->field($model2, 'dp')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                            </div>
                            <div class="form-group required">
                                <?= $form->field($model2, 'sisa')->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => true]) ?>
                            </div>
                            <div class="form-group required">
                                <?= $form->field($model2, 'total_harga')->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => true]); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?=Html::a($model->isNewRecord ? '<i class="fa fa-floppy-o" aria-hidden="true"></i> Checkin'  : '<i class="fa fa-pencil" aria-hidden="true"></i> Update',$model->isNewRecord ? 'javascript:savecekin("'.$id.'")':'javascript:updatecekin("'.$id.'")',['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
                    <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> -->
                    <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Close', ['class' => 'btn btn-danger pull-right geserkanan', 'data-dismiss' => 'modal']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<script type="text/javascript">
    var ambilhargaperkamar = <?= $ambilharga?>;
    var cekShift = <?= \Yii::$app->user->identity->id_shift; ?>;
    var vv = 0;
    $(document).ready(function () {
        formattingFirstDate();
        formattingSecondDate(cekShift);
        $(".pilih").select2();

        $(".select").select2();

        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });
        $('.form-tanggal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: new Date()
        });


        $('#ttamu-hargaperkamar0').val(ambilhargaperkamar);
        $('#firstDate0').val(formattingFirstDate());
        $('#secondDate0').val(formattingSecondDate(cekShift));
        $('#ttamu-durasi0').val(1);
        $('#ttamu-subtotalkamar0').val(ambilhargaperkamar);


        setDefault();
    });

    function formattingFirstDate(){
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var output = d.getFullYear() + '-' +
            ((''+month).length<2 ? '0' : '') + month + '-' +
            ((''+day).length<2 ? '0' : '') + day;

        return output;
    }

    function formattingSecondDate(cekShift){
        // alert(cekShift); return false;
        var d = new Date();

        var month = d.getMonth()+1;
        if(cekShift == 3) {
            var day = d.getDate();
        } else {
            var day = d.getDate()+1;
        }

        var output = d.getFullYear() + '-' +
            ((''+month).length<2 ? '0' : '') + month + '-' +
            ((''+day).length<2 ? '0' : '') + day;

        return output;
    }

    function delRec(valueT){
        vv--;
        $('#garis'+valueT).remove();
        $('#kolomrole'+valueT).remove();
        $('#remove_role'+valueT).remove();
        // $('#summaryttamu-dp').val(0);
        // $('#summaryttamu-dp').number(true);

        $('#aydi').trigger("click", function() {
            // $('#summaryttamu-dp').val($('#summaryttamu-total_harga').val());
            $('#summaryttamu-dp').val(0);
            $('#summaryttamu-dp').number(true);
            $('#iddp').hide();
            $('.field-summaryttamu-total_harga').show();
            $('#summaryttamu-sisa').val(0);
            // total();
        })

        // $('#summaryttamu-sisa').val( $('#summaryttamu-dp').val() );
        total();
    }

    function hitungDurasi(id=null,cekShift=null)
    {
        const hasil = 0;
        const diffDays = 1;
        var first = $("#firstDate"+id).val();
        var second = $("#secondDate"+id).val();
        const start= new Date($("#firstDate"+id).val());
        const end= new Date($("#secondDate"+id).val());
        if(cekShift == 3) {
            if(first == second){
                return diffDays;
            } else {
                const diffTime = Math.abs(end - start);
                const refdiffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const diffDays = refdiffDays + 1;
                return diffDays;
            }
        } else {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        }
    }

    function setDefault()
    {
        var valueT = document.getElementById("comcounter").innerHTML;
        valueT = Number(valueT) + 1;
        var setdefault = 0;
        var gethargaawal = <?= $ambilharga?>;
        $('#summaryttamu-total_bayar').val(gethargaawal);
        $('#summaryttamu-total_bayar').number( true );
        $('#summaryttamu-total_harga').val(gethargaawal);
        $('#summaryttamu-total_harga').number( true );
        $('#summaryttamu-sisa').val(setdefault);
        $('#summaryttamu-sisa').number( true );
        $('#summaryttamu-dp').val(0);
        $('#summaryttamu-dp').number( true );

        $('#ttamu-subtotalkamar'+valueT).val(setdefault);
        $('#ttamu-durasi'+valueT).val(setdefault);
    }

    function addForm() {
        var valueT = document.getElementById("comcounter").innerHTML;
        valueT = Number(valueT) + 1;
        var divid = 'kolomrole'+valueT;
        document.getElementById("comcounter").innerHTML = valueT;
        // vv = Number(valueT);
        vv++;
        $('#kolomrole').append(
            '<div id=garis'+valueT+' class="textColor borderColor itemappend">'+
                '<div class="row" id=remove_role'+valueT+'>'+
                    '<div class="col-md-12">'+
                        '<button style="float:right;" id="btnbatal" name="button" type="button" class="btnbatal btn btn-sm btn-danger" id="remove_role'+valueT+'" onClick="delRec('+valueT+')"><span class="fa fa-times"></span></button>'+
                    '</div>'+
                    '<div class="col-md-12">' +
                        '<div class="row fitappend">' +
                            '<div class="col-md-3">' +
                                '<div class="form-group required">' +
                                    '<label class="control-label" required>List Kamar </label>' +
                                    '<select id="ttamu-list_kamar'+valueT+'" class="form-control select pilih_kamar" urutan="'+valueT+'" validate[required] name="kamar['+valueT+'][list_kamar]">' +
                                    '<option>Pilih Kamar ...</option>' +
                                        <?php
                                        foreach ($listkamar as $idx => $value) {
                                        ?>

                                            '<option value="<?php echo $value['id'];?>" harga="<?php echo $value['harga'];?>" nomor_kamar="<?php echo $value['nomor_kamar'];?>">Kamar <?php echo $value['nomor_kamar'];?> / <?php echo $value['type'];?></option>' +

                                        <?php } ?>

                                    '</select>' +
                                    '<input type="hidden" id="nomor_kamar'+valueT+'" name="kamar['+valueT+'][nomor_kamar]">'+
                                '</div>' +
                            '</div>'+
                            '<div class="col-md-2">' +
                                '<div class="form-group required">' +
                                    '<label class="control-label" required>Checkin </label>' +
                                    '<input type="text" id="firstDate'+valueT+'" class="form-control form-tanggal" name="kamar['+valueT+'][checkin]" placeholder="Klik disini ..." autocomplete="off">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-2">' +
                                '<div class="form-group required">' +
                                    '<label class="control-label" required>Checkout </label>' +
                                    '<input type="text" id="secondDate'+valueT+'" class="form-control form-tanggal secondDate"  urutan="'+valueT+'" name="kamar['+valueT+'][checkout]" placeholder="Klik disini ..." autocomplete="off">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-1">' +
                                '<div class="form-group">' +
                                    '<label class="control-label">Durasi </label>' +
                                    '<input type="text" value="0" id="ttamu-durasi'+valueT+'" class="form-control cl_durasi" name="kamar['+valueT+'][durasi]" readonly="true">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-2">' +
                                '<div class="form-group">' +
                                    '<label class="control-label">Harga Kamar </label>' +
                                    '<input type="text" value="0" id="ttamu-hargaperkamar'+valueT+'" class="form-control cl_hargaperkamar" name="kamar['+valueT+'][hargaperkamar]" readonly="true">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-2">' +
                                '<div class="form-group">' +
                                    '<label class="control-label">SubTotal</label>' +
                                    '<input type="text" value="0" id="ttamu-subtotalkamar'+valueT+'" class="form-control cl_subtotalkamar" name="kamar['+valueT+'][subtotalkamar]" readonly="true">' +
                                '</div>' +
                            '</div>' +


                        '</div>' +
                    '</div>' +
                    '<div class="waw" id="'+divid+'"></div>'+
                '</div>'+
            '</div>'
        );
        $(document).ready(function(){
            $(".select").select2();

            $('.form-tanggal').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                startDate: new Date()
            });
        });
    }


    function savecekin(id) {
        {
            if($('#ttamu-namatamu').val()==''){
                swal({
                    title: 'Perhatian !',
                    text: 'Nama Tamu Wajib Diisi.',
                    icon: "info",
                    dangerMode: true,
                }).then((ya) => {
                    $('#ttamu-namatamu').focus();
                });
                return false;
            } else if($('#ttamu-nomor_kontak').val()==''){
                swal({
                    title: 'Perhatian !',
                    text: 'Nomor Handphone Tamu Wajib Diisi.',
                    icon: "info",
                    dangerMode: true,
                }).then((ya) => {
                    $('#ttamu-nomor_kontak').focus();
                });
                return false;
            } else if($('#ttamu-nomor_identitas').val()==''){
                swal({
                    title: 'Perhatian !',
                    text: 'Nomor Identitas Tamu Wajib Diisi.',
                    icon: "info",
                    dangerMode: true,
                }).then((ya) => {
                    $('#ttamu-nomor_identitas').focus();
                });
                return false;

            } else if($('#firstDate0').val()==''){
                swal({
                    title: 'Perhatian !',
                    text: 'Tanggal Checkin Tamu Wajib Diisi.',
                    icon: "info",
                    dangerMode: true,
                }).then((ya) => {
                    $('#firstDate0').focus();
                });
                return false;
            } else if($('#secondDate0').val()==''){
                swal({
                    title: 'Perhatian !',
                    text: 'Tanggal Checkout Tamu Wajib Diisi.',
                    icon: "info",
                    dangerMode: true,
                }).then((ya) => {
                    $('#secondDate0').focus();
                });
                return false;
            } else {

                swal({
                    title: "Konfirmasi",
                    text: "Anda yakin akan memproses checkin?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((ya) => {
                    if (ya) {
                        var _data = new FormData($("#form-rooms")[0]);
                        $.ajax({
                            type: "POST",
                            data: _data,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/create'])?>?id="+id,
                            beforeSend: function () {
                                swal({
                                    title: 'Harap Tunggu',
                                    text: "Sedang memproses check-in",
                                    icon: 'info',
                                    buttons: {
                                        cancel: false,
                                        confirm: false,
                                    },
                                    closeOnClickOutside: false,
                                    onOpen: function () {
                                        swal.showLoading()
                                    },
                                    closeOnEsc: false,
                                });
                            },
                            complete: function () {
                                swal.close()
                            },
                            success: function (result) {

                                swal(result.header, result.message, result.status);

                                if (result.status == "success") {
                                    window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/index'])?>?idharga="+result.setharga;
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal("Error!", "Terdapat Kesalahan saat memproses check-in!", "error");
                            }
                        });
                    } else {
                        // swal("Informasi", "Dokumen Tidak Dihapus", "info");
                    }
                });
            }
        }
    }


    // js hadi
    $(document).on('change','.pilih_kamar',function(){
        var harga = $('option:selected', this).attr('harga');
        var nomor_kamar = $('option:selected', this).attr('nomor_kamar');
        var urutan = $(this).attr('urutan');
        $('#ttamu-hargaperkamar'+urutan).val(harga);
        $('#nomor_kamar'+urutan).val(nomor_kamar);
        if($('#secondDate'+urutan).val() != ''){
            field_kamar(urutan);
        }
    });

    $(document).on('change','.secondDate',function(event){
        event.preventDefault();
        $('#aydi').trigger("click", function() {
            $('#summaryttamu-dp').val($('#summaryttamu-total_harga').val());
            $('#iddp').hide();
            $('.field-summaryttamu-total_harga').show();
            $('#summaryttamu-sisa').val(0);
            total();
        })
        var urutan = $(this).attr('urutan');
        // $('#idradio').attr('checked',true);
        $('#summaryttamu-dp').val(0);
        $('#summaryttamu-dp').number(true);
        field_kamar(urutan,cekShift);

        // prosesharga(hasil, jmlkamar);
    });

    function field_kamar(urutan,cekShift=null){
        // alert(cekShift); return false;
        var hasil = hitungDurasi(urutan,cekShift);
        var hargakamar = $('#ttamu-hargaperkamar'+urutan).val();
        var jmlkamar = $('#ttamu-list_kamar'+urutan).val();
        var subtotal = hargakamar * hasil;

        $('#ttamu-subtotalkamar'+urutan).val(subtotal);
        $('#ttamu-durasi'+urutan).val(hasil);
        total();
    }

    function total(){
        var total = 0;
        $( ".cl_subtotalkamar" ).each(function( index ) {
           total = parseInt(total) + parseInt($(this).val());
        });

        $('#summaryttamu-total_harga').val(total);
        $('#summaryttamu-total_harga').number( true );
        $('#summaryttamu-total_bayar').val(total);
        $('#summaryttamu-total_bayar').number( true );
        $('#summaryttamu-sisa').val(0);
    }



    $('.radioid').on('click', function() {
            // var changebrowse = $($('.input-group-append').find('i.glyphicon-folder-open')).parent().removeClass('btn btn-primary btn-file').addClass('btn btn-default btn-file');
            if( $(this).is(":checked") ){
                var val = $(this).val();
                console.log(val);
                if(val == "debit") {
                    $('#idcarddebit').show();
                }
                else{
                    $('#ttamu-no_kartu_debit').val('');
                    $('#idcarddebit').hide();
                }
            }
    });

    $('.idradio').on('click', function() {
            // var changebrowse = $($('.input-group-append').find('i.glyphicon-folder-open')).parent().removeClass('btn btn-primary btn-file').addClass('btn btn-default btn-file');
            if( $(this).is(":checked") ){
                var val = $(this).val();
                console.log(val);
                if(val == "lunas") {
                    // $('#summaryttamu-dp').val($('#summaryttamu-total_harga').val());
                    $('#summaryttamu-dp').val(0);
                    $('#summaryttamu-dp').number( true );
                    $('#iddp').hide();
                    $('.field-summaryttamu-total_harga').show();
                    $('#summaryttamu-sisa').val(0);
                    total();
                } else if(val == "sebagian"){
                    $('.field-summaryttamu-total_harga').hide();
                    $('#summaryttamu-total_bayar').val($('#summaryttamu-total_harga').val());
                    $('#summaryttamu-dp').val(0);
                    $('#summaryttamu-dp').number( true );
                    $('#summaryttamu-dp').focus();
                    // $('#summaryttamu-sisa').val( $('#summaryttamu-total_bayar').val() )
                    $('#iddp').show();
                } else {
                    $('#summaryttamu-total_bayar').val(0);
                    $('#summaryttamu-total_bayar').number( true );
                    $('#iddp').hide();
                    $('#summaryttamu-sisa').val($('#summaryttamu-total_harga').val());
                    $('.field-summaryttamu-total_harga').show();
                    // $('#summaryttamu-total_harga').val($('#summaryttamu-total_harga').val());
                }
            }
    });

    $(document).on('keyup','#summaryttamu-dp',function(){
        var val = $(this).val();
        var total = $('#summaryttamu-total_harga').val();
        var hasil = parseInt(total) - parseInt(val) ;
        $('#summaryttamu-sisa').val(hasil);
        $('#summaryttamu-sisa').number( true );

    });
</script>
<div id="comcounter" hidden>0</div>
