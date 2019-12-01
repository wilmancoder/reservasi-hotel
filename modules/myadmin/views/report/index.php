<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
/* td.details-control {
background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
cursor: pointer;
}
tr.shown td.details-control {
background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
} */
.tombol{
    margin-bottom: 5px;
}
.labelshift {
    font-size: 18px !important;
}
.labelcari {
    color: white;
}
.labeldownload {
    color: white;
}
</style>
<div class="report-index">
    <h1 class="title"><i class="fa fa-list" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h1><br>
    <div align="center">
        <?php
            $timestart = $modelShift['start_date'];
            $timeend   = $modelShift['end_date'];
            $formattimestart = date('H:i', strtotime($timestart));
            $formattimeend = date('H:i', strtotime($timeend));
        ?>
        <label class="control-label"><h3 class="title">Laporan Pendapatan dan Pengeluaran Tanggal <u><?= date('d-m-Y')?></u></h3></label>
        <p><label class="control-label labelshift"><?= $modelShift['nm_shift']?> : &nbsp;&nbsp;&nbsp;<?= $formattimestart?> - <?= $formattimeend?></label></p>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body">
                    <div class="row">
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
                                "id" => "form-filterreport",
                                "class" => "",
                                'onsubmit'=>'return false;',
                                // "data-parsley-validate" => "",
                                // 'enctype'=>'multipart/form-data',
                                // 'novalidate' => 'novalidate'
                            ]
                        ]); ?>
                        <div class="col-md-4">
                            <div class="form-group required">
                                <?= $form->field($model, 'startdate')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal','placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group required">
                                <?= $form->field($model, 'enddate')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal','placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label labelcari">Cari</label>
                            <div class="form-group">
                                <?= Html::button('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-success btn-block', 'onclick' => 'reportpreview()']) ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label labeldownload">Download</label>
                            <div class="form-group">
                                <?= Html::button('<i class="fa fa-download" aria-hidden="true"></i> Download', ['class' => 'btn btn-primary btn-block', 'onclick' => 'reportdownload()']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="box-header with-border">
                        <label class="control-label labelshift">Laporan Pendapatan</label>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="tbl_laporan_pendapatan" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                     <th>No.</th>
                                     <th>Nama Tamu</th>
                                     <th>Jenis Pembayaran</th>
                                     <th>Metode Pembayaran</th>
                                     <th>Tgl. Uang Masuk</th>
                                     <th>Jumlah Uang Masuk</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6" style="text-align:right">Jumlah Total Pendapatan:</th>
                                    <th style="text-align:right" id="ttl_pendapatan"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr><br>

                    <div class="box-header with-border">
                        <label class="control-label labelshift">Laporan Pengeluaran</label>
                        <?= Html::a('<i class="fa fa-plus"></i> Tambah Pengeluaran', 'javascript:addpengeluaran("'.$idpetugas.'")', ['class' => 'btn btn-default pull-right tombol']) ?>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="tbl_laporan_pengeluaran" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                     <th>No.</th>
                                     <th>Nama Item</th>
                                     <th>Tgl. Uang Keluar</th>
                                     <th>Quantity</th>
                                     <th>Harga Per Item</th>
                                     <th>Total Harga Item</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align:right">Jumlah Total Pengeluaran:</th>
                                    <th style="text-align:right" id="ttl_pengeluaran"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Jumlah Total Pendapatan</label>
                                    <!-- <input type="text" id="tmppendapatan" value="<?//= $Summarytamupendapatan?>" class="form-control"> -->
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Jumlah Total Pengeluaran</label>
                                    <!-- <input type="text" id="tmppengeluaran" value="<?//= $Summarytamupengeluaran?>" class="form-control"> -->
                                </div>
                                <div class="form-group">
                                    <label class="control-label title"><strong> Jumlah Disetor</strong</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label" id="tot_pendapatan">Rp. &nbsp;<?= \app\components\Logic::formatNumber(!empty($Summarytamupendapatan) ? $Summarytamupendapatan : 0)?></label>
                                    <!-- <label class="control-label" id="tot_pendapatan"></label> -->
                                    <!-- <input type="text" id="kolom-pendapatan" class="form-control" value=""> -->
                                </div>
                                <div class="form-group">
                                    <label class="control-label" id="tot_pengeluaran">Rp. &nbsp;<?= \app\components\Logic::formatNumber(!empty($Summarytamupengeluaran) ? $Summarytamupengeluaran : 0)?></label>
                                    <!-- <label class="control-label" id="tot_pengeluaran"></label> -->
                                    <!-- <input type="text" id="kolom-pengeluaran" class="form-control" value=""> -->
                                </div>
                                <div class="form-group">
                                    <!-- <input type="text" value="<?//= !empty($resultGrandtotal) ? $resultGrandtotal : 0;?>" class="form-control"> -->
                                    <label class="control-label title" id="jmlsetor"><strong>Rp. &nbsp;<?= \app\components\Logic::formatNumber(!empty($resultGrandtotal) ? $resultGrandtotal : 0)?></strong></label>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-2 pull-right">
                                <div class="form-group">
                                    <label class="control-label"> <?= $user['nama']?></label>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> Petugas FO</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- The Modal -->
<div class="modal fade" id="modalDetailId">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title" id="modalDetailTitle"></h4>
              <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="modalDetailBody">
              Loading ...
            </div>

            <!-- Modal footer -->
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div> -->

        </div>
    </div>
</div>
<script type="text/javascript">

// function format ( d ) {
// // `d` is the original data object for the row
// return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
//     '<tr>'+
//         '<td>Checkin:</td>'+
//         '<td>'+d.checkin+'</td>'+
//     '</tr>'+
//     '<tr>'+
//         '<td>Checkout:</td>'+
//         '<td>'+d.checkout+'</td>'+
//     '</tr>'+
//     '<tr>'+
//         '<td>Lama Menginap:</td>'+
//         '<td>'+d.durasi+'</td>'+
//     '</tr>'+
// '</table>';
// }

    var t = null;
    var tt = null;
    var restemp = 0;
    $(document).ready(function () {

        // var ttlstr = grandtotalsetor(pendapatantemp,pengeluarantemp);
        // $('label#jmlsetor').text(ttlstr);
        $('.form-tanggal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        // alert(pendapatan); return false;
        t = $('#tbl_laporan_pendapatan').DataTable();
        pendapatan_preview();

        tt = $('#tbl_laporan_pengeluaran').DataTable();
        pengeluaran_preview();


    });

    function pendapatan_preview()
    {
        t.destroy();
        var idpetugas = <?= $idpetugas?>;
        // table.destroy();
        t = $('#tbl_laporan_pendapatan').DataTable({
            "processing": true,
            // "serverSide": true,
            // "ordering": false,
            // "paging": false,
            // "info": false,
            // "searching": false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '5%', targets: 1 },
                { width: '25%', targets: 2 },
                { width: '15%', targets: 3 },
                { width: '20%', targets: 4 },
                { width: '15%', targets: 5 },
                {
                    width: '15%', targets: 6,
                    targets: 6,
                    className: 'dt-body-right'
                },
            ],
            "ajax": '<?=\Yii::$app->getUrlManager()->createUrl("myadmin/report/getdatapendapatan");?>?idpetugas='+idpetugas,
            "columns": [
                // {
                //     "className": 'details-control',
                //     "orderable": false,
                //     "data": null,
                //     "defaultContent": ''
                // },
                {
                    "orderable": false,
                    "data": 'fungsi',
                    "defaultContent": ''
                },
                 {"data": "no"},
                 {"data": "nama_tamu"},
                 {"data": "jenis_pembayaran"},
                 {"data": "metode_pembayaran"},
                 {"data": "tgl_uangmasuk"},
                 {"data": "jml_uangmasuk"}
             ],
             "footerCallback": function ( row, data, start, end, display ) {
             var api = this.api(), data;

             // Remove the formatting to get integer data for summation
             var intVal = function ( i ) {
                 return typeof i === 'string' ?
                     i.replace(/[\$.]/g, '')*1 :
                     typeof i === 'number' ?
                         i : 0;
             };

             // Total over all pages
             total = api
                 .column( 6 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

             // Total over this page
             pageTotal = api
                 .column( 6, { page: 'current'} )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

             // Update footer
             $( api.column( 6 ).footer() ).html(
                 '  Rp.'+ total +''
             );
             var convert = toRupiah(total);

             $('th#ttl_pendapatan').text('  Rp. '+ convert +'');

         }
        });
    }

    function pengeluaran_preview()
    {
        tt.destroy();
        var idpetugas = <?= $idpetugas?>;
        // table.destroy();
        tt = $('#tbl_laporan_pengeluaran').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "paging": false,
            "info": false,
            "searching": false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '30%', targets: 1 },
                { width: '15%', targets: 2 },
                { width: '15%', targets: 3 },
                {
                    width: '15%', targets: 4,
                    targets: 4,
                    className: 'dt-body-right'
                },
                {
                    width: '20%', targets: 5,
                    targets: 5,
                    className: 'dt-body-right'
                },
            ],
            "ajax": '<?=\Yii::$app->getUrlManager()->createUrl("myadmin/report/getdatapengeluaran");?>?idpetugas='+idpetugas,
            "columns": [
                 {"data": "no"},
                 {"data": "item"},
                 {"data": "tgl_uangkeluar"},
                 {"data": "qty"},
                 {"data": "harga_per_item"},
                 {"data": "total_harga_item"}
            ],
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$.]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
                '  Rp.'+ total +''
            );

            var convert = toRupiah(total);

            $('th#ttl_pengeluaran').text('  Rp. '+ convert +'');
        }
        });
    }
    function detail(idtranstamu) {
         var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/report/detsubtotal']);?>?idtranstamu=" + idtranstamu;
         var title = "<h5 class='title'>Detail Data Tamu</h5>";
         showModal(url, title);
    }

    function addpengeluaran(idpetugas) {
         var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/report/createpengeluaran']);?>?idpetugas=" + idpetugas;
         var title = "<h5 class='title'>Form Tambah Pengeluaran</h5>";
         showModal(url, title);
    }

    function showModal(url, title) {
         $("#modalDetailTitle").empty();
         $("#modalDetailTitle").html(title);

         $("#modalDetailBody").empty();
         $("#modalDetailBody").html("Loading ...");
         $("#modalDetailBody").load(url);

         $('#modalDetailId').modal({backdrop: 'static', keyboard: false});
         $("#modalDetailId").modal("show");
         return false;
    }

    function savepengeluaran(idpetugas) {
        {
            swal({
                title: "Konfirmasi",
                text: "Anda yakin akan memproses jenis item ini sebagai pengeluaran?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((ya) => {
                if (ya) {
                    var _data = new FormData($("#form-createpengeluaran")[0]);
                    $.ajax({
                        type: "POST",
                        data: _data,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/report/createpengeluaran'])?>?idpetugas="+idpetugas,
                        beforeSend: function () {
                            swal({
                                title: 'Harap Tunggu',
                                text: "Sedang memproses",
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
                                window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/report/index'])?>";
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Error!", "Terdapat Kesalahan saat memproses jenis item pengeluaran!", "error");
                        }
                    });
                } else {
                    return false;
                }
            });
        }
    }

    function reportpreview() {
        var _data = new FormData($("#form-filterreport")[0]);
        $.ajax({
            type: "POST",
            data: _data,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/report/listreportfo'])?>",

            success: function (result) {
                if(result.status == 'success'){
                    var posting = result.joinposting;
                    // alert(posting); return false;
                    reportFo(posting);
                    // reportFoPengeluaran(posting);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error!", "Terdapat Kesalahan saat memproses semua data laporan!", "error");
            }
        });
    }

    function reportFo(posting)
    {
        t.destroy();

        t = $('#tbl_laporan_pendapatan').DataTable({
            "processing": true,
            // "serverSide": true,
            "ordering": true,
            // "paging": true,
            // "info": false,
            "searching": true,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '5%', targets: 1 },
                { width: '25%', targets: 2 },
                { width: '15%', targets: 3 },
                { width: '20%', targets: 4 },
                { width: '15%', targets: 5 },
                {
                    width: '15%', targets: 6,
                    targets: 6,
                    className: 'dt-body-right'
                },
            ],
            "ajax": {
                "type": 'GET',
                "dataType": "JSON",
                "url": "<?=\Yii::$app->getUrlManager()->createUrl("myadmin/report/getdatareportfo");?>?posting="+posting,
            },
            "columns": [
                {
                    "orderable": false,
                    "data": 'fungsi',
                    "defaultContent": ''
                },
                {"data": "no"},
                {"data": "nama_tamu"},
                {"data": "jenis_pembayaran"},
                {"data": "metode_pembayaran"},
                {"data": "tgl_uangmasuk"},
                {"data": "jml_uangmasuk"}
             ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                 return typeof i === 'string' ?
                     i.replace(/[\$.]/g, '')*1 :
                     typeof i === 'number' ?
                         i : 0;
                };

                // Total over all pages
                totalx = api
                 .column( 6 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                // Total over this page
                pageTotal = api
                 .column( 6, { page: 'current'} )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

                // Update footer
                $( api.column( 6 ).footer() ).html(
                 '  Rp.'+ totalx +''
                );

                var convert = toRupiah(totalx);

                $('label#tot_pendapatan').text('  Rp. '+ convert +'');
                $('th#ttl_pendapatan').text('  Rp. '+ convert +'');

                $('#tmppendapatan').val(totalx);

            }
        });


        tt.destroy();

        tt = $('#tbl_laporan_pengeluaran').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "paging": false,
            "info": false,
            "searching": false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '30%', targets: 1 },
                { width: '15%', targets: 2 },
                { width: '15%', targets: 3 },
                {
                    width: '15%', targets: 4,
                    targets: 4,
                    className: 'dt-body-right'
                },
                {
                    width: '20%', targets: 5,
                    targets: 5,
                    className: 'dt-body-right'
                },
            ],
            "ajax": {
                "type": 'GET',
                "dataType": "JSON",
                "url": "<?=\Yii::$app->getUrlManager()->createUrl("myadmin/report/getdatareportfopengeluaran");?>?posting="+posting,
            },
            "columns": [
                 {"data": "no"},
                 {"data": "item"},
                 {"data": "tgl_uangkeluar"},
                 {"data": "qty"},
                 {"data": "harga_per_item"},
                 {"data": "total_harga_item"}
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$.]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                totaly = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Total over this page
                pageTotal = api
                    .column( 5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api.column( 5 ).footer() ).html(
                    '  Rp.'+ totaly +''
                );

                var convert = toRupiah(totaly);

                $('label#tot_pengeluaran').text('  Rp. '+ convert +'');
                $('th#ttl_pengeluaran').text('  Rp. '+ convert +'');

                $('#tmppengeluaran').val(totaly);
                var resFinal = totalx-totaly;
                var convertresFinal = toRupiah(resFinal);
                $('label#jmlsetor').text('  Rp. '+ convertresFinal +'')
            }
        });
    }

    // function reportFoPengeluaran(posting)
    // {
    //     tt.destroy();
    //
    //     tt = $('#tbl_laporan_pengeluaran').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "ordering": false,
    //         "paging": false,
    //         "info": false,
    //         "searching": false,
    //         columnDefs: [
    //             { width: '5%', targets: 0 },
    //             { width: '40%', targets: 1 },
    //             { width: '15%', targets: 2 },
    //             {
    //                 width: '20%', targets: 3,
    //                 targets: 3,
    //                 className: 'dt-body-right'
    //             },
    //             {
    //                 width: '20%', targets: 4,
    //                 targets: 4,
    //                 className: 'dt-body-right'
    //             },
    //         ],
    //         "ajax": {
    //             "type": 'GET',
    //             "dataType": "JSON",
    //             "url": "<?//=\Yii::$app->getUrlManager()->createUrl("myadmin/report/getdatareportfopengeluaran");?>?posting="+posting,
    //         },
    //         "columns": [
    //              {"data": "no"},
    //              {"data": "item"},
    //              {"data": "qty"},
    //              {"data": "harga_per_item"},
    //              {"data": "total_harga_item"}
    //         ],
    //         "footerCallback": function ( row, data, start, end, display ) {
    //             var api = this.api(), data;
    //
    //             // Remove the formatting to get integer data for summation
    //             var intVal = function ( i ) {
    //                 return typeof i === 'string' ?
    //                     i.replace(/[\$.]/g, '')*1 :
    //                     typeof i === 'number' ?
    //                         i : 0;
    //             };
    //
    //             // Total over all pages
    //             total = api
    //                 .column( 4 )
    //                 .data()
    //                 .reduce( function (a, b) {
    //                     return intVal(a) + intVal(b);
    //                 }, 0 );
    //
    //             // Total over this page
    //             pageTotal = api
    //                 .column( 4, { page: 'current'} )
    //                 .data()
    //                 .reduce( function (a, b) {
    //                     return intVal(a) + intVal(b);
    //                 }, 0 );
    //
    //             // Update footer
    //             $( api.column( 4 ).footer() ).html(
    //                 '  Rp.'+ total +''
    //             );
    //
    //             var convert = toRupiah(total);
    //
    //             $('label#tot_pengeluaran').text('  Rp. '+ convert +'');
    //             $('th#ttl_pengeluaran').text('  Rp. '+ convert +'');
    //
    //             $('#tmppengeluaran').val(total);
    //         }
    //     });
    //
    // }
</script>
