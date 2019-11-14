<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Manajemen User';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">

</style>
<div class="pricesetting-index">
    <h1 class="title"><i class="fa fa-calendar" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h1><br>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <?= Html::a('<i class="fa fa-plus"></i> Tambah User', 'javascript:addusersetting()', ['class' => 'btn btn-default pull-right tombol']) ?>
                </div>
                <div class="box-body table-responsive">
                    <table id="tbl_user" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                 <th>Username</th>
                                 <th>Nama Lengkap</th>
                                 <th>Email</th>
                                 <th>Role</th>
                                 <th>Shift</th>
                                 <th>Tgl Update User</th>
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
<script type="text/javascript">
var t = null;
$(document).ready(function () {

    t = $('#tbl_user').DataTable();
    user_preview();

});

function user_preview()
{
    t.destroy();
    t = $('#tbl_user').DataTable({
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
        "ajax": '<?=\Yii::$app->getUrlManager()->createUrl("myadmin/usersetting/getdatausersetting");?>',
        "columns": [

            {"data": "username"},
             {"data": "nama"},
             {"data": "email"},
             {"data": "role"},
             {"data": "nm_shift"},
             {"data": "updated_at"},
             {
                 "orderable": false,
                 "data": 'fungsi',
                 "defaultContent": ''
             },


         ],
    });
}

function addpricesetting() {
     var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/pricesetting/create']);?>";
     var title = "Form Tambah Setting Harga";
     showModal(url, title);
}

function updatepricesetting(id) {
     var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/pricesetting/update']);?>?id="+id;
     var title = "Form Update Setting Harga";
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

function savesetharga() {
    {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin akan menambahkan Setting Harga?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((ya) => {
            if (ya) {
                var _data = new FormData($("#form-pricesetting")[0]);
                $.ajax({
                    type: "POST",
                    data: _data,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/pricesetting/create'])?>",
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
                            window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/pricesetting/index'])?>";
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal("Error!", "Terdapat Kesalahan saat menambahkan Setting Harga!", "error");
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
             text: "Ubah Setting Harga ini?",
             icon: "warning",
             buttons: true,
             dangerMode: true,
         }).then((ya) => {
             if (ya) {
                 var _data = new FormData($("#form-pricesetting")[0]);
                 $.ajax({
                     type: "POST",
                     data: _data,
                     dataType: "json",
                     contentType: false,
                     processData: false,
                     url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/pricesetting/update'])?>?id=" + id,
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
                             window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/pricesetting/index'])?>";
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

function deletepricesetting(id) {
 {
     swal({
         title: "Konfirmasi",
         text: "Hapus Kategori Harga ini?",
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
                 url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/pricesetting/delete'])?>?id=" + id,
                 beforeSend: function () {
                     swal({
                         title: 'Harap Tunggu',
                         text: "Sedang Menghapus Kategori Harga",
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
                         window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/pricesetting/index'])?>";
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
