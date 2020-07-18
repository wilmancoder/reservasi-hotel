<?php
use yii\helpers\Html;
?>
<div class="ceksettingharga-index">
    <div class="box box-warning">
        <div class="box-body">
            <div class="rooms-form">
                <div class="box-body table-responsive">
                    <table id="tbl_settingharga" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                 <th>Kategori Harga</th>
                                 <th>Type</th>
                                 <th>Harga</th>
                                 <th>#</th>
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


<script type="text/javascript">
var t = null;
var mode = '<?= $mode?>';
$(document).ready(function () {

    t = $('#tbl_settingharga').DataTable();
    settingharga_preview();

});

function settingharga_preview()
{
    t.destroy();
    t = $('#tbl_settingharga').DataTable({
        "processing": true,
        // "serverSide": true,
        "ordering": true,
        // "paging": true,
        // "info": false,
        "searching": true,
        // columnDefs: [
        //     { width: '5%', targets: 0 },
        //     { width: '5%', targets: 1 },
        //     { width: '20%', targets: 2 },
        //     { width: '20%', targets: 3 },
        //     { width: '15%', targets: 4 },
        //     { width: '10%', targets: 5 },
        //     { width: '10%', targets: 6 },
        //     {
        //         width: '15%', targets: 7,
        //         targets: 7,
        //         className: 'dt-body-right'
        //     },
        // ],
        "ajax": '<?=\Yii::$app->getUrlManager()->createUrl("myadmin/roomsetting/getceksettingharga");?>',
        "columns": [

             {"data": "type"},
             {"data": "kategoriharga"},
             {"data": "harga"},
             {
                 "orderable": false,
                 "data": 'fungsi',
                 "defaultContent": ''
             },


         ],
    });
}
function terpilih(id){
    $.ajax({
             type: "GET",
             url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/getpropsettingharga'])?>?id="+id+"&mode="+mode,
             //contentType: "application/json",
             dataType: "json",
             //async: false,
             success: function(response) {
                  console.log(response);
                  var id  = response.id;
                  var kategoriharga  = response.kategoriharga;
                  var type  = response.type;
                  var harga = response.harga;
                  var modz = response.mode;
                  swal({
                     title: "Konfirmasi",
                     text: "Anda memilih Kategori Harga "+kategoriharga+", Type Kamar "+type+", dan Harga "+harga+" ?",
                     icon: "warning",
                     buttons: true,
                     dangerMode: true,
                   }).then((konfirm) => {
                        if (konfirm) {
                            if(modz == 'create') {
                                // alert("masuk1"); return false;
                                $('#mmappingkamar-id_mapping_harga').val(id);
                                $('#mmappingkamar-type').val(type);
                                $('#mmappingkamar-kategori_harga').val(kategoriharga);
                                $('#mmappingkamar-harga').val(harga);
                                $('#modalHargaId').modal('hide');
                            } else if(modz == 'update'){
                                // alert("masuk2"); return false;
                                $('#mmappingkamar-id_mapping_harga').val(id);
                                $('#mtype-type').val(type);
                                $('#mkategoriharga-kategori_harga').val(kategoriharga);
                                $('#mmappingharga-harga').val(harga);
                                $('#modalHargaId').modal('hide');
                            }
                        }
                   });

             },
             error: function(response) {
                 //console.log(response);
             }
     });

}
</script>
