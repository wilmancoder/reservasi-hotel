<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<style type="text/css">
    .geserkanan {
        margin-right: 5px;
    }
    /* #tbooking-harga {
        font-size: 20px;
        font-weight: bold;
        color: black;
        text-align: center;
        padding-top: 10px;
    } */
    #summarybooking-total_bayar {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
    }
    #summarybooking-dp {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
    }
    #summarybooking-sisa {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
    }
    #summarybooking-total_harga {
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
                    "id" => "form-booking",
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
                                <?= $form->field($model, 'alamat')->textarea(['maxlength' => true, 'rows' => '5', 'class' => 'form-control', 'placeholder' => 'Masukkan alamat ...', 'autocomplete' => 'off']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-warning">
                <div class="box-body">
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
                                        <select class="form-control select validate[required] pilih_kamar" id='id_pilihkamar' urutan='0' name="kamar[0][list_kamar]">
                                        <option value="empty">Pilih Kamar ...</option>
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
                                        <input type="hidden" id="nomor_kamar0" name="kamar[0][nomor_kamar]">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'checkin')->textInput(['name' => 'kamar[0][checkin]', 'maxlength' => true, 'class' => 'form-control form-tanggal', 'id' =>'firstDate0', 'placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'checkout')->textInput(['name' => 'kamar[0][checkout]', 'maxlength' => true, 'class' => 'form-control form-tanggal secondDate', 'id' =>'secondDate0', 'urutan'=> '0','placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <?= $form->field($model, 'durasi')->textInput(['name' => 'kamar[0][durasi]', 'maxlength' => true, 'class' => 'form-control cl_durasi','id' => 'tbooking-durasi0', 'readonly' => true]); ?>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= $form->field($model, 'hargaperkamar')->textInput(['name' => 'kamar[0][hargaperkamar]', 'maxlength' => true, 'class' => 'form-control cl_hargaperkamar', 'id' => 'tbooking-hargaperkamar0', 'readonly' => true]); ?>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= $form->field($model, 'subtotalkamar')->textInput(['name' => 'kamar[0][subtotalkamar]', 'maxlength' => true, 'class' => 'form-control cl_subtotalkamar', 'id' => 'tbooking-subtotalkamar0', 'readonly' => true]); ?>
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
                                          <input type="radio" name="TBooking[radio]" class="idradio" value="lunas">
                                          <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="container">Sebagian
                                            <input type="radio" name="TBooking[radio]" class="idradio" value="sebagian">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="container">Belum Bayar
                                            <input type="radio" checked="checked" name="TBooking[radio]" class="idradio" value="belumbayar">
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
                                          <input type="radio" checked="checked" name="TBooking[radionm]" class="radioid" value="cash">
                                          <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="container">Debit
                                            <input type="radio" name="TBooking[radionm]" class="radioid" value="debit">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group required" id="idcarddebit" style="display:none">
                                            <?= $form->field($model, 'no_kartu_debit')->textInput(['maxlength' => true, 'class' => 'form-control', 'autocomplete' => 'off']); ?>
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
                    <?=Html::a($model->isNewRecord ? '<i class="fa fa-floppy-o" aria-hidden="true"></i> Booking'  : '<i class="fa fa-pencil" aria-hidden="true"></i> Update',$model->isNewRecord ? 'javascript:savebooking("'.$joinid.'")':'javascript:updatebooking()',['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
                    <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> -->
                    <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Close', ['class' => 'btn btn-danger pull-right geserkanan', 'data-dismiss' => 'modal']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<script type="text/javascript">
    var vv = 0;
    $(document).ready(function () {
        // formattingFirstDate();
        // formattingSecondDate();
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


        $('#tbooking-hargaperkamar0').val(0);
        // $('#firstDate0').val(formattingFirstDate());
        // $('#secondDate0').val(formattingSecondDate());
        $('#tbooking-durasi0').val(0);
        $('#tbooking-subtotalkamar0').val(0);


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

    function formattingSecondDate(){
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate()+1;

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
        $('#summarybooking-dp').val(0);
        $('#summarybooking-dp').number(true);
        // $('#summarybooking-sisa').val( $('#summarybooking-dp').val() );
        total();
    }

    function hitungDurasi(id=null)
    {
        const hasil = 0;
        const start= new Date($("#firstDate"+id).val());
        const end= new Date($("#secondDate"+id).val());
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays;
    }

    function setDefault()
    {
        var setdefault = 0;
        $('#summarybooking-total_bayar').val(setdefault);
        $('#summarybooking-total_bayar').number( true );
        $('#summarybooking-total_harga').val(setdefault);
        $('#summarybooking-total_harga').number( true );
        $('#summarybooking-sisa').val(setdefault);
        $('#summarybooking-sisa').number( true );
        $('#summarybooking-dp').val(0);
        $('#summarybooking-dp').number( true );

        $('#tbooking-subtotalkamar"'+valueT+'"').val(setdefault);
        $('#tbooking-durasi"'+valueT+'"').val(setdefault);
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
                                    '<select id="tbooking-list_kamar'+valueT+'" class="form-control select pilih_kamar" urutan="'+valueT+'" validate[required] name="kamar['+valueT+'][list_kamar]">' +
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
                                    '<input type="text" value="0" id="tbooking-durasi'+valueT+'" class="form-control cl_durasi" name="kamar['+valueT+'][durasi]" readonly="true">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-2">' +
                                '<div class="form-group">' +
                                    '<label class="control-label">Harga Kamar </label>' +
                                    '<input type="text" value="0" id="tbooking-hargaperkamar'+valueT+'" class="form-control cl_hargaperkamar" name="kamar['+valueT+'][hargaperkamar]" readonly="true">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-2">' +
                                '<div class="form-group">' +
                                    '<label class="control-label">SubTotal</label>' +
                                    '<input type="text" value="0" id="tbooking-subtotalkamar'+valueT+'" class="form-control cl_subtotalkamar" name="kamar['+valueT+'][subtotalkamar]" readonly="true">' +
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


    function savebooking(joinid) {
        {
            if($('#tbooking-namatamu').val()==''){
                swal({
                    title: 'Perhatian !',
                    text: 'Nama Tamu Wajib Diisi.',
                    icon: "info",
                    dangerMode: true,
                }).then((ya) => {
                    $('#tbooking-namatamu').focus();
                });
                return false;
            } else if($('#tbooking-nomor_kontak').val()==''){
                swal({
                    title: 'Perhatian !',
                    text: 'Nomor Handphone Tamu Wajib Diisi.',
                    icon: "info",
                    dangerMode: true,
                }).then((ya) => {
                    $('#tbooking-nomor_kontak').focus();
                });
                return false;
            } else if($('#tbooking-nomor_identitas').val()==''){
                swal({
                    title: 'Perhatian !',
                    text: 'Nomor Identitas Tamu Wajib Diisi.',
                    icon: "info",
                    dangerMode: true,
                }).then((ya) => {
                    $('#tbooking-nomor_identitas').focus();
                });
                return false;

            } else if($('#id_pilihkamar option:selected').val()=='empty'){
              swal({
                  title: 'Perhatian !',
                  text: 'Kamar Belum Ada Yang Dipilih !',
                  icon: "info",
                  dangerMode: true,
              })
              return false;

            } else {
                // return false;

                swal({
                    title: "Konfirmasi",
                    text: "Anda yakin akan memproses booking?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((ya) => {
                    if (ya) {
                        var _data = new FormData($("#form-booking")[0]);
                        $.ajax({
                            type: "POST",
                            data: _data,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/booking/create'])?>?joinid="+joinid,
                            beforeSend: function () {
                                swal({
                                    title: 'Harap Tunggu',
                                    text: "Sedang memproses booking",
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
                                    window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/booking/index'])?>?idharga="+result.idharga;
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal("Error!", "Terdapat Kesalahan saat memproses booking!", "error");
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
        $('#tbooking-hargaperkamar'+urutan).val(harga);
        $('#nomor_kamar'+urutan).val(nomor_kamar);
        if($('#secondDate'+urutan).val() != ''){
            field_kamar(urutan);
        }
    });

    $(document).on('change','.secondDate',function(event){
        event.preventDefault();
        var urutan = $(this).attr('urutan');
        $('#summarybooking-dp').val(0);
        $('#summarybooking-dp').number(true);
        field_kamar(urutan);

        // prosesharga(hasil, jmlkamar);
    });

    function field_kamar(urutan){
        var hasil = hitungDurasi(urutan);
        // alert(hasil);
        var hargakamar = $('#tbooking-hargaperkamar'+urutan).val();
        var jmlkamar = $('#tbooking-list_kamar'+urutan).val();
        var subtotal = hargakamar * hasil;

        $('#tbooking-subtotalkamar'+urutan).val(subtotal);
        $('#tbooking-durasi'+urutan).val(hasil);
        total();
    }

    function total(){
        var total = 0;
        $( ".cl_subtotalkamar" ).each(function( index ) {
           total = parseInt(total) + parseInt($(this).val());
        });

        $('#summarybooking-total_harga').val(total);
        $('#summarybooking-total_harga').number( true );
        $('#summarybooking-total_bayar').val(total);
        $('#summarybooking-total_bayar').number( true );
        $('#summarybooking-sisa').val(0);
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
                    $('#tbooking-no_kartu_debit').val('');
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
                    $('#summarybooking-dp').val($('#summarybooking-total_harga').val());
                    $('#iddp').hide();
                    $('.field-summarybooking-total_harga').show();
                    $('#summarybooking-sisa').val(0);
                    total();
                }
                else{
                    $('.field-summarybooking-total_harga').hide();
                    $('#summarybooking-dp').val(0);
                    $('#summarybooking-dp').number( true );
                    $('#summarybooking-dp').focus();
                    // $('#summarybooking-sisa').val( $('#summarybooking-total_bayar').val() )
                    $('#iddp').show();
                }
            }
    });

    $(document).on('keyup','#summarybooking-dp',function(){
        var val = $(this).val();
        var total = $('#summarybooking-total_harga').val();
        var hasil = parseInt(total) - parseInt(val) ;
        $('#summarybooking-sisa').val(hasil);
        $('#summarybooking-sisa').number( true );

    });
</script>
<div id="comcounter" hidden>0</div>
