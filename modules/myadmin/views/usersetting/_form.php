<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<style type="text/css">
    .geserkanan {
        margin-right: 5px;
    }
</style>
<div class="box box-warning">
    <div class="box-body">
        <div class="rooms-form">

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
                    "id" => "form-usersetting",
                    "class" => "",
                    'onsubmit'=>'return false;',
                    // "data-parsley-validate" => "",
                    // 'enctype'=>'multipart/form-data',
                    // 'novalidate' => 'novalidate'
                ]
            ]); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group required">
                                <!-- <?//= $form->field($model, 'username')->dropDownList($listDatametode, ['class' => 'form-control select validate[required]', 'prompt' => 'Pilih Metode Pembayaran...']); ?> -->
                                <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'class' => 'form-control', 'autocomplete' => 'off']); ?>
                            </div>
                            <div class="form-group required">
                                <!-- <?//= $form->field($model, 'username')->dropDownList($listDatametode, ['class' => 'form-control select validate[required]', 'prompt' => 'Pilih Metode Pembayaran...']); ?> -->
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'type' => 'email', 'class' => 'form-control', 'autocomplete' => 'off']); ?>
                            </div>
                            <div class="form-group required">
                                <?= $form->field($model, 'id_shift')->dropDownList($listShift, ['class' => 'form-control select validate[required]', 'prompt' => 'Pilih Shift ...']); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <!-- <?//= $form->field($model, 'username')->dropDownList($listDatametode, ['class' => 'form-control select validate[required]', 'prompt' => 'Pilih Metode Pembayaran...']); ?> -->
                                <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'class' => 'form-control', 'autocomplete' => 'off']); ?>
                            </div>
                            <div class="form-group required">
                                <!-- <?//= $form->field($model, 'username')->dropDownList($listDatametode, ['class' => 'form-control select validate[required]', 'prompt' => 'Pilih Metode Pembayaran...']); ?> -->
                                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'class' => 'form-control', 'autocomplete' => 'off']); ?>
                            </div>
                            <div class="form-group required">
                                <?=
                                $form->field($model, 'role')->dropDownList(
                                    [
                                        'empty' => 'Pilih Role ...',
                                        '1' => 'Front Office',
                                        '2' => 'Admin'
                                    ],
                                    ['class' => 'form-control select']
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- <?//=Html::a('<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan', 'javascript:savesetharga()', ['class' => 'btn btn-success pull-right mr_tombol', 'id'=>'saveaddpengeluaran']) ?> -->
        <?= Html::a($model->isNewRecord ? '<i class="fa fa-floppy-o" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil" aria-hidden="true"></i> Update', $model->isNewRecord ? 'javascript:savesetuser()' : 'javascript:updatesetuser("' . $id . '")', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-success pull-right']) ?>
        <?= Html::button('<i class="fa fa-times" aria-hidden="true"></i> Close', ['class' => 'btn btn-danger pull-right geserkanan', 'data-dismiss' => 'modal']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script type="text/javascript">
$(document).ready(function () {
    $(".select").select2();

});

</script>
