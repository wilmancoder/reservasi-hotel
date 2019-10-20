<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Booking';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">

</style>
<div class="report-index">
    <h1 class="title"><i class="fa fa-calendar" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h1><br>
    <div align="center">
        <label class="control-label"><h3 class="title">Daftar Booking Tamu</u></h3></label>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <?= Html::a('<i class="fa fa-plus"></i> Tambah Booking', 'javascript:addbooking("'.$idharga.'")', ['class' => 'btn btn-default pull-right tombol']) ?>
                </div>
                <div class="box-body table-responsive">
                    <table id="tbl_booking" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                 <th>No.</th>
                                 <th>Nama Tamu</th>
                                 <th>Nomor Identitas</th>
                                 <th>Nomor Handphone</th>
                                 <th>Booking Pada Tanggal</th>
                                 <th>Petugas</th>
                                 <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
var t = null;
$(document).ready(function () {

    t = $('#tbl_booking').DataTable();
    booking_preview();

});

function booking_preview()
{
    t.destroy();
    var idpetugas = <?= $idpetugas?>;
    // table.destroy();
    t = $('#tbl_booking').DataTable({
        "processing": true,
        // "serverSide": true,
        "ordering": true,
        // "paging": true,
        // "info": false,
        "searching": true,
        columnDefs: [
            { width: '5%', targets: 0 },
            { width: '5%', targets: 1 },
            { width: '20%', targets: 2 },
            { width: '20%', targets: 3 },
            { width: '15%', targets: 4 },
            { width: '10%', targets: 5 },
            { width: '10%', targets: 6 },
            {
                width: '15%', targets: 7,
                targets: 7,
                className: 'dt-body-right'
            },
        ],
        "ajax": '<?=\Yii::$app->getUrlManager()->createUrl("myadmin/booking/getdatabooking");?>?idpetugas='+idpetugas,
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
             {"data": "namatamu"},
             {"data": "identitas"},
             {"data": "nomor_kontak"},
             {"data": "created_date"},
             {"data": "created_by"},
             {"data": "subtotal"},


         ],
    });
}

function addbooking(idharga) {
     var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/booking/create']);?>?idharga="+idharga;
     var title = "Form Tambah Booking";
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

function detailBooking(idtranstamu) {
     var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/booking/detbooking']);?>?idtranstamu=" + idtranstamu;
     var title = "Detail Booking";
     showModal(url, title);
}
</script>
