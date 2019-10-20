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
    #ttamu-bayar {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
    }
    #ttamu-dp {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
    }
    #ttamu-sisa {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
    }
    #ttamu-totalharga {
        font-size: 20px;
        font-weight: bold;
        color: green;
        text-align: center;
        padding-top: 10px;
        /* padding: 25px 50px 75px 100px; */
    }

</style>
<div class="box box-warning">
    <div class="box-body">
        <div class="done-form">
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
                    "id" => "form-done",
                    "class" => "",
                    'onsubmit'=>'return false;',
                    // "data-parsley-validate" => "",
                    // 'enctype'=>'multipart/form-data',
                    // 'novalidate' => 'novalidate'
                ]
            ]); ?>
            <div class="row">
                <div class="col-md-6">
                    <div id="box-confirm">
                        <div id="information">
                            <p>
                                <span class="field">Nama Tamu</span>
                                <span class="value"><?=$ambilDatatamu[0]['namatamu']?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="box-confirm">
                        <div id="information">
                            <p>
                                <span class="field">Identitas</span>
                                <span class="value"><?=$ambilDatatamu[0]['identitas']?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id="box-confirm">
                        <div id="information">
                            <p>
                                <span class="field">Alamat</span>
                                <span class="value"><?=$ambilDatatamu[0]['alamat']?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="box-confirm">
                        <div id="information">
                            <p>
                                <span class="field">Nomor Identitas</span>
                                <span class="value"><?=$ambilDatatamu[0]['nomor_identitas']?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="box box-warning">
                <div class="box-body">
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
                        if($value['status'] == 1){
                            $ck = "<input type='checkbox' name='nomor_kamar[]' class='cek_kamar' urutan='".$value['id']."' value='".$value['nomor_kamar']."'>
                            <input type='checkbox' style='display:none' name='id_tamu[]' value='".$value['id']."' id='id-".$value['id']."'>";
                        }
                        else{
                            $ck = "Telah Checkout";
                        }
                        echo $ck."
                            <input type='hidden' name='id_biodata_tamu' value='".$value['id_biodata_tamu']."'>
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

                        $grandtotal += $value['subtotal'];
                        $dpsummary = $value['summary_dp'];
                        $sisasummary = $value['summary_sisa'];
                        $totalhargasummary = $value['total_harga'];
                        $totalbayarsummary = $value['total_bayar'];
                        $jenisPembayaran = $value['jenis'];

                    }
                    ?>
                    <div class="row pull-right">
                        <div class='col-md-12'>
                            <label class="control-label"><?= "Rp. " . \app\components\Logic::formatNumber($totalhargasummary, 0)?></label>
                        </div>
                    </div>
                    <!-- <hr> -->
                </div>
            </div>

            <div class="box box-warning">
                <div class="box-body">
                    <div class='row'>
                        <div class="col-md-6">
                            <div id="box-confirm">
                                <div id="information">
                                    <p>
                                        <span class="field">Jenis Pembayaran</span>
                                        <span class="value"><?=$ambilDatatamu[0]['jenis']?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="box-confirm">
                                <div id="information">
                                    <p>
                                        <span class="field">Metode Pembayaran</span>
                                        <span class="value"><?=$ambilDatatamu[0]['metode']?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-warning">
                <div class="box-body">
                    <div class='row'>
                        <?php if($jenisPembayaran == "lunas"  || $sisasummary == 0) { ?>
                            <div class='col-md-4'>
                                <label class="control-label">Bayar</label>
                            </div>
                        <?php } else {?>
                            <div class='col-md-4'>
                                <label class="control-label">DP</label>
                            </div>
                        <?php } ?>
                        <div class='col-md-4'>
                            <label class="control-label">Sisa</label>
                        </div>
                        <div class='col-md-4'>
                            <label class="control-label">Total Harga</label>
                        </div>
                    </div>
                    <div class="row">
                        <?php if($jenisPembayaran == "lunas"  || $sisasummary == 0) { ?>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <input type="text" class="form-control" name="bayar" value="Rp. <?= \app\components\Logic::formatNumber($totalbayarsummary, 0)?>" readonly='true'>
                                </div>
                            </div>
                        <?php } else {?>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <input type="text" class="form-control" name="dp" value="Rp. <?= \app\components\Logic::formatNumber($dpsummary, 0)?>" readonly='true'>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-4">
                            <div class="form-group required">
                                <input type="text" class="form-control" name="sisa" value="Rp. <?= \app\components\Logic::formatNumber($sisasummary, 0)?>" readonly='true'>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group required">
                                <input type="text" class="form-control" name="totalharga" value="Rp. <?= \app\components\Logic::formatNumber($totalhargasummary, 0)?>" readonly='true'>
                            </div>
                        </div>
                    </div>
                    <?php if($jenisPembayaran == "lunas"  || $sisasummary == 0) { ?>
                        <div class="row" style="display:none">
                            <div class="col-md-6">
                                <div class="form-group">
                                      <input type="checkbox" name="pelunasan" class="idpelunasan" value="pelunasan">
                                      <span>Ceklist jika anda telah menerima pelunasan pembayaran.</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="row" style="display:block">
                            <div class="col-md-6">
                                <div class="form-group">
                                      <input type="checkbox" name="pelunasan" class="idpelunasan" value="pelunasan">
                                      <span>Ceklist jika anda telah menerima pelunasan pembayaran.</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="bayarpelunasan" id="bayarpelunasan" disabled = "disabled" class="form-control" value="<?= $totalhargasummary?>">
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <?php if($jenisPembayaran == "lunas"  || $sisasummary == 0) { ?>
                        <?=Html::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Checkout',['class' => 'btn btn-success pull-right', 'onclick' => 'savecekout('.$idbiodata.')', 'id' => 'idcekout']) ?>
                    <?php } else {?>
                        <?=Html::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Checkout',['class' => 'btn btn-success pull-right', 'onclick' => 'savecekout('.$idbiodata.')', 'id' => 'idcekout', 'disabled' => 'disabled']) ?>
                    <?php } ?>
                    <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Close', ['class' => 'btn btn-danger pull-right geserkanan', 'data-dismiss' => 'modal']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

    $(document).on('change','.idpelunasan',function(){
        var urutan = $(this).attr('urutan');
        if ($(this).is(':checked')) {
            $('#idcekout').prop('disabled', false);
            $('#bayarpelunasan').prop('disabled', false);
        }
        else{
            $('#idcekout').prop('disabled', true);
            $('#bayarpelunasan').prop('disabled', true);
        }
    });


    $(document).on('change','.cek_kamar',function(){
        var urutan = $(this).attr('urutan');
        if ($(this).is(':checked')) {
            $('#id-'+urutan).trigger('click');
        }
        else{
            $('#id-'+urutan).trigger('click');
        }
    });


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
            $('#ttamu-durasi').val(hasil+" Hari");

            var idterpilihresult = $('#terpilih').val();
            prosesharga(hasil, jmlkamar, idterpilihresult);
        });


        $('.select').on('change', function(event){
            event.preventDefault();
            var hasil = hitungDurasi();
            var jmlkamar = $('.select').val();
            var idterpilihresult = $('#terpilih').val();
            if( $('#ttamu-durasi').val() == 0 ) {
                return false;
            } else {

                prosesharga(hasil, jmlkamar, idterpilihresult);
            }
        });

        $('.select2-selection__choice__remove').on('change', function(event){
            event.preventDefault();
            var hasil = hitungDurasi();
            var jmlkamar = $('.select').val();

            var idterpilihresult = $('#terpilih').val();
            prosesharga(hasil, jmlkamar, idterpilihresult);
        });


        // setDefault();
        manageSelect();
        manageMetodePembayaran();
    });

    function hitungDurasi()
    {
        var hasil = 0;
        var start= $("#firstDate").datepicker("getDate");
        var end= $("#secondDate").datepicker("getDate");
        var days = (end- start) / (1000 * 60 * 60 * 24);
        var hasil = Math.round(days);

        return hasil;
    }

    // function setDefault()
    // {
    //     var setdefault = 0;
    //     $('#ttamu-bayar').val(gethargaawal);
    //     $('#ttamu-bayar').number( true );
    //     $('#ttamu-harga').val(gethargaawal);
    //     $('#ttamu-harga').number( true );
    //     $('#ttamu-sisa').val(setdefault);
    //     $('#ttamu-durasi').val(setdefault);
    //     $('#ttamu-totalharga').val(gethargaawal);
    //     $('#ttamu-totalharga').number( true );
    // }

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

    // function manageSelect()
    // {
    //     // Start checkbox
    //     // var val = $("input[name='pelunasan']:checked").val();
    //     // console.log(val); return false;
    //     $( "input[type=checkbox]" ).on('click', function() {
    //         // event.preventDefault();
    //         // var changebrowse = $($('.input-group-append').find('i.glyphicon-folder-open')).parent().removeClass('btn btn-primary btn-file').addClass('btn btn-default btn-file');
    //         if( $('.idpelunasan').is(":checked") ){
    //             var val = $(this).val();
    //             // console.log(val); return false;
    //             if(val == "pelunasan") {
    //                 $('#idcekout').prop('disabled', false);
    //                 // $('#bayarpelunasan').prop('disabled', false);
    //                 // $('#idbayar').show();
    //                 // $('#iddp').hide();
    //                 // $('#ttamu-dp').val("");
    //                 // $('#ttamu-sisa').val(0);
    //                 // $('#tdokreferensi-judul_referensi').val("");
    //                 // $('#tdokreferensi-vendor_referensi').val("");
    //                 // $('#tdokreferensi-tgl_referensi').val("");
    //                 // $('#tdokreferensi-deskripsi').val("");
    //                 // $('#id_ref_type').val('').trigger("change");
    //                 //
    //                 // $('#tdokreferensi-nomor_referensi').prop('placeholder', 'Click Here ...');
    //                 // $('#tdokreferensi-judul_referensi').prop('readonly', true);
    //                 // $('#tdokreferensi-judul_referensi').prop('placeholder', 'Automatically filled');
    //                 // $('#tdokreferensi-vendor_referensi').prop('readonly', true);
    //                 // $('#tdokreferensi-vendor_referensi').prop('placeholder', 'Automatically filled');
    //                 // $('#tdokreferensi-deskripsi').prop('readonly', true);
    //                 // $('#tdokreferensi-deskripsi').prop('placeholder', 'Automatically filled');
    //                 // $('#tdokreferensi-tgl_referensi').prop('readonly', true);
    //                 // $('#tdokreferensi-tgl_referensi').prop('placeholder', 'Automatically filled');
    //                 // $('#data_source_reference').prop('disabled', true);
    //                 // $($('.uhuy').find('i.glyphicon-folder-open')).parent().removeClass('btn btn-primary btn-file').addClass('btn btn-default btn-file');
    //                 //
    //                 // $('#tdokreferensi-nomor_referensi').on('click', function() {
    //                 //     var url = "<?//=\Yii::$app->getUrlManager()->createUrl(['kategoriaset/price/cekdokreferensi']);?>";
    //                 //     var title = "List Dokumen Referensi";
    //                 //     showModalPrice(url,title);
    //                 // });
    //             }
    //         } else {
    //             $('#idcekout').prop('disabled', true);
    //             // $('#bayarpelunasan').prop('disabled', true);
    //         }

    //     });
    //     // End check radio button
    // }


    $("#ttamu-dp").keyup(function(){
        var total = $("#ttamu-totalharga").val();
        var dp = $("#ttamu-dp").val();
        var hasil = total - dp;
        $("#ttamu-sisa").val(hasil);
        $('#ttamu-sisa').number( true );
    });

    function prosesharga(hasil, jmlkamar, idterpilihresult) {
        $.ajax({
            type: "GET",
            // data: {hasil:hasil},
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/hitungharga'])?>?hasil="+hasil+'&jmlkamar='+jmlkamar+'&idterpilihresult='+idterpilihresult,

            success: function(result) {
                $('#ttamu-harga').val(result.sumharga);
                $('#ttamu-harga').number( true );
                $('#ttamu-totalharga').val(result.sumharga);
                $('#ttamu-bayar').val(result.sumharga);
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

    function savecekout(idbiodata) {
        {
            var statuschecked = 0;

            $.each($('.cek_kamar'), function( index, value ) {
               if ($(this).prop('checked')) {
                    statuschecked = statuschecked+1;

                    return false;
                }
            });
            if (statuschecked == 0){

                swal({
                    title: 'Perhatian !',
                    text: 'Kamar Belum Ada Yang Di Ceklis !',
                    icon: "info",
                    dangerMode: true,
                })
             return false;
            }
            swal({
                title: "Konfirmasi",
                text: "Anda yakin akan memproses checkout?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((ya) => {
                if (ya) {
                    var _data = new FormData($("#form-done")[0]);
                    $.ajax({
                        type: "POST",
                        data: _data,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/simpancekout'])?>?idbiodata="+idbiodata,
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
</script>
