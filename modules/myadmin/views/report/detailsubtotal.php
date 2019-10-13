<?php
use yii\helpers\Html;
use yii\helpers\Url;
// use yii\grid\GridView;
use app\models\TPetugas;
use yii\bootstrap\ActiveForm;

$this->title = 'Detail Subtotal';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">

</style>
<div class="report-index">
    <!-- <h1 class="title"><i class="fa fa-list" aria-hidden="true"></i> <?//= Html::encode($this->title) ?></h1><br> -->
    <!-- <li><label class="control-label" style="font-size:18px;">Laporan Pendapatan</label></li> -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <!-- <div class="box-header with-border">
                    <h3 class="box-title">Detail SubTotal</h3>
                </div> -->
                <div class="box-body">
                    <table id="tbl_detail_subtotal" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                     <tr>
                         <th>Checkin</th>
                         <th>Checkout</th>
                         <th>Durasi</th>
                         <th>Type</th>
                         <th>Harga Kamar</th>
                         <th>Total Sewa PerKamar</th>
                     </tr>
                     </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    $(document).ready(function () {

        t = $('#tbl_detail_subtotal').DataTable();
         items_preview();


    });

    function items_preview()
    {
        t.destroy();
        var idtranstamu = <?= $idtranstamu?>;
        // table.destroy();
        t = $('#tbl_detail_subtotal').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "paging": false,
            "info": false,
            "searching": false,
            "ajax": '<?=\Yii::$app->getUrlManager()->createUrl("myadmin/report/generatedetailsubtotal");?>?idtranstamu='+idtranstamu,
            "columns": [

                 {"data": "checkin"},
                 {"data": "checkout"},
                 {"data": "durasi"},
                 {"data": "type"},
                 {"data": "harga_kamar"},
                 {"data": "biaya_sewa_perkamar"}

             ],
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

    function detail(idtranstamu) {
         var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/report/detsubtotal']);?>?idtranstamu=" + idtranstamu;
         var title = "Detail Subtotal";
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


</script>
