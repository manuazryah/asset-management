<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Supplier;
use common\models\Unit;
use yii\helpers\Url;
use common\components\ModalViewWidget;

/* @var $this yii\web\View */
/* @var $model common\models\SupplierwiseRowMaterial */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Add Material';
?>
<style>
    label {
        font-weight: bold;
        color: #484848;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <div class="panel-body">
                <div class="purchase-master-create">
                    <div class="supplierwise-row-material-form form-inline">
                        <?= \common\components\AlertMessageWidget::widget() ?>
                        <?php
                        echo ModalViewWidget::widget();
                        ?>
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <?php $category = ArrayHelper::map(\common\models\RowMaterialCategory::findAll(['status' => 1]), 'id', 'category'); ?>
                                <?= $form->field($model, 'material_ctegory')->dropDownList($category, ['prompt' => '-Choose Category-']) ?>

                            </div>
                            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <?= $form->field($model, 'item_code')->textInput(['maxlength' => true]) ?>

                            </div>
                            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <?php $units = ArrayHelper::map(Unit::findAll(['status' => 1]), 'id', 'unit_name'); ?>
                                <?= $form->field($model, 'item_unit')->dropDownList($units, ['prompt' => '-Choose Unit-']) ?>

                            </div>
                            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <?php $supplier = ArrayHelper::map(Supplier::findAll(['status' => 1]), 'id', 'company_name'); ?>
                                <?= $form->field($model, 'supplier')->dropDownList($supplier, ['prompt' => '-Choose Supplier-']) ?>
                            </div>
                            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <?= $form->field($model, 'purchase_price')->textInput(['maxlength' => true]) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <?= $form->field($model, 'minimum_quantity')->textInput(['maxlength' => true]) ?>

                            </div>
                            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <?= $form->field($model, 'reference')->textInput(['maxlength' => true]) ?>

                            </div>
                            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                                <div class="form-group">
                                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'add_material']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("document").ready(function () {
            $(document).on('click', '.modalButton', function () {
                $('#modal').modal('show')
                        .find('#modalContent')
                        .load($(this).attr("value"));
            });
        });
    </script>
    <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2.css">
    <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2-bootstrap.css">
    <script src="<?= Yii::$app->homeUrl; ?>js/select2.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($)
        {
            $("#supplierwiserowmaterial-supplier").select2({
                allowClear: true
            }).on('select2-open', function ()
            {
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
            });
            $("#supplierwiserowmaterial-material_ctegory").select2({
                allowClear: true
            }).on('select2-open', function ()
            {
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
            });

        });
    </script>
    <script>

        $('#add_material').click(function (event) {
            var row_count = $('#next_item_id').val();
            event.preventDefault();
            if (valid()) {
                var material_ctegory = $('#supplierwiserowmaterial-material_ctegory').val();
                var item_code = $('#supplierwiserowmaterial-item_code').val();
                var item_name = $('#supplierwiserowmaterial-item_name').val();
                var item_unit = $('#supplierwiserowmaterial-item_unit').val();
                var supplier = $('#supplierwiserowmaterial-supplier').val();
                var purchase_price = $('#supplierwiserowmaterial-purchase_price').val();
                var minimum_quantity = $('#supplierwiserowmaterial-minimum_quantity').val();
                var reference = $('#supplierwiserowmaterial-reference').val();
                var comment = $('#supplierwiserowmaterial-comment').val();
                $.ajax({
                    url: '<?= Yii::$app->homeUrl ?>purchase/purchase-master/add-material',
                    type: "post",
                    data: {material_ctegory: material_ctegory, item_code: item_code, item_name: item_name, item_unit: item_unit, supplier: supplier, purchase_price: purchase_price, minimum_quantity: minimum_quantity, reference: reference, comment: comment},
                    success: function (data) {
                        var $data = JSON.parse(data);
                        if ($data.con === "1") {
                            for (i = 1; i <= row_count; i++) {
                                var newOption = $('<option value="' + $data.id + '">' + $data.name + ' - ' + $data.category + '</option>');
                                $('#invoice-item_id-' + i).append(newOption);
                            }
                            $('#modal').modal('hide');
                        } else {
                            alert($data.error);
                        }

                    }, error: function () {

                    }
                });
            } else {
                //            alert('Please fill the Field');
            }

        });
        var valid = function () { //Validation Function - Sample, just checks for empty fields
            var valid;
            $("input").each(function () {
                if (!$('#supplierwiserowmaterial-material_ctegory').val()) {
                    $('#supplierwiserowmaterial-material_ctegory').focus();
                    valid = false;
                }
                if (!$('#supplierwiserowmaterial-item_code').val()) {
                    $('#supplierwiserowmaterial-item_code').focus();
                    valid = false;
                }
                if (!$('#supplierwiserowmaterial-item_name').val()) {
                    $('#supplierwiserowmaterial-item_name').focus();
                    valid = false;
                }
                if (!$('#supplierwiserowmaterial-item_unit').val()) {
                    $('#supplierwiserowmaterial-item_unit').focus();
                    valid = false;
                }
                if (!$('#supplierwiserowmaterial-supplier').val()) {
                    $('#supplierwiserowmaterial-supplier').focus();
                    valid = false;
                }
            });
            if (valid !== false) {
                return true;
            } else {
                return false;
            }
        }
    </script>