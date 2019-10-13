<?php

use yii\base\UnknownMethodException;
/* @var $this yii\web\View */
/* @var $model app\models\Artikel */

?>

<!-- The Modal -->
<div class="modal fade" id="modalDetailId">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 align="center" class="modal-title" id="modalDetailTitle"></h4>
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

    $(document).ready(function(){
        showChoosePrice();

    });

    function showChoosePrice()
    {
        var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['site/getchooseprice']);?>";
        var title = "Pilih Harga";
        showModal(url,title);
    }

    function showModal(url,title) {
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
