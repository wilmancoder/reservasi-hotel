<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Manajemen Kamar';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    #modalHargaId {
        z-index: 1060;
    }
    #modalDetailId{
        overflow-y: hidden;
    }
</style>
<div class="roomsetting-index">
    <h1 class="title"><i class="fa fa-calendar" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h1><br>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <?= Html::a('<i class="fa fa-plus"></i> Tambah Kamar', 'javascript:addkamar()', ['class' => 'btn btn-default pull-right tombol']) ?>
                </div>
                <div class="box-body table-responsive">
                    <table id="tbl_rooms" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                 <th>Nomor Kamar</th>
                                 <th>Type</th>
                                 <th>Kategori Harga</th>
                                 <th>Harga</th>
                                 <th>Tanggal Pembuatan</th>
                                 <th>Pembuat</th>
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

<!-- The Modal -->
<div class="modal fade" id="modalHargaId">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title" id="modalHargaTitle"></h4>
              <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="modalHargaBody">
              Loading ...
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
var t = null;
$(document).ready(function () {

    t = $('#tbl_rooms').DataTable();
    rooms_preview();

});

function rooms_preview()
{
    t.destroy();
    t = $('#tbl_rooms').DataTable({
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
        "ajax": '<?=\Yii::$app->getUrlManager()->createUrl("myadmin/roomsetting/getdataroomsetting");?>',
        "columns": [

             {"data": "nomorkamar"},
             {"data": "type"},
             {"data": "kategoriharga"},
             {"data": "harga"},
             {"data": "created_date"},
             {"data": "created_by"},
             {
                 "orderable": false,
                 "data": 'fungsi',
                 "defaultContent": ''
             },


         ],
    });
}

function addkamar() {
     var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/create']);?>";
     var title = "Form Tambah Kamar";
     showModal(url, title);
}

function updateroomsetting(id) {
     var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/update']);?>?id="+id;
     var title = "Form Update Kamar";
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

function showModalharga(url, title) {
     $("#modalHargaTitle").empty();
     $("#modalHargaTitle").html(title);

     $("#modalHargaBody").empty();
     $("#modalHargaBody").html("Loading ...");
     $("#modalHargaBody").load(url);

     $('#modalHargaId').modal({backdrop: 'static', keyboard: false});
     $("#modalHargaId").modal("show");
     return false;
}

function savesetroom() {
    {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin akan menambahkan Setting Kamar?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((ya) => {
            if (ya) {
                var _data = new FormData($("#form-roomsetting")[0]);
                $.ajax({
                    type: "POST",
                    data: _data,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/create'])?>",
                    beforeSend: function () {
                        swal({
                            title: 'Harap Tunggu',
                            text: "Sedang proses ...",
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
                            window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/index'])?>";
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal("Error!", "Terdapat Kesalahan saat menambahkan Setting Kamar!", "error");
                    }
                });
            } else {
                return false;
            }
        });
    }
}

function updatesetharga(id) {
     {
         swal({
             title: "Konfirmasi",
             text: "Anda yakin akan mengubah Setting Kamar?",
             icon: "warning",
             buttons: true,
             dangerMode: true,
         }).then((ya) => {
             if (ya) {
                 var _data = new FormData($("#form-roomsetting")[0]);
                 $.ajax({
                     type: "POST",
                     data: _data,
                     dataType: "json",
                     contentType: false,
                     processData: false,
                     url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/update'])?>?id=" + id,
                     beforeSend: function () {
                         swal({
                             title: 'Harap Tunggu',
                             text: "Sedang proses ...",
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
                             window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/index'])?>";
                         }
                     },
                     error: function (xhr, ajaxOptions, thrownError) {
                         swal("Error!", "Terdapat Kesalahan saat mengubah Setting Harga!", "error");
                     }
                 });
             } else {
                 // swal("Informasi", "Dokumen Tidak Dihapus", "info");
             }
         });
     }
    }

function deleteroomsetting(id) {
 {
     swal({
         title: "Konfirmasi",
         text: "Hapus Setting Kamar ini?",
         icon: "warning",
         buttons: true,
         dangerMode: true,
     }).then((ya) => {
         if (ya) {
             $.ajax({
                 type: "GET",
                 // data: {id:id},
                 dataType: "json",
                 contentType: false,
                 processData: false,
                 url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/delete'])?>?id=" + id,
                 beforeSend: function () {
                     swal({
                         title: 'Harap Tunggu',
                         text: "Sedang Menghapus Setting Kamar",
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
                         window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/roomsetting/index'])?>";
                     }
                 },
                 error: function (xhr, ajaxOptions, thrownError) {
                     swal("Error!", "Terdapat Kesalahan saat menghapus Kategori Harga!", "error");
                 }
             });
         } else {

         }
     });
 }

}


</script>
