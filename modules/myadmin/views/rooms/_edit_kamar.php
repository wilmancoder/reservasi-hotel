<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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
                    "id" => "form-ganti",
                    "class" => "",
                    'onsubmit'=>'return false;',
                    // "data-parsley-validate" => "",
                    // 'enctype'=>'multipart/form-data',
                    // 'novalidate' => 'novalidate'
                ]
            ]); ?>

            <div class="box-body">
                <div class='row'>
                    <div class='col-md-12'>
                        <?php if($tipe == 1) { ?>
                            <div class='form-group'>
                                <label class="control-label title">Kategori Harga Normal</label>
                            </div>
                        <?php } else { ?>
                            <div class='form-group'>
                                <label class="control-label title">Kategori Harga Weekend</label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        <label class="control-label">Nomor Kamar</label>
                    </div>
                    <div class='col-md-2'>
                        <label class="control-label">Checkin</label>
                    </div>
                    <div class='col-md-2'>
                        <label class="control-label">Checkout</label>
                    </div>
                    <div class='col-md-2'>
                        <label class="control-label">Harga Perhari</label>
                    </div>
                    <div class='col-md-2'>
                        <label class="control-label">Lama Menginap</label>
                    </div>
                    <div class='col-md-2'>
                        <label class="control-label">Sub Total</label>
                    </div>
                </div>
                <?php
                $grandtotal = 0;
                foreach ($ambilDatatamu as $key => $value) {
                    echo "
                        <div class='row'>
                            <div class='col-md-2'>
                                <div class='form-group required'>
                                    <input type='text' class='form-control' name='kamar' value='".$value['nomor_kamar']."' disabled='true'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <div class='form-group required'>
                                    <input type='text' class='form-control' name='checkin' value='".$value['checkin']."' disabled='true'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <div class='form-group required'>
                                    <input type='text' class='form-control' name='checkout' value='".$value['checkout']."' disabled='true'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <div class='form-group required'>
                                    <input type='text' class='form-control' name='harga' value='"."Rp. " . \app\components\Logic::formatNumber($value['harga'], 0)."' disabled='true'>
                                    <input type='hidden' name='katharga' id='katharga' value='".$value['harga']."'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <div class='form-group required'>
                                    <input type='text' class='form-control' name='durasi' value='".$value['durasi']." Hari' disabled='true'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <div class='form-group required'>
                                    <input type='text' class='form-control' name='subtotal' value='"."Rp. " . \app\components\Logic::formatNumber($value['subtotal'], 0)."' disabled='true'>
                                </div>
                            </div>
                        </div>
                    ";

                }
                ?>
                <!-- <hr> -->
            </div>
            <input type="hidden" name="id" id="id-kamar" value="<?= $id ?>">
            <input type="hidden" name="tipe" id="tipe" value="<?= $tipe ?>">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link active" href="#tambah_durasi" role="tab" data-toggle="tab">Tambah Durasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pindah_kamar" role="tab" data-toggle="tab">Pindah Kamar</a>
                </li>
            </ul>
            </br>
                <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="tambah_durasi">
                    <div class="form-group">
                        <label class="control-label" for="exampleInputEmail1">Tambah Berapa hari ?</label>
                        <input type="number" class="form-control" id="jumah_hari" value=0  placeholder="HARI" flag='normalhari'>
                    </div>
                    <div class="form-group">
                          <input type="checkbox" name="add_half" class="claddhalf" value="setengah" flag='setengahhari'>
                          <span>Ceklist jika ingin tambah durasi <strong>Setengah Hari.</strong></span>
                    </div>
                    <div class="form-group">
                        <button type="button" id="btn-durasi" class="btn btn-success pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                        <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Close', ['class' => 'btn btn-danger pull-right geserkanan', 'data-dismiss' => 'modal']) ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="pindah_kamar">
                    <div class="row"></div>
                        <div class="box box-warning">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12" id="kolomrole">
                                        <?php if($tipe == 1) { ?>
                                            <div class="form-group">
                                                  <input type="checkbox" name="weekend" class="clweekend" value="2" lawan="1">
                                                  <span>Ceklist jika ingin dirubah ke kategori <strong>Harga Weekend.</strong></span>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group">
                                                  <input type="checkbox" name="normal" class="clnormal" value="1" lawan="2">
                                                  <span>Ceklist jika ingin dirubah ke kategori <strong>Harga Normal.</strong></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="kolomrole">
                                        <div class="row fit" id="kolomrole0">
                                            <div class="col-md-3">
                                                <div class="form-group required" id="divgantikamar">
                                                    <label class="control-label" required>List Kamar </label>
                                                    <select id="gantikamar-id" class="form-control select validate[required] pilih_kamar" urutan='0' name="TTamu[list_kamar]">
                                                    <option selected='selected'>Pilih Kamar ...</option>
                                                    <?php
                                                    foreach ($listkamar as $idx => $value) {
                                                        // $selected = '';
                                                        // if($value['id'] == $id){
                                                        //     $selected = 'selected';
                                                        // }
                                                    ?>
                                                        <option value="<?php echo $value['id'];?>" harga="<?= $value['harga'] ?>" nomor_kamar="<?= $value['nomor_kamar'] ?>">Kamar <?php echo $value['nomor_kamar'];?> / <?php echo $value['type'];?></option>
                                                    <?php } ?>

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group required">
                                                    <?= $form->field($model, 'checkin')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal', 'id' =>'firstDate0', 'placeholder' => 'Klik disini ...', 'autocomplete' => 'off','readonly'=>true]) ?>
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
                                            <input type="hidden" id="nomor_kamar0" name='TTamu[nomor_kamar]' value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" id="btn-ganti" class="btn btn-success pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                            <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Close', ['class' => 'btn btn-danger pull-right geserkanan', 'data-dismiss' => 'modal']) ?>
                        </div>
                    </div>
                </div>
            </div>


            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<script type="text/javascript">
    var id = <?= $id?>;
    var vv = 0;
    $(document).ready(function () {
        $('#btn-durasi').click(function(){
            var id = $('#id-kamar').val();
            var tipe = $('#tipe').val();
            var idkamar = <?= $idkamar?>;
            var hari = $('#jumah_hari').val();
            var katharga = $('#katharga').val();
            if ($('.claddhalf').is(':checked')) {
                var flag = $('.claddhalf').attr('flag');
            } else if (!$('.claddhalf').is(':checked')) {
                var flag = 'normalhari';
            }
            // alert(flag); return false;
            $.ajax({
                type: "GET",
                dataType :'json',
                url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/tambahdurasi'])?>?id="+id+'&tipe='+tipe+'&hari='+hari+'&katharga='+katharga+'&flag='+flag+'&idkamar='+idkamar,
                beforeSend: function () {
                    swal({
                        title: 'Harap Tunggu',
                        text: "Sedang memproses checkout",
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
                success: function(result) {
                    swal(result.header, result.message, result.status);
                    // alert(result.idtamu); return false;
                    if (result.status == "success") {
                        $('#modalPilihkamarId').modal('hide');
                        $.ajax({
                            url: "<?= Url::to(['/myadmin/rooms/createdone']) ?>?idttamu="+result.idttamu,
                            beforeSend: function(data, v) {
                                $('#modalRoomsId #modalRoomsTitle').html('Form Check');
                                $('#modalRoomsId #modalRoomsBody').html('Loading ...');
                            },
                            error: function(data, v){
                                $('#modalRoomsId #modalRoomsBody').html('Terjadi kesalahan..');
                            },
                            success: function(data, v){
                                $('#modalRoomsId #modalRoomsBody').html(data);
                            }
                        });

                        $('#modalRoomsId').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        // window.location = "<?//=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/index'])?>?idharga="+tipe;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", "Please try again", "error");
                }
            });
        });

        $('#btn-ganti').click(function(){
            var id = $('#id-kamar').val();
            var idkamar = <?= $idkamar?>;
            var tipe = $('#tipe').val();
            var newkamar = $('#gantikamar-id').val();
            var _data = new FormData($("#form-ganti")[0]);
            $.ajax({
                type: "POST",
                data: _data,
                dataType: "json",
                contentType: false,
                processData: false,
                url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/gantikamar'])?>?id="+id+'&idkamar='+idkamar+'&tipe='+tipe+'&newkamar='+newkamar,
                beforeSend: function () {
                    swal({
                        title: 'Harap Tunggu',
                        text: "Sedang memproses checkout",
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
                        $('#modalPilihkamarId').modal('hide');
                        $.ajax({
                            url: "<?= Url::to(['/myadmin/rooms/createdone']) ?>?idttamu="+result.idttamu,
                            beforeSend: function(data, v) {
                                $('#modalRoomsId #modalRoomsTitle').html('Form Check');
                                $('#modalRoomsId #modalRoomsBody').html('Loading ...');
                            },
                            error: function(data, v){
                                $('#modalRoomsId #modalRoomsBody').html('Terjadi kesalahan..');
                            },
                            success: function(data, v){
                                $('#modalRoomsId #modalRoomsBody').html(data);
                            }
                        });

                        $('#modalRoomsId').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        // window.location = "<?//=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/index'])?>?idharga="+tipe;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal("Error!", "Terdapat Kesalahan saat memproses check-in!", "error");
                }
            });
        });


        formattingFirstDate();
        formattingSecondDate();
        $(".pilih").select2();

        $(".select").select2();

        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });
        $('.form-tanggal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });


        // $('#ttamu-hargaperkamar0').val(ambilhargaperkamar);
        $('#firstDate0').val(formattingFirstDate());
        $('#secondDate0').val(formattingSecondDate());
        $('#ttamu-durasi0').val(1);
        // $('#ttamu-subtotalkamar0').val(ambilhargaperkamar);


        // setDefault();
    });

    $(document).on('change','.claddhalf',function(){
        if ($(this).is(':checked')) {
            $('#jumah_hari').attr('disabled',true);
        }
    });

    $(document).on('change','.clweekend',function(){
        if ($(this).is(':checked')) {
            var tipe = $('.clweekend').val();
            $.ajax({
                type: "GET",
                dataType :'json',
                url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/gantikategoriharga'])?>?id="+id+"&tipe="+tipe,
                beforeSend: function () {
                    swal({
                        title: 'Harap Tunggu',
                        text: "Sedang Proses ...",
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
                success: function(result) {

                    $('#ttamu-hargaperkamar0').val('');
                    $('#gantikamar-id').empty();
                    // var options=$('<select>');
                    $('#gantikamar-id').append($('<option>').text("Pilih Kamar ..."));
                    $.each(result.listkamar, function(i, obj) {
                        $('#gantikamar-id').append($('<option>').text('Kamar '+obj.nomor_kamar+' / '+obj.type).attr('value', obj.id).attr('harga', obj.harga).attr('nomor_kamar', obj.nomor_kamar));
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", "Please try again", "error");
                }
            });

        } else if (!$(this).is(':checked')) {
            var tipe = $(".clweekend").attr("lawan");
            $.ajax({
                type: "GET",
                dataType :'json',
                url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/gantikategoriharga'])?>?id="+id+"&tipe="+tipe,
                beforeSend: function () {
                    swal({
                        title: 'Harap Tunggu',
                        text: "Sedang Proses ...",
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
                success: function(result) {

                    $('#ttamu-hargaperkamar0').val('');
                    $('#gantikamar-id').empty();
                    // var options=$('<select>');
                    $('#gantikamar-id').append($('<option>').text("Pilih Kamar ..."));
                    $.each(result.listkamar, function(i, obj) {
                        $('#gantikamar-id').append($('<option>').text('Kamar '+obj.nomor_kamar+' / '+obj.type).attr('value', obj.id).attr('harga', obj.harga).attr('nomor_kamar', obj.nomor_kamar));
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", "Please try again", "error");
                }
            });
        }

    });

    $(document).on('change','.clnormal',function(){
        if ($(this).is(':checked')) {
            var tipe = $('.clnormal').val();
            $.ajax({
                type: "GET",
                dataType :'json',
                url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/gantikategoriharga'])?>?id="+id+"&tipe="+tipe,
                beforeSend: function () {
                    swal({
                        title: 'Harap Tunggu',
                        text: "Sedang Proses ...",
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
                success: function(result) {
                    $('#ttamu-hargaperkamar0').val('');
                    $('#gantikamar-id').empty();
                    // var options=$('<select>');
                    $('#gantikamar-id').append($('<option>').text("Pilih Kamar ..."));
                    $.each(result.listkamar, function(i, obj) {
                        $('#gantikamar-id').append($('<option>').text('Kamar '+obj.nomor_kamar+' / '+obj.type).attr('value', obj.id).attr('harga', obj.harga).attr('nomor_kamar', obj.nomor_kamar));
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", "Please try again", "error");
                }
            });

        } else if (!$(this).is(':checked')) {
            var tipe = $(".clweekend").attr("lawan");
            $.ajax({
                type: "GET",
                dataType :'json',
                url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/gantikategoriharga'])?>?id="+id+"&tipe="+tipe,
                beforeSend: function () {
                    swal({
                        title: 'Harap Tunggu',
                        text: "Sedang Proses ...",
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
                success: function(result) {

                    $('#ttamu-hargaperkamar0').val('');
                    $('#gantikamar-id').empty();
                    // var options=$('<select>');
                    $('#gantikamar-id').append($('<option>').text("Pilih Kamar ..."));
                    $.each(result.listkamar, function(i, obj) {
                        $('#gantikamar-id').append($('<option>').text('Kamar '+obj.nomor_kamar+' / '+obj.type).attr('value', obj.id).attr('harga', obj.harga).attr('nomor_kamar', obj.nomor_kamar));
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", "Please try again", "error");
                }
            });
        }

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

    // function delRec(valueT){
    //     vv--;
    //     $('#garis'+valueT).remove();
    //     $('#kolomrole'+valueT).remove();
    //     $('#remove_role'+valueT).remove();
    //     $('#summaryttamu-dp').val(0);
    //     $('#summaryttamu-dp').number(true);
    //     // $('#summaryttamu-sisa').val( $('#summaryttamu-dp').val() );
    //     total();
    // }

    function hitungDurasi(id=null)
    {
        const hasil = 0;
        const start= new Date($("#firstDate"+id).val());
        const end= new Date($("#secondDate"+id).val());
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays;
    }

    // function setDefault()
    // {
    //     var setdefault = 0;
    //     // $('#summaryttamu-total_bayar').val(gethargaawal);
    //     $('#summaryttamu-total_bayar').number( true );
    //     // $('#summaryttamu-total_harga').val(gethargaawal);
    //     $('#summaryttamu-total_harga').number( true );
    //     $('#summaryttamu-sisa').val(setdefault);
    //     $('#summaryttamu-sisa').number( true );
    //     $('#summaryttamu-dp').val(0);
    //     $('#summaryttamu-dp').number( true );
    //
    //     $('#ttamu-subtotalkamar"'+valueT+'"').val(setdefault);
    //     $('#ttamu-durasi"'+valueT+'"').val(setdefault);
    // }


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

            } else {
                // return false;


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
        var urutan = $(this).attr('urutan');
        $('#summaryttamu-dp').val(0);
        $('#summaryttamu-dp').number(true);
        field_kamar(urutan);

        // prosesharga(hasil, jmlkamar);
    });

    function field_kamar(urutan){
        var hasil = hitungDurasi(urutan);
        // alert(hasil);
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
                    $('#summaryttamu-dp').val($('#summaryttamu-total_harga').val());
                    $('#iddp').hide();
                    $('.field-summaryttamu-total_harga').show();
                    $('#summaryttamu-sisa').val(0);
                    total();
                }
                else{
                    $('.field-summaryttamu-total_harga').hide();
                    $('#summaryttamu-dp').val(0);
                    $('#summaryttamu-dp').number( true );
                    $('#summaryttamu-dp').focus();
                    // $('#summaryttamu-sisa').val( $('#summaryttamu-total_bayar').val() )
                    $('#iddp').show();
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
