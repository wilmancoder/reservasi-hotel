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
            <div class="box">
                <div class="box-header with-border">
                    <label class="control-label labelshift">Laporan Pendapatan</label>
                </div>
                <div class="box-body table-responsive">
                    <table id="tbl_laporan_pendapatan" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                 <th>No.</th>
                                 <th>Type Kamar</th>
                                 <th>Jenis Pembayaran</th>
                                 <th>Metode Pembayaran</th>
                                 <th>Jumlah Uang Masuk</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align:right">Jumlah Total Pendapatan:</th>
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
                                 <th>Quantity</th>
                                 <th>Harga Per Item</th>
                                 <th>Total Harga Item</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:right">Jumlah Total Pengeluaran:</th>
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
                            </div>
                            <div class="form-group">
                                <label class="control-label">Jumlah Total Pengeluaran</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label title"><strong> Jumlah Disetor</strong</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label" id="tot_pendapatan">Rp. &nbsp;<?= \app\components\Logic::formatNumber(!empty($Summarytamupendapatan) ? $Summarytamupendapatan : 0)?></label>
                            </div>
                            <div class="form-group">
                                <label class="control-label" id="tot_pengeluaran">Rp. &nbsp;<?= \app\components\Logic::formatNumber(!empty($Summarytamupengeluaran) ? $Summarytamupengeluaran : 0)?></label>
                            </div>
                            <div class="form-group">
                                <label class="control-label title"><strong>Rp. &nbsp;<?= \app\components\Logic::formatNumber(!empty($resultGrandtotal) ? $resultGrandtotal : 0)?></strong></label>
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
    var pendapatan = $('#ttl_pendapatan').val();
    var pengeluaran = $('#ttl_pengeluaran').val();
    $(document).ready(function () {

        t = $('#tbl_laporan_pendapatan').DataTable();
        pendapatan_preview(pendapatan);

        tt = $('#tbl_laporan_pengeluaran').DataTable();
        pengeluaran_preview(pengeluaran);


    });

    function pendapatan_preview(pendapatan)
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
                { width: '20%', targets: 2 },
                { width: '15%', targets: 3 },
                { width: '20%', targets: 4 },
                {
                    width: '20%', targets: 5,
                    targets: 5,
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
                 {"data": "type"},
                 {"data": "jenis_pembayaran"},
                 {"data": "metode_pembayaran"},
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
             // $('#tot_pendapatan').val(pendapatan);

         }
        });

        // $('#tbl_laporan_pendapatan tbody').on('click', 'td.details-control', function () {
        //     var tr = $(this).closest('tr');
        //     var row = t.row( tr );
        //
        //     if ( row.child.isShown() ) {
        //         // This row is already open - close it
        //         row.child.hide();
        //         tr.removeClass('shown');
        //     }
        //     else {
        //         // Open this row
        //         row.child( format(row.data()) ).show();
        //         tr.addClass('shown');
        //     }
        // } );
    }

    function pengeluaran_preview(pengeluaran)
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
                { width: '40%', targets: 1 },
                { width: '15%', targets: 2 },
                {
                    width: '20%', targets: 3,
                    targets: 3,
                    className: 'dt-body-right'
                },
                {
                    width: '20%', targets: 4,
                    targets: 4,
                    className: 'dt-body-right'
                },
            ],
            "ajax": '<?=\Yii::$app->getUrlManager()->createUrl("myadmin/report/getdatapengeluaran");?>?idpetugas='+idpetugas,
            "columns": [
                 {"data": "no"},
                 {"data": "item"},
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
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 4 ).footer() ).html(
                '  Rp.'+ total +''
            );
            // $('#tot_pengeluaran').val(pengeluaran);
        }
        });
    }
    function detail(idtranstamu) {
         var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/report/detsubtotal']);?>?idtranstamu=" + idtranstamu;
         var title = "Detail Subtotal";
         showModal(url, title);
    }

    function addpengeluaran(idpetugas) {
         var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/report/createpengeluaran']);?>?idpetugas=" + idpetugas;
         var title = "Form Tambah Pengeluaran";
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


</script>
