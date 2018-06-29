<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\BomMaster */
/* @var $form yii\widgets\ActiveForm */
$model->bom_no = $this->context->getBomNo();
?>
<style>
    .table_row{
        display: none;
    }
</style>
<div class="bom-master-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'bom_no')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php
            $model->date = date('d-M-Y');
            ?>
            <?=
            $form->field($model, 'date')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-M-yyyy',
                ]
            ]);
            ?>
        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Pending']) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <h5 style="color: #313131;font-weight: 600;">BOM Details</h5>
    <div id="p_scents">
        <input type="hidden" id="bom_row_count" value="1"/>
        <div class="append-box">
            <div class="row box_row" id="box_row-1">
                <div class="col-md-3">
                    <div class="formrow">
                        <?php
                        $products = \common\models\FinishedProduct::find()->where(['status' => 1])->all();
                        ?>
                        <label class="control-label">Product Name</label>
                        <select class="form-control product_id" name="create[1][product]" id="product_id-1" required>
                            <option value="">Select Product</option>
                            <?php
                            if (!empty($products)) {
                                foreach ($products as $product) {
                                    ?>
                                    <option value="<?= $product->id ?>"><?= $product->product_name ?></option>
                                    <?php
                                }
                            }
                            ?>
                            <input type="hidden" class="form-control product_qty" name="create[1][product]" placeholder="Product" id="product-1">
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="formrow">
                        <label class="control-label">Quantity</label>
                        <input type="number"  min="1" autocomplete="off"  step="any" class="form-control product_qty" name="create[1][product_qty]" placeholder="Quantity" id="product_qty-1" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="formrow">
                        <label class="control-label">Product Comment</label>
                        <input type="text" class="form-control product_comment" name="create[1][product_comment]" placeholder="Product Comment" id="product_comment-1">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="formrow">
                        <a class="box_btn" id="box_btn-1" style="">Add</a>
                        <a class="box_btn_remove" id="box_btn_remove-1" style="">Cancel</a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12" style="margin-bottom:15px;">
                    <div>Product Comment : <span id="exist_product_comment-1"> </span></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row table_row table-responsive" id="table_row-1" style="border:none;">
                <div id="bom-material-details-1" class="bom-material-details">

                </div>
            </div>
        </div>
    </div>
    <!--    <div class="form-group field-portcalldatarob-fresh_water_arrival_quantity">
            <a id="addbomdetails" class="btn btn-icon btn-blue addScnt btn-larger btn-block" ><i class="fa fa-plus"></i> Add More</a>
        </div>-->
    <div class="clearfix"></div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).ready(function () {
        $(document).on('click', '#addbomdetails', function (event) {
            var row_id = $('#bom_row_count').val();
            var next = parseInt(row_id) + 1;
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {next: next},
                url: '<?= Yii::$app->homeUrl ?>bom/bom-master/get-bom',
                success: function (data) {
                    $('#p_scents').append(data);
                }
            });
            counter++;
        });
        $(document).on('click', '.ibtnDel', function () {
            $(this).parents('.append-box').remove();
            return false;
        });
        $(document).on('change', '.product_id', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var item_id = $(this).val();
            itemChange(item_id, current_row_id);
        });
        $(document).on('click', '.box_btn', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            $("#product_id-" + current_row_id).prop("disabled", true);
            $("#product_qty-" + current_row_id).prop("readonly", true);
            $("#box_btn-" + current_row_id).css('display', 'none');
            $("#table_row-" + current_row_id).css('display', 'block');
            $("#box_btn_remove-" + current_row_id).css('display', 'block');
        });
        $(document).on('click', '.box_btn_remove', function (e) {
            location.reload();
        });
        $(document).on('keyup mouseup', '.product_qty', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            calculateQty(current_row_id);
        });
        $(document).on('keyup mouseup', '.material_qty', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var array = $(this).attr('id').split("-");
            var row_id = array[array.length - 1];
            var qt_val = parseInt($(this).val());
            var material_availqty_val = parseInt($('#material_avail_qty_' + current_row_id + '-' + row_id).text());
            if (qt_val <= material_availqty_val) {
                $('#material_qty_' + current_row_id + '-' + row_id).val(qt_val);
            } else {
                alert('Quantity exeeds the available quantity');
                $('#material_qty_' + current_row_id + '-' + row_id).val(material_availqty_val);
            }
        });
        $(document).on('change', '.invoice-material_id', function (e) {
            var flag = 0;
            var count = 0;
            var idd = $(this).attr('id');
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var array = idd.split('-');
            var material_row_id = array[2];
            var row_count = $('#material_cout_row-' + current_row_id).val();
            var item_id = $(this).val();
            if (row_count > 1) {
                for (i = 1; i <= row_count; i++) {
                    var item_val = $('#invoice-material_id_' + current_row_id + '-' + i).val();
                    if (item_val == item_id) {
                        count = count + 1;
                    }
                }
                if (count > 1) {
                    flag = 1;
                } else {
                    flag = 0;
                }
            }
            if (flag == 0) {
                materialChange(item_id, current_row_id, material_row_id);
            } else {
                alert('This Item is already Choosed');
                $('#invoice-material_id_' + current_row_id + '-' + material_row_id).val('');
                $('#material_avail_qty_' + current_row_id + '-' + material_row_id).text('');
                $('#material_reserve_qty_' + current_row_id + '-' + material_row_id).text('');
                $('#material_unit_' + current_row_id + '-' + material_row_id).text('');
                $('#material_comment_' + current_row_id + '-' + material_row_id).text('');
                $('#material_qty_' + current_row_id + '-' + material_row_id).attr({
                    "max": '', // substitute your own
                });
                e.preventDefault();
            }
        });

        $(document).on('click', '#add_another_line', function (e) {
            var rowCount = $('#add-materials >tbody >tr').length;
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {rowCount: rowCount},
                url: homeUrl + 'bom/bom-master/add-another-row',
                success: function (data) {
                    var res = $.parseJSON(data);
                    console.log(res);
                    $('#add-materials tr:last').after(res.result['next_row_html']);
                    $("#material_cout_row-1").val(res.result['next']);
                    e.preventDefault();
                }
            });
        });
        $(document).on('click', '#del', function (e) {
            var bid = this.id; // button ID
            var trid = $(this).closest('tr').attr('id'); // table row ID
            $(this).closest('tr').remove();
        });
    });

    function materialChange(item_id, current_row_id, material_row_id) {
        $.ajax({
            type: 'POST',
            cache: false,
            async: false,
            data: {item_id: item_id},
            url: '<?= Yii::$app->homeUrl; ?>bom/bom-master/get-material',
            success: function (data) {
                var res = $.parseJSON(data);
                $('#material_comment_' + current_row_id + '-' + material_row_id).text(res.result['comment']);
                $('#material_avail_qty_' + current_row_id + '-' + material_row_id).text(res.result['avail']);
                $('#material_reserve_qty_' + current_row_id + '-' + material_row_id).text(res.result['reserve']);
                $('#material_unit_' + current_row_id + '-' + material_row_id).text(res.result['unit']);
                $('#material_qty_val_' + current_row_id + '-' + material_row_id).val(1);
                $('#material_qty_' + current_row_id + '-' + material_row_id).attr({
                    "max": res.result['avail'] - res.result['reserve'], // substitute your own
                });
                $('#material_qty_' + current_row_id + '-' + material_row_id).focus();
            }
        });
        return true;
    }
    function calculateQty(current_row_id) {
        var rowCount = $('.table-' + current_row_id + ' tr').length;
        var product_qty = $('#product_qty-' + current_row_id).val();
        if (rowCount > 0) {
            for (i = 1; i <= rowCount; i++) {
                var material_qty_val = $('#material_qty_val_' + current_row_id + '-' + i).val();
                var material_availqty_val = $('#material_avail_qty_' + current_row_id + '-' + i).text();
                if (product_qty && product_qty != "" && material_qty_val && material_qty_val != "") {
                    var qt_val = parseFloat(product_qty) * parseFloat(material_qty_val);
                    if (qt_val <= material_availqty_val) {
                        $('#material_qty_' + current_row_id + '-' + i).val(qt_val);
                    } else {
                        $('#material_qty_' + current_row_id + '-' + i).val(material_availqty_val);
                    }
                }
            }
        }
    }
    function itemChange(item_id, current_row_id) {
        $.ajax({
            type: 'POST',
            cache: false,
            async: false,
            data: {item_id: item_id, current_row_id: parseInt(current_row_id)},
            url: '<?= Yii::$app->homeUrl; ?>bom/bom-master/get-items',
            success: function (data) {
                var res = $.parseJSON(data);
                $("#bom-material-details-" + current_row_id).html(res.result['new_row']);
                $("#product_qty-" + current_row_id).val(1);
                $("#product_qty-" + current_row_id).focus();
                $("#product-" + current_row_id).val(item_id);
                $("#exist_product_comment-" + current_row_id).text(res.result['product_comment']);
                $("#box_btn-" + current_row_id).css('display', 'block');
                $('#material_qty_val_' + current_row_id + '-' + material_row_id).val(1);
                calculateQty(current_row_id);
            }
        });
        return true;
    }
</script>
