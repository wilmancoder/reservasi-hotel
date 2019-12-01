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
                    <?= Html::a('<i class="fa fa-plus"></i> Tambah User', 'javascript:addusersetting(\'insert\')', ['class' => 'btn btn-default pull-right tombol']) ?>
                </div>
                <div class="box-body table-responsive">
                    <table id="tbl_user" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                 <th>Username</th>
                                 <th>Nama Lengkap</th>
                                 <th>Email</th>
                                 <th>Role</th>
                                 <!-- <th>Shift</th> -->
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
             // {"data": "nm_shift"},
             {"data": "updated_at"},
             {
                 "orderable": false,
                 "data": 'fungsi',
                 "defaultContent": ''
             },


         ],
    });
}

function addusersetting(action) {
     var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/usersetting/create']);?>?action="+action;
     var title = "Form Tambah Setting User";
     showModal(url, title);
}

function updateusersetting(id,action) {
     var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/usersetting/update']);?>?id="+id+"&action="+action;
     var title = "Form Update Setting User";
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

function savesetuser(action) {
    {
        if($('#users-nama').val()==''){
            swal({
                title: 'Perhatian !',
                text: 'Nama Wajib Diisi.',
                icon: "info",
                dangerMode: true,
            }).then((ya) => {
                $('#users-nama').focus();
            });
            return false;
        } else if($('#users-id_shift option:selected').val()==''){
            swal({
                title: 'Perhatian !',
                text: 'Shift Wajib Di isi !',
                icon: "info",
                dangerMode: true,
            }).then((ya) => {
                $('#users-id_shift').focus();
            });
            return false;
        } else if($('#users-username').val()==''){
            swal({
                title: 'Perhatian !',
                text: 'Username Wajib Diisi.',
                icon: "info",
                dangerMode: true,
            }).then((ya) => {
                $('#users-username').focus();
            });
            return false;
        } else if($('#users-password').val()==''){
            swal({
                title: 'Perhatian !',
                text: 'Password Wajib Diisi.',
                icon: "info",
                dangerMode: true,
            }).then((ya) => {
                $('#users-password').focus();
            });
            return false;
        } else if($('#users-role option:selected').val()=='empty'){
            swal({
                title: 'Perhatian !',
                text: 'Role Wajib Di isi !',
                icon: "info",
                dangerMode: true,
            }).then((ya) => {
                $('#users-role').focus();
            });
            return false;
        } else {
            // return false;


            swal({
                title: "Konfirmasi",
                text: "Anda yakin akan memproses User ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((ya) => {
                if (ya) {
                    var _data = new FormData($("#form-usersetting")[0]);
                    $.ajax({
                        type: "POST",
                        data: _data,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/usersetting/create'])?>?action="+action,
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
                        success: function (result) {

                            swal(result.header, result.message, result.status);

                            if (result.status == "success") {
                                window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/usersetting/index'])?>";
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

function updatesetuser(id,action) {
     {
         swal({
             title: "Konfirmasi",
             text: "Ubah Setting User ini?",
             icon: "warning",
             buttons: true,
             dangerMode: true,
         }).then((ya) => {
             if (ya) {
                 var _data = new FormData($("#form-usersetting")[0]);
                 $.ajax({
                     type: "POST",
                     data: _data,
                     dataType: "json",
                     contentType: false,
                     processData: false,
                     url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/usersetting/update'])?>?id=" + id + "&action=" + action,
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
                             window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/usersetting/index'])?>";
                         }
                     },
                     error: function (xhr, ajaxOptions, thrownError) {
                         swal("Error!", "Terdapat Kesalahan saat mengubah Setting User!", "error");
                     }
                 });
             } else {
                 // swal("Informasi", "Dokumen Tidak Dihapus", "info");
             }
         });
     }
    }

function deleteusersetting(id) {
 {
     swal({
         title: "Konfirmasi",
         text: "Hapus Setting User ini?",
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
                 url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/usersetting/delete'])?>?id=" + id,
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
                 success: function (result) {

                     swal(result.header, result.message, result.status);

                     if (result.status == "success") {
                         window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/usersetting/index'])?>";
                     }
                 },
                 error: function (xhr, ajaxOptions, thrownError) {
                     swal("Error!", "Terdapat Kesalahan saat menghapus Setting User!", "error");
                 }
             });
         } else {

         }
     });
 }

}


</script>
