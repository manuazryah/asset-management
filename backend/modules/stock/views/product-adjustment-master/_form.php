<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\Warehouse;
use common\models\FinishedProduct;

/* @var $this yii\web\View */
/* @var $model common\models\ProductAdjustmentMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-adjustment-master-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'transaction')->dropDownList(['0' => 'Opening', '1' => 'Addition', '2' => 'Deduction']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'document_no')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php
            $model->document_date = date('d-M-Y');
            ?>
            <?=
            $form->field($model, 'document_date')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-M-yyyy',
                ]
            ]);
            ?>

        </div>
    </div>
    <div class="table-responsive form-control-new" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true" style="overflow: visible;">
        <table cellspacing="0" class="table table-small-font table-bordered table-striped" id="add-invoicee">
            <thead>
                <tr>
                    <th data-priority="3">Product</th>
                    <th data-priority="6" style="width: 20%;">Quantity</th>
                    <th data-priority="6" style="width: 20%;">Warehouse</th>
                    <th data-priority="1" style="width: 50px;"></th>
                </tr>
                <tr>
            </thead>
            <tbody>
            <input type="hidden" value="1" name="next_item_id" id="next_item_id"/>
            <tr class="filter" id="item-row-1">
                <td>
                    <?php $item_datas = FinishedProduct::findAll(['status' => 1]); ?>
                    <select id="invoice-item_id-1" class="form-control invoice-item_id" name="create[item_id][1]" required>
                        <option value="">-Choose a Item-</option>
                        <?php foreach ($item_datas as $item_data) {
                            ?>
                            <option value="<?= $item_data->id ?>"><?= $item_data->product_name ?></option>
                        <?php }
                        ?>
                    </select>
                </td>
                <td>
                    <input style="width: 70% !important" type="number" id="invoice-qty-1" value="" class="form-control invoice-qty" name="create[qty][1]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off"  step="any" required>
                    <span id="invoice-unit-1"></span>
                    <div style="display: none;"class="avail-stock-div" id="avail-stock-div-1"><strong>AVL:<span id="avail-stock-1"></span></strong></div>
                    <input type="hidden" id="invoice-avail-qty-1" value="0"/>
                </td>
                <td>
                    <?php $warehouse_datas = Warehouse::findAll(['status' => 1]); ?>
                    <select id="invoice-warehouse-1" class="form-control invoice-warehouse" name="create[warehouse][1]" required>
                        <option value="">-Choose a warehouse-</option>
                        <?php foreach ($warehouse_datas as $warehouse_data) {
                            ?>
                            <option value="<?= $warehouse_data->id ?>"><?= $warehouse_data->warehouse_name ?></option>
                        <?php }
                        ?>
                    </select>
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
    <a href="" id="add_another_line"><i class="fa fa-plus" aria-hidden="true"></i> Add Another Line</a>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2.min.js"></script>
<script>
    $(document).ready(function () {

        $('#invoice-item_id-1').select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

        $(document).on('click', '#add_another_line', function (e) {
            e.preventDefault();
            var next_row_id = $('#next_item_id').val();
            var next = parseInt(next_row_id) + 1;
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {next_row_id: next_row_id},
                url: homeUrl + 'stock/product-adjustment-master/add-another-row',
                success: function (data) {
                    var res = $.parseJSON(data);
                    console.log(res);
                    $('#add-invoicee tr:last').after(res.result['next_row_html']);
                    $("#next_item_id").val(next);
                    $('#invoice-item_id-' + next).select2({
                        allowClear: true
                    }).on('select2-open', function ()
                    {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                    });
                }
            });
        });
        $('#add-invoicee').on('click', '#del', function () {
            var bid = this.id; // button ID
            var trid = $(this).closest('tr').attr('id'); // table row ID
            $(this).closest('tr').remove();
            calculateSubtotal();
        });

        $(document).on('change', '.invoice-item_id', function (e) {
            var flag = 0;
            var count = 0;
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var row_count = $('#next_item_id').val();
            var item_id = $(this).val();
            if (row_count > 1) {
                for (i = 1; i <= row_count; i++) {
                    var item_val = $('#invoice-item_id-' + i).val();
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
                itemChange(item_id, current_row_id);
            } else {
                alert('This Item is already Choosed');
                $('#invoice-item_id-' + current_row_id).val('');
                $('#invoice-qty-' + current_row_id).val('');
                $('#invoice-avail-qty-' + current_row_id).val(0);
                $("#avail-stock-div-" + current_row_id).css("display", "none");
                $('#invoice-qty-' + current_row_id).attr('max', '');
                $('#invoice-unit-' + current_row_id).text('');
                $('#invoice-warehouse-' + current_row_id).val('');
                $("#invoice-item_id-" + current_row_id).select2("val", "");
                e.preventDefault();
            }
        });
        $(document).on('change', '#productadjustmentmaster-transaction', function (e) {
            var transaction = $("#productadjustmentmaster-transaction").val();
            var row_count = $('#next_item_id').val();
            for (i = 1; i <= row_count; i++) {
                var item_val = $('#invoice-item_id-' + i).val();
                if (item_val != '') {
                    if (transaction == 2) {
                        var avail_qty = $('#invoice-avail-qty-' + i).val();
                        $("#avail-stock-div-" + i).css("display", "block");
                        $('#invoice-qty-' + i).attr('max', avail_qty);
                    } else {
                        $("#avail-stock-div-" + i).css("display", "none");
                        $('#invoice-qty-' + i).attr('max', '');
                    }
                }
            }
        });
        $(document).on('keyup mouseup', '.invoice-qty', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var qty = $(this).val();
            var transaction = $("#productadjustmentmaster-transaction").val();
            var price = $('#invoice-price-' + current_row_id).val();
            var item = $('#invoice-item_id-' + current_row_id).val();
            if (item == '') {
                $('#salesinvoicedetails-qty-' + current_row_id).val('');
                e.preventDefault();
            } else {
                if (transaction == 2) {
                    var material_availqty_val = parseInt($("#invoice-avail-qty-" + current_row_id).val());
                    if (qty > material_availqty_val) {
                        alert('Quantity exeeds the available quantity');
                        $('#invoice-qty-' + current_row_id).val(material_availqty_val);
                    }
                }
            }
            if (qty != "" && item != '' && price != '') {
                lineTotalAmount(current_row_id);
            }
        });
    });
    function itemChange(item_id, current_row_id) {
        var transaction = $("#productadjustmentmaster-transaction").val();
        $.ajax({
            type: 'POST',
            cache: false,
            async: false,
            data: {item_id: item_id},
            url: '<?= Yii::$app->homeUrl; ?>stock/product-adjustment-master/get-items',
            success: function (data) {
                var res = $.parseJSON(data);
                $("#invoice-qty-" + current_row_id).val('1');
                $("#invoice-unit-" + current_row_id).text(res.result['unit']);
                $("#invoice-avail-qty-" + current_row_id).val(res.result['avail_qty']);
                $("#avail-stock-" + current_row_id).text(res.result['avail_qty']);
                if (transaction == 2) {
                    $("#avail-stock-div-" + current_row_id).css("display", "block");
                    $('#invoice-qty-' + current_row_id).attr('max', res.result['avail_qty']);
                } else {
                    $("#avail-stock-div-" + current_row_id).css("display", "none");
                    $('#invoice-qty-' + current_row_id).attr('max', '');
                }
                lineTotalAmount(current_row_id);
            }
        });
        return true;
    }
    function lineTotalAmount(current_row_id) {

        var amount = 0;
        var qty = $('#invoice-qty-' + current_row_id).val();
        var price = $('#invoice-price-' + current_row_id).val();
        if (qty != "" && price != "") {
            var amount = qty * price;
        }
        $('#invoice-total-' + current_row_id).val(amount.toFixed(2));
        calculateSubtotal();
    }
    function calculateSubtotal() {

        var row_count = $('#next_item_id').val();
        var price_total = 0;
        var amount_total = 0;
        for (i = 1; i <= row_count; i++) {
            var amount = 0;
            var qty = $('#invoice-qty-' + i).val();
            var price = $('#invoice-price-' + i).val();
            if (qty && qty != "" && price && price != "") {
                var amount = qty * price;
                price_total = parseFloat(price_total) + parseFloat(price);
                amount_total = parseFloat(amount_total) + parseFloat(amount);
            }
        }
        $('#price-tot-amt').text(price_total.toFixed(2));
        $('#grand-tot-amt').text(amount_total.toFixed(2));
    }
</script>
