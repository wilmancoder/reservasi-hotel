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
        <div class="col-md-5">
            <div class="info-boxz bg-aqua">
                <span class="info-boxz-icon"><i class="fa fa-tags"></i></span>
                <div class="info-boxz-content">
                  <span class="info-boxz-text">Setting Harga</span>
                  <span class="info-boxz-number">Harga <?= ucfirst($model[0]['kategori_harga']);?></span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description desc">
                    Setting ke kategori harga normal.
                  </span>
              </div><!-- /.info-boxz-content -->
          </div><!-- /.info-boxz -->
        </div>
    </a>
    <!-- <div class="col-md-2"></div> -->
    <a href="#" onclick='javascript:setharga("<?= $model[1]['id'];?>")'>
        <div class="col-md-5">
            <div class="info-boxz bg-aqua">
                <span class="info-boxz-icon"><i class="fa fa-tags"></i></span>
                <div class="info-boxz-content">
                  <span class="info-boxz-text">Setting Harga</span>
                  <span class="info-boxz-number">Harga <?= ucfirst($model[1]['kategori_harga']);?></span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description desc">
                    Setting ke kategori harga weekend.
                  </span>
              </div><!-- /.info-boxz-content -->
          </div><!-- /.info-boxz -->
        </div>
    </a>
    <div class="col-md-1"></div>
  <!-- <div class="col-md-1"></div> -->
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
