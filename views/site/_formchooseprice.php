<?php
    use yii\helpers\Url;
?>
<style type="text">
.bg-aquaz,
.callout.callout-info,
.alert-info,
.label-info,
.modal-info .modal-body {
  background-color: #00c0ef !important;
  height: 130px;
}
</style>

<div class="row">
  <div class="col-md-1"></div>
  <a href="#" onclick='javascript:setharga("<?= $model[0]['id'];?>")'>
  <div class="col-md-4">
    <!-- small box -->
    <div class="small-boxz bg-aquaz">
      <div class="inner">
        <!-- <h3>Harga Reguler</h3> -->
        <p>Harga</p>
        <p><?= ucfirst($model[0]['kategori_harga']);?></p>
      </div>
      <div class="icon">
        <i class="fa fa-tags fa-xs"></i>
      </div>

    </div>
  </div>
  </a>
  <div class="col-md-2"></div>
  <a href="#" onclick='javascript:setharga("<?= $model[1]['id'];?>")'>
  <div class="col-md-4">
    <!-- small box -->
    <div class="small-boxz bg-aquaz">
      <div class="inner">
        <!-- <h3>Harga Reguler</h3> -->
        <p>Harga</p>
        <p><?= ucfirst($model[1]['kategori_harga']);?></p>
      </div>
      <div class="icon">
        <i class="fa fa-tags fa-xs"></i>
      </div>

    </div>
  </div>
  </a>
  <div class="col-md-1"></div>
</div>

<script type="text/javascript">
    function setharga(idharga) {
        $.ajax({
            type: "GET",
            // data: {hasil:hasil},
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?=\Yii::$app->getUrlManager()->createUrl(['site/getsetharga'])?>?idharga="+idharga,
            beforeSend: function () {
                swal({
                    title: 'Harap Tunggu',
                    text: "Sedang memproses check-in",
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
                    window.location = "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/index'])?>?idharga="+result.idharga;
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error!", "Terdapat Kesalahan saat memproses check-in!", "error");
            }
        });
    }
</script>
