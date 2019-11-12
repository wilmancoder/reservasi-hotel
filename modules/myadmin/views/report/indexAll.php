<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Report All';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
.tombol{
    margin-bottom: 5px;
}
.labelcari {
    color: white;
}
</style>
<div class="reportall-index">
    <h1 class="title"><i class="fa fa-list" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h1><br>
    <div align="center">
        <label class="control-label"><h3 class="title">Laporan Pendapatan per Periode </h3></label>
    </div>

    <div class="box box-warning">
        <div class="box-body">
            <div class="row">
                <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-4',
                            'wrapper' => 'col-sm-7',
                            // 'label' => 'col-md-4 col-sm-4 col-xs-12',
                            // 'wrapper' => 'col-md-6 col-sm-6 col-xs-12',
                        ],
                    ],
                    "options" => [
                        "id" => "form-filterreport",
                        "class" => "",
                        'onsubmit'=>'return false;',
                        // "data-parsley-validate" => "",
                        // 'enctype'=>'multipart/form-data',
                        // 'novalidate' => 'novalidate'
                    ]
                ]); ?>
                <div class="col-md-4">
                    <div class="form-group required">
                        <?= $form->field($model, 'startdate')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal','placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group required">
                        <?= $form->field($model, 'enddate')->textInput(['maxlength' => true, 'class' => 'form-control form-tanggal','placeholder' => 'Klik disini ...', 'autocomplete' => 'off']) ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="control-label labelcari">Cari</label>
                    <div class="form-group">
                        <?= Html::button('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-success btn-block', 'onclick' => 'reportpreview()']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <hr>
            <div class="row">
                <div class="box-body table-responsive">
                    <table id="tbl_report_all" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                 <th>No.</th>
                                 <th>Nama Petugas</th>
                                 <th>Jenis Pembayaran</th>
                                 <th>Status Pembayaran</th>
                                 <th>Tanggal Uang Masuk</th>
                                 <th>Jumlah Uang Masuk</th>
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
    var posting = '<?= $posting?>';
    $(document).ready(function () {
        $('.form-tanggal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        t = $('#tbl_report_all').DataTable({
            "processing": true,
            // "serverSide": true,
            "ordering": true,
            // "paging": true,
            // "info": false,
            "searching": true,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '20%', targets: 1 },
                { width: '15%', targets: 2 },
                { width: '20%', targets: 3 },
                { width: '15%', targets: 4 },
                {
                    width: '25%', targets: 5,
                    targets: 5,
                    className: 'dt-body-right'
                },
            ],
            "ajax": {
                "type": 'GET',
                "dataType": "JSON",
                "url": "<?=\Yii::$app->getUrlManager()->createUrl("myadmin/report/getdatareportall");?>?posting="+posting,
            },
            "columns": [

                 {"data": "no"},
                 {"data": "nama_petugas"},
                 {"data": "pembayaran"},
                 {"data": "status_pembayaran"},
                 {"data": "tgl_uangmasuk"},
                 {"data": "jml_uangmasuk"}


             ],
        });
    });

    function reportpreview() {
        var _data = new FormData($("#form-filterreport")[0]);
        $.ajax({
            type: "POST",
            data: _data,
            dataType: "json",
            contentType: false,
            processData: false,
            url: "<?=\Yii::$app->getUrlManager()->createUrl(['myadmin/report/listreportall'])?>",

            success: function (result) {
                if(result.status == 'success'){
                    var posting = result.joinposting;
                    // alert(posting); return false;
                    reportAll(posting);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error!", "Terdapat Kesalahan saat memproses semua data laporan!", "error");
            }
        });
    }

    // function reportAll(posting)
    // {
    //     // alert(posting); return false;
    //     var url = "<?php //echo \Yii::$app->getUrlManager()->createUrl("myadmin/report/loadtbl");?>?posting="+posting;
    //     $('#tbl_report_all').load(url);
    // }

    function reportAll(posting)
    {
        t.destroy();

        t = $('#tbl_report_all').DataTable({
            "processing": true,
            // "serverSide": true,
            "ordering": true,
            // "paging": true,
            // "info": false,
            "searching": true,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '20%', targets: 1 },
                { width: '15%', targets: 2 },
                { width: '20%', targets: 3 },
                { width: '15%', targets: 4 },
                {
                    width: '25%', targets: 5,
                    targets: 5,
                    className: 'dt-body-right'
                },
            ],
            "ajax": {
                "type": 'GET',
                "dataType": "JSON",
                "url": "<?=\Yii::$app->getUrlManager()->createUrl("myadmin/report/getdatareportall");?>?posting="+posting,
            },
            "columns": [

                 {"data": "no"},
                 {"data": "nama_petugas"},
                 {"data": "pembayaran"},
                 {"data": "status_pembayaran"},
                 {"data": "tgl_uangmasuk"},
                 {"data": "jml_uangmasuk"}


             ],
        });

    }
</script>
