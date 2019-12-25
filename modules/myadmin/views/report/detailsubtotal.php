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
#titlebed {
    color: white;
    padding-bottom: 8px;
}
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
                         <th>Nomor Kamar</th>
                         <th>Type Kamar</th>
                         <th>Harga Kamar</th>
                         <th>Subtotal PerKamar</th>
                     </tr>
                     </thead>
                     <tbody>

                     </tbody>
                     <tfoot>
                         <tr>
                             <th colspan="6" style="text-align:right">Total :</th>
                             <th style="text-align:right" id="grandtotal"></th>
                         </tr>
                     </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <h5 class="title">Extra Bed</h5>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Harga per Kasur :</label>
                <input type="text" name="nmhrgbed" class="form-control" value="<?= "Rp. " . \app\components\Logic::formatNumber($resultbed, 0)?>" disabled="true">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Jumlah Kasur :</label>
                <input type="text" name="nmjmlbed" class="form-control" value="<?= $cektbed['qty_bed']?>" disabled="true">
            </div>
        </div>
        <div class="col-md-4" style="text-align:right;">
            <div class="form-group">
                <label class="control-label" id="titlebed">Total</label>
                <p id="totalbed" style="padding-right: 28px;"><?= !empty($cektbed) ? "Rp. " . \app\components\Logic::formatNumber($cektbed['harga_bed'], 0) :  "Rp. " . \app\components\Logic::formatNumber($resultbed, 0) ?></p>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6">
                    Grand Total :
                </div>
                <div class="col-md-6" style="text-align: right; padding-right:42px;">
                    <span id="grtot">Rp. 10.000.000</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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
                {
                    width: '20%', targets: 6,
                    targets: 6,
                    className: 'dt-body-right'
                },
            ],
            "ajax": '<?=\Yii::$app->getUrlManager()->createUrl("myadmin/report/generatedetailsubtotal");?>?idtranstamu='+idtranstamu,
            "columns": [

                 {"data": "checkin"},
                 {"data": "checkout"},
                 {"data": "durasi"},
                 {"data": "nomor_kamar"},
                 {"data": "type"},
                 {"data": "harga_kamar"},
                 {"data": "biaya_sewa_perkamar"}

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
                 $('th#grandtotal').text('  Rp. '+ convert +'');

                 var totbed = $('#totalbed').text();
                 var subs = totbed.substring(4);
                 restotbed = subs.split('.').join("");
                 var grandtot = parseInt(total) + parseInt(restotbed);
                 console.log(grandtot);
                 $('span#grtot').text('  Rp. '+ grandtot +'');
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

    // function detail(idtranstamu) {
    //      var url = "<?php //echo \Yii::$app->getUrlManager()->createUrl(['myadmin/report/detsubtotal']);?>?idtranstamu=" + idtranstamu;
    //      var title = "Detail Data Tamu";
    //      showModal(url, title);
    //  }

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
