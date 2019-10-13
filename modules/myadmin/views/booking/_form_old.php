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

</style>
<div class="box box-warning">
    <div class="box-body">
        <div class="booking-form">

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
                        <div class="col-md-12">
                            <label class="control-label">Tambah Kamar</label>
                            <?= $form->field($model, 'list_kamar')->dropDownList(Yii::$app->Logic->arrKamarbooking(), ['class' => 'form-control select validate[required]', 'multiple'=>'multiple'])->label(false); ?>
                            <!-- <input type="hidden" class="form-control" name="terpilih" id="terpilih" value="<?//= $id?>"> -->
                            <input type="hidden" class="form-control" name="kamarterpilih" id="kamarterpilih" value="">
                            <input type="hidden" class="form-control" name="hargaterpilih" id="hargaterpilih" value="">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group required">
                                <?= $form->field($model, 'checkin')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal', 'id' =>'firstDate', 'placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group required">
                                <?= $form->field($model, 'checkout')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal', 'id' =>'secondDate', 'placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= $form->field($model, 'durasi')->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => true]); ?>
                            </div>
                        </div>
                        <!-- <div class="col-md-3">
                            <div class="form-group">
                                <?//= $form->field($model, 'harga')->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => true]); ?>
                            </div>
                        </div> -->
                    </div>
                    <div class="row" id="generatekamar">

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
                                          <input type="radio" name="TBooking[radionm]" class="radioid" value="cash">
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
                    <?=Html::a($model->isNewRecord ? '<i class="fa fa-floppy-o" aria-hidden="true"></i> Checkin'  : '<i class="fa fa-pencil" aria-hidden="true"></i> Update',$model->isNewRecord ? 'javascript:savebooking()':'javascript:updatebooking()',['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
                    <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> -->
                    <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Close', ['class' => 'btn btn-danger pull-right geserkanan', 'data-dismiss' => 'modal']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

    $(".pilih").select2();

    $(".select").select2({
        placeholder: "Pilih Kamar ...",
    });

        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });
        $('.form-tanggal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });


        $('#secondDate').on('change', function(event){
            event.preventDefault();
            var hasil = hitungDurasi();
            var jmlkamar = $('.select').val();
            $('#tbooking-durasi').val(hasil+" Hari");
            prosesharga(hasil, jmlkamar);
        });


        $('.select').on('change', function(event){
            event.preventDefault();
            var hasil = hitungDurasi();
            var jmlkamar = $('.select').val();
            if( $('#tbooking-durasi').val() == 0 ) {
                return false;
            } else {

                prosesharga(hasil, jmlkamar);
            }
        });

        $('.select2-selection__choice__remove').on('change', function(event){
            event.preventDefault();
            var hasil = hitungDurasi();
            var jmlkamar = $('.select').val();
            prosesharga(hasil, jmlkamar);
        });


        setDefault();
        manageSelect();
        manageMetodePembayaran();
    });

    function hitungDurasi()
    {
        const hasil = 0;
        const start= new Date($("#firstDate").val());
        const end= new Date($("#secondDate").val());

        // var days = (end- start) / (1000 * 60 * 60 * 24);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        // var hasil = Math.round(days);

        return diffDays;
    }

    function setDefault()
    {
        var setdefault = 0;
        // var gethargaawal = <?//= $ambilharga?>;
        $('#summarybooking-total_bayar').val();
        $('#summarybooking-total_bayar').number( true );
        // $('#ttamu-harga').val();
        // $('#ttamu-harga').number( true );
        $('#summarybooking-sisa').val(setdefault);
        $('#tbooking-durasi').val(setdefault);
        $('#summarybooking-total_harga').val();
        $('#summarybooking-total_harga').number( true );
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
                    $('#tbooking-no_kartu_debit').prop('placeholder', 'Masukkan Nomor Kartu Debit ...');
                } else if (val == "debit") {
                    $('#idcarddebit').show();
                    $('#tbooking-no_kartu_debit').prop('placeholder', 'Masukkan Nomor Kartu Debit ...');
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
                    $('#summarybooking-dp').val("");
                    $('#summarybooking-sisa').val(0);
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
                    // $('#summarybooking-total_bayar').val('');
                    $('#idbayar').hide();
                    $('#iddp').show();
                    $('#summarybooking-dp').val("");
                    $('#summarybooking-dp').focus();
                    $('#summarybooking-dp').number( true );
                    // $('#summarybooking-total_bayar').removeAttr('readonly');


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


    $("#summarybooking-dp").keyup(function(){
        var total = $("#summarybooking-total_harga").val();
        var dp = $("#summarybooking-dp").val();
        var hasil = total - dp;
        $("#summarybooking-sisa").val(hasil);
        $('#summarybooking-sisa').number( true );
    });

    function prosesharga(hasil, jmlkamar) {
        $.ajax({
            type: "GET",
            // data: {hasil:hasil},
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/booking/hitungharga'])?>?hasil="+hasil+'&jmlkamar='+jmlkamar,

            success: function(result) {
                // $('#ttamu-harga').val(result.sumharga);
                // $('#ttamu-harga').number( true );
                $('#hargaterpilih').val(result.hargaperkamar);
                $('#kamarterpilih').val(result.expjmlkamar);
                $('#summarybooking-total_harga').val(result.sumharga);
                $('#summarybooking-total_bayar').val(result.sumharga);
                $('#summarybooking-sisa').val("0");
                // alert(result);
                return false;
            },
            error: function(xhr, ajaxOptions, thrownError) {
                swal("Error submiting!", "Please try again", "error");
            }
        });
    }

    function pilihkamar(id) {
        var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/booking/listkamar']);?>?id="+id;
        var title = "Pilih Kamar";
        showModalPilihkamar(url,title);
    }

    function savebooking() {
        {
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
                        url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/booking/create'])?>",
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
                                window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/booking/index'])?>";
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

    function UpdateArtikel(id) {
        {
            swal({
                title: "Konfirmasi",
                text: "Ubah Artikel ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((ya) => {
                if (ya) {
                    var _data = new FormData($("#form-artikel")[0]);
                    $.ajax({
                        type: "POST",
                        data: _data,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        url: "<?=\Yii::$app->getUrlManager()->createUrl(['adm/update'])?>?id=" + id,
                        beforeSend: function () {
                            swal({
                                title: 'Harap Tunggu',
                                text: "Mengubah Artikel Baru",
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
                                window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['adm/artikel'])?>";
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Error!", "Terdapat Kesalahan saat memasukan Menu!", "error");
                        }
                    });
                } else {
                    // swal("Informasi", "Dokumen Tidak Dihapus", "info");
                }
            });
        }
    }

    // $('#tbooking-list_kamar').on('select2:select', function (e) {
    // var myStr = e.params.data;
    // var dat = myStr.text;
    // // var hasil = dat.replace(/ /g, ',');
    // var hasil = dat.split(" ");
    // $('#firstDate').val(hasil[7]);
    // console.log(hasil[7]);
    // });
</script>
