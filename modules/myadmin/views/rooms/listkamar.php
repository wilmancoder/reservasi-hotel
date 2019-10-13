<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<style type="text/css">
.geserkanan{
    margin-right: 5px;
}

</style>

<div class="listkamar-index">
    <?php
     $form = ActiveForm::begin([
         "options" => [
             "class" => "",
             // "id"    => "form-filter-juskeb",
             // 'onsubmit'=>'return true;',
         ]
     ]);
     ?>
    <div class="card">
       <!-- /.card-header -->
       <div class="card-body">
         <table id="tbl_listkamar" class="table table-bordered table-striped">
                 <thead>
                 <tr>
                     <th>ID</th>
                     <th>No.</th>
                     <th>Nomor Kamar</th>
                     <th>Type</th>
                     <th>Harga</th>
                     <th><input name="checkall" type="checkbox" id="checkall" onclick="checkAll()"></th>
                 </tr>
                 </thead>
             </table>

         </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= Html::button('<i class="fa fa-save" aria-hidden="true"></i> Pilih', ['onclick' => 'savekamar("'.$id.'")', 'id' => 'btn_preview', 'class' => 'btn btn-success pull-right']) ?>
            <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Tutup', ['class' => 'btn btn-danger pull-right geserkanan', 'onclick'=>'tutup()']) ?>
            <?php /*
            <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i> Reset Semua Ceklist', 'javascript:resetChecked()', ['class'=>'btn btn-default','style'=>'margin-right:20px']) ?>
            */ ?>
        </div>
    </div>
     <?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
     // var t = null;
     var id = <?= $id?>;
     var itemChecked = [];
     $(document).ready(function () {
         // t.destroy();

        $('#tbl_listkamar').DataTable({
        //      "processing": true,
        // "serverSide": true,
        scrollY:        "300px",
        // scrollX:        true,
        scrollCollapse: true,
        columnDefs: [
            // {
            //     // width: '20%', targets: 0,
            //     "targets": [ 0 ],
            //     "visible": false,
            // },

            // { width: '10%', targets: 0 },
            // { width: '25%', targets: 1 },
            // { width: '25%', targets: 2 },
            // { width: '25%', targets: 3 },
            // { width: '15%', targets: 4 }
        ],
        fixedColumns: true,
             "ajax": '<?php echo \Yii::$app->getUrlManager()->createUrl("myadmin/rooms/getlistkamar");?>?id='+id,
             "columns": [
                 {"data": "id"},
                 {"data": "no"},
                 {"data": "nomor_kamar"},
                 {"data": "type"},
                 {"data": "harga"},
                 {
                     // "orderable": false,
                     "data": 'fungsi',
                     "defaultContent": ''
                 },

             ],
             "order": [[0, 'asc']]
         });


         //get local storage checked
             var itemHasChek = getCheckFromLocalStorage();
             if(itemHasChek != null) {
                 var arrChck = itemHasChek.split(',');
                 itemChecked = arrChck;
                 for(var i = 0; i <= arrChck.length - 1; i++) {
                     $( ".clpilih-" + arrChck[i] ).prop( "checked", true );
                 }
             }

             //cek all is checked
             var jml = $("input[name='nmpilih[]']").length;
             jml_checked = 0;
             $.each($("input[name='nmpilih[]']:checked"), function(){
                 jml_checked++;
                 if(jml_checked == jml) {
                     $( "#checkall" ).prop( "checked", true );
                 }
             });
     });

     checkAll = () => {
        var isChecked = $('#checkall:checkbox:checked').length > 0;
        if(isChecked) {
            $.each($("input[name='nmpilih[]']"), function(){
                $(this).prop( "checked", true );
                var val = $(this).val();
                var hasIna = false;
                for(var i = 0; i <= itemChecked.length - 1; i++) {
                    if(itemChecked[i] == val) {
                        hasIna = true;
                    }
                }
                if(!hasIna) {
                    itemChecked.push(val);
                }
            });
            saveCheckToLocalStotag(itemChecked);
        } else {
            $.each($("input[name='nmpilih[]']:checked"), function(){
                $(this).prop( "checked", false );
                var filter = $(this).val();
                itemChecked = itemChecked.filter(function(ele){
                    return ele != filter;
                });
            });
            saveCheckToLocalStotag(itemChecked);
        }
    }

    resetChecked = () => {
        for(var i = 0; i <= itemChecked.length - 1; i++) {
            $( ".clpilih-" + itemChecked[i] ).prop( 'checked', false );
        }
        localStorage.removeItem('itemChecked');
        itemChecked = [];
    }


    clearCheckFromLocalStorage = () => {
        localStorage.removeItem('itemChecked');
    }

    saveCheckToLocalStotag = (arr) => {
        localStorage.setItem('itemChecked', arr);
    }

    getCheckFromLocalStorage = () => {
        return localStorage.getItem('itemChecked');
    }

    checkKamar = (id) => {
        var isChecked = $('.clpilih-'+id+':checkbox:checked').length > 0;
        if(isChecked) {
            var hasIn = false;
            for(var i = 0; i <= itemChecked.lengh -1; i++) {
                if(itemChecked[i] == id) {
                    hasIn = true;
                }
            }
            if(!hasIn) {
                itemChecked.push(id);
            }
        } else {
            itemChecked = itemChecked.filter(function(ele){
                return ele != id;
            });
        }
        console.log(itemChecked);
        saveCheckToLocalStotag(itemChecked);
    }

    function tutup()
    {
        $("#modalPilihkamarId").modal("hide");
        clearCheckFromLocalStorage();
    }

     function savekamar(id)
     {
         // var favorite = [];
             // $.each($("input[name='selection[]']:checked"), function(){
             //     favorite.push($(this).val());
             // });
             // var terpilih = [];
             var terpilih = getCheckFromLocalStorage();//favorite.join(",");
             if(terpilih === null || terpilih === "") {
                 swal('Informasi', "Harap pilih Kamar",'info');
                 return;
             } else {
                // terpilih.push(id);
                terpilih = terpilih +','+id;
                // console.log(terpilih);
                // return false;
                $.ajax({
                    type: "POST",
                    data: {
                        data: terpilih
                    },
                    dataType: "json",
                    url:"<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/notifterpilih'])?>",
                    success: function(data) {
                        if(data.status == "success") {
                            swal(data.title, data.msg, data.status).then((ya) => {
                                if (ya) {
                                    tutup();
                                    $("#terpilih").val(data.result);
                                }
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("Error submiting!", "Please try again", "error");
                    }
                });
             }
     }

</script>
