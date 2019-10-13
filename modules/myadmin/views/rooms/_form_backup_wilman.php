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
    #summarysummaryttamu-dp {
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
                                        <?= $form->field($model, 'namatamu')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Masukkan nama ...']) ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'nomor_kontak')->textInput(['maxlength' => true, 'class' => 'form-control numberinput', 'placeholder' => 'Masukkan Nomor Identitas ...']) ?>
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
                                        <?= $form->field($model, 'nomor_identitas')->textInput(['maxlength' => true, 'class' => 'form-control numberinput', 'placeholder' => 'Masukkan Nomor Identitas ...']) ?>
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
                                            <option value="<?php echo $value['id'];?>" harga="<?= $value['harga'] ?>" <?= $selected ?>>Kamar <?php echo $value['nomor_kamar'];?> / <?php echo $value['type'];?></option>
                                        <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'checkin')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal', 'id' =>'firstDate0', 'placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group required">
                                        <?= $form->field($model, 'checkout')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal', 'id' =>'secondDate0', 'placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="container">Pembayaran Penuh
                                          <input type="radio" checked="checked" name="TTamu[radio]" class="idradio" value="lunas">
                                          <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="container">Pembayaran Sebagian
                                            <input type="radio" name="TTamu[radio]" class="idradio" value="sebagian">
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
                                        <?= $form->field($model, 'no_kartu_debit')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
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
    var vv = 0;
    $(document).ready(function () {

        $(".pilih").select2();

        $(".select").select2();

        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });
        $('.form-tanggal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#ttamu-hargaperkamar0').val(ambilhargaperkamar);
        $('#ttamu-durasi0').val(0);
        $('#ttamu-subtotalkamar0').val(0);


        setDefault();
        manageSelect();
        manageMetodePembayaran();
    });

    $('#secondDate0').on('change', function(event){
        event.preventDefault();
        var hasil = hitungDurasi();
        var hargakamar = $('#ttamu-hargaperkamar0').val();
        var jmlkamar = $('#ttamu-list_kamar0').val();
        var subtotal = hargakamar * hasil;

        $('#ttamu-subtotalkamar0').val(subtotal);
        $('#ttamu-durasi0').val(hasil);


        prosesharga(hasil, jmlkamar);
    });

    $('#kolomrole').on('change','.itemappend', function(event){
        event.preventDefault();
        var count = $('.itemappend').length;
        // console.log(count);
        var hasil = hitungDurasi(count);
        var sethargadefault = setHarga(count);
        // console.log(sethargadefault);
        var hargakamar = $('#ttamu-hargaperkamar'+count).val();
        var jmlkamar = $('#ttamu-list_kamar'+count).val();
        var subtotal = hargakamar * hasil;

        $('#ttamu-subtotalkamar'+count).val(subtotal);
        $('#ttamu-durasi'+count).val(hasil);


        prosesharga(hasil, jmlkamar);
    });


    $('.select').on('change', function(event){
        event.preventDefault();
        var hasil = hitungDurasi();
        var jmlkamar = $('#ttamu-list_kamar0').val();
        var idterpilihresult = $('#terpilih').val();
        if( $('#ttamu-durasi').val() == 0 ) {
            return false;
        } else {

            prosesharga(hasil, jmlkamar);
        }
    });

    function setHarga(id=null) {
        var idkamar = $('#ttamu-list_kamar'+id).val();

        return idkamar;
    }

    function delRec(valueT){
        vv--;
        $('#garis'+valueT).remove();
        $('#kolomrole'+valueT).remove();
        $('#remove_role'+valueT).remove();
    }

    function hitungDurasi(id=null)
    {
        const hasil = 0;
        if(id == null) {

            const start= new Date($("#firstDate0").val());
            const end= new Date($("#secondDate0").val());
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        } else {
            const start= new Date($("#firstDate"+id).val());
            const end= new Date($("#secondDate"+id).val());
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        }

        // var days = (end- start) / (1000 * 60 * 60 * 24);
        // const diffTime = Math.abs(end - start);
        // const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        // // var hasil = Math.round(days);
        //
        // return diffDays;
    }

    function setDefault()
    {
        var setdefault = 0;
        var gethargaawal = <?= $ambilharga?>;
        $('#summaryttamu-total_bayar').val(gethargaawal);
        $('#summaryttamu-total_bayar').number( true );
        $('#ttamu-subtotalkamar"'+valueT+'"').val(setdefault);
        $('#ttamu-durasi"'+valueT+'"').val(setdefault);
        // $('#ttamu-harga').val(gethargaawal);
        // $('#ttamu-harga').number( true );
        $('#summaryttamu-sisa').val(setdefault);
        $('#summaryttamu-total_harga').val(gethargaawal);
        $('#summaryttamu-total_harga').number( true );
    }

    function manageMetodePembayaran()
    {
        // Start check radio button
        var val = $("input[name='radionm']:checked").val();
        console.log(val);
        $('.radioid').on('click', function() {
            // var changebrowse = $($('.input-group-append').find('i.glyphicon-folder-open')).parent().removeClass('btn btn-primary btn-file').addClass('btn btn-default btn-file');
            if( $(this).is(":checked") ){
                var val = $(this).val();
                console.log(val);
                if(val == "cash") {
                    $('#idcarddebit').hide();
                    $('#idcarddebit').val("");
                    $('#ttamu-no_kartu_debit').prop('placeholder', 'Masukkan Nomor Kartu Debit ...');
                } else if (val == "debit") {
                    $('#idcarddebit').show();
                    $('#ttamu-no_kartu_debit').prop('placeholder', 'Masukkan Nomor Kartu Debit ...');
                }
            }
        });
        // End check radio button
    }

    function manageSelect()
    {
        // Start check radio button
        var val = $("input[name='radio']:checked").val();
        console.log(val);
        $('.idradio').on('click', function() {
            // var changebrowse = $($('.input-group-append').find('i.glyphicon-folder-open')).parent().removeClass('btn btn-primary btn-file').addClass('btn btn-default btn-file');
            if( $(this).is(":checked") ){
                var val = $(this).val();
                console.log(val);
                if(val == "lunas") {
                    $('#idbayar').show();
                    $('#iddp').hide();
                    $('#summarysummaryttamu-dp').val("");
                    $('#summaryttamu-sisa').val(0);
                    // $('#tdokreferensi-judul_referensi').val("");
                    // $('#tdokreferensi-vendor_referensi').val("");
                    // $('#tdokreferensi-tgl_referensi').val("");
                    // $('#tdokreferensi-deskripsi').val("");
                    // $('#id_ref_type').val('').trigger("change");
                    //
                    // $('#tdokreferensi-nomor_referensi').prop('placeholder', 'Click Here ...');
                    // $('#tdokreferensi-judul_referensi').prop('readonly', true);
                    // $('#tdokreferensi-judul_referensi').prop('placeholder', 'Automatically filled');
                    // $('#tdokreferensi-vendor_referensi').prop('readonly', true);
                    // $('#tdokreferensi-vendor_referensi').prop('placeholder', 'Automatically filled');
                    // $('#tdokreferensi-deskripsi').prop('readonly', true);
                    // $('#tdokreferensi-deskripsi').prop('placeholder', 'Automatically filled');
                    // $('#tdokreferensi-tgl_referensi').prop('readonly', true);
                    // $('#tdokreferensi-tgl_referensi').prop('placeholder', 'Automatically filled');
                    // $('#data_source_reference').prop('disabled', true);
                    // $($('.uhuy').find('i.glyphicon-folder-open')).parent().removeClass('btn btn-primary btn-file').addClass('btn btn-default btn-file');
                    //
                    // $('#tdokreferensi-nomor_referensi').on('click', function() {
                    //     var url = "<?//=\Yii::$app->getUrlManager()->createUrl(['kategoriaset/price/cekdokreferensi']);?>";
                    //     var title = "List Dokumen Referensi";
                    //     showModalPrice(url,title);
                    // });
                } else if (val == "sebagian") {
                    // $('#summaryttamu-total_bayar').val('');
                    $('#idbayar').hide();
                    $('#iddp').show();
                    $('#summarysummaryttamu-dp').val("");
                    $('#summarysummaryttamu-dp').focus();
                    $('#summarysummaryttamu-dp').number( true );
                    // $('#summaryttamu-total_bayar').removeAttr('readonly');


                    // $('#data_source_reference').removeAttr('disabled', true);
                    // $('#tdokreferensi-nomor_referensi').removeAttr('readonly');
                    // $('#tdokreferensi-nomor_referensi').prop('placeholder', 'Typed Here ...');
                    // $('#tdokreferensi-nomor_referensi').prop("onclick", null).off("click");
                    // $('#tdokreferensi-nomor_referensi').val("");
                    // $('#tdokreferensi-id_referensi').val("");
                    // $('#tdokreferensi-judul_referensi').removeAttr('readonly');
                    // $('#tdokreferensi-judul_referensi').val("");
                    // $('#tdokreferensi-vendor_referensi').removeAttr('readonly');
                    // $('#tdokreferensi-vendor_referensi').val("");
                    // $($('.uhuy').find('i.glyphicon-folder-open')).parent().removeClass('btn btn-default btn-file').addClass('btn btn-primary btn-file');
                    // $('#tdokreferensi-tgl_referensi').removeAttr('readonly');
                    // $('#tdokreferensi-tgl_referensi').val("");
                    // $('#tdokreferensi-deskripsi').removeAttr('readonly');
                    // $('#tdokreferensi-deskripsi').val("");
                    //
                    // $('#tdokreferensi-judul_referensi').prop('placeholder', 'Typed Here ...');
                    // $('#tdokreferensi-vendor_referensi').prop('placeholder', 'Typed Here ...');
                    // $('#tdokreferensi-deskripsi').prop('placeholder', 'Typed Here ...');
                    // $('#tdokreferensi-tgl_referensi').prop('placeholder', 'Choose Date ...');
                }
            }
        });
        // End check radio button
    }


    $("#summarysummaryttamu-dp").keyup(function(){
        var total = $("#summaryttamu-total_harga").val();
        var dp = $("#summarysummaryttamu-dp").val();
        var hasil = total - dp;
        $("#summaryttamu-sisa").val(hasil);
        $('#summaryttamu-sisa').number( true );
    });

    function prosesharga(hasil, jmlkamar) {
        $.ajax({
            type: "GET",
            // data: {hasil:hasil},
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/hitungharga'])?>?hasil="+hasil+'&jmlkamar='+jmlkamar,

            success: function(result) {
                // $('#ttamu-harga').val(result.sumharga);
                // $('#ttamu-harga').number( true );
                $('#hargaterpilih').val(result.hargaperkamar);
                $('#summaryttamu-total_harga').val(result.sumharga);
                $('#summaryttamu-total_bayar').val(result.sumharga);
                $('#kamarterpilih').val(result.expjmlkamar);
                $('#ttamu_sisa').val("0");
                // alert(result);
                return false;
            },
            error: function(xhr, ajaxOptions, thrownError) {
                swal("Error submiting!", "Please try again", "error");
            }
        });
    }

    function pilihkamar(id) {
        var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/listkamar']);?>?id="+id;
        var title = "Pilih Kamar";
        showModalPilihkamar(url,title);
    }

    function savecekin(id) {
        {
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
                                window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/index'])?>";
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
                                    '<select id="ttamu-list_kamar'+valueT+'" class="form-control select validate[required]" name="TTamu[list_kamar]">' +
                                    '<option>Pilih Kamar ...</option>' +
                                        <?php
                                        foreach ($listkamar as $idx => $value) {
                                        ?>

                                            '<option value="<?php echo $value['id'];?>">Kamar <?php echo $value['nomor_kamar'];?> / <?php echo $value['type'];?></option>' +

                                        <?php } ?>

                                    '</select>' +
                                '</div>' +
                            '</div>'+
                            '<div class="col-md-2">' +
                                '<div class="form-group required">' +
                                    '<label class="control-label" required>Checkin </label>' +
                                    '<input type="text" id="firstDate'+valueT+'" class="form-control form-tanggal" name="TTamu[checkin]" placeholder="Klik disini ..." autocomplete="off">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-2">' +
                                '<div class="form-group required">' +
                                    '<label class="control-label" required>Checkout </label>' +
                                    '<input type="text" id="secondDate'+valueT+'" class="form-control form-tanggal" name="TTamu[checkout]" placeholder="Klik disini ..." autocomplete="off">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-1">' +
                                '<div class="form-group">' +
                                    '<label class="control-label">Durasi </label>' +
                                    '<input type="text" value="0" id="ttamu-durasi'+valueT+'" class="form-control cl_durasi" name="TTamu[durasi]" readonly="true">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-2">' +
                                '<div class="form-group">' +
                                    '<label class="control-label">Harga Kamar </label>' +
                                    '<input type="text" value="0" id="ttamu-hargaperkamar'+valueT+'" class="form-control cl_hargaperkamar" name="TTamu[hargaperkamar]" readonly="true">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-2">' +
                                '<div class="form-group">' +
                                    '<label class="control-label">SubTotal</label>' +
                                    '<input type="text" value="0" id="ttamu-subtotalkamar'+valueT+'" class="form-control cl_subtotalkamar" name="TTamu[subtotalkamar]" readonly="true">' +
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
                autoclose: true
            });

            // $('#secondDate').on('change', function(event){
            //     event.preventDefault();
            //     var hasil = hitungDurasi();
            //     var hargakamar = $('#ttamu-hargaperkamar"'+valueT+'"').val();
            //     // var_dump(hargakamar);exit;
            //     var subtotal = hargakamar * hasil;
            //
            //     $('.cl_subtotalkamar').val(subtotal);
            //     $('#ttamu-durasi').val(hasil);
            //
            //     prosesharga(hasil, jmlkamar);
            // });
            //
            //
            // $('.select').on('change', function(event){
            //     event.preventDefault();
            //     var hasil = hitungDurasi();
            //     var jmlkamar = $('.select').val();
            //     var idterpilihresult = $('#terpilih').val();
            //     if( $('#ttamu-durasi').val() == 0 ) {
            //         return false;
            //     } else {
            //
            //         prosesharga(hasil, jmlkamar);
            //     }
            // });

            // $('.select2-selection__choice__remove').on('change', function(event){
            //     event.preventDefault();
            //     var hasil = hitungDurasi();
            //     var jmlkamar = $('.select').val();
            //
            //     var idterpilihresult = $('#terpilih').val();
            //     prosesharga(hasil, jmlkamar);
            // });



            // setDefault();
        });
    }

    // js hadi
    $(document).on('change','.pilih_kamar',function(){
        var harga = $('option:selected', this).attr('harga');
        var urutan = $(this).attr('urutan');
        $('#ttamu-hargaperkamar'+urutan).val(harga);
    });
</script>
<div id="comcounter" hidden>0</div>
