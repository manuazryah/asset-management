<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Warehouse;
use common\models\Supplier;
use common\models\SupplierwiseRowMaterial;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-master-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
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

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php $supplier = ArrayHelper::map(Supplier::findAll(['status' => 1]), 'id', 'company_name'); ?>
            <?= $form->field($model, 'supplier')->dropDownList($supplier, ['prompt' => '-Choose Supplier-']) ?>

        </div>
    </div>
    <div class="table-responsive form-control-new" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true" style="overflow: visible;">
        <table cellspacing="0" class="table table-small-font table-bordered table-striped" id="add-invoicee">
            <thead>
                <tr>
                    <th data-priority="3">Material</th>
                    <th data-priority="6" style="width: 13%;">Quantity</th>
                    <th data-priority="6" style="width: 10%;">Price</th>
                    <th data-priority="6" style="width: 15%;">Total</th>
                    <th data-priority="6" style="width: 20%;">Warehouse</th>
                    <th data-priority="1" style="width: 50px;"></th>
                </tr>
                <tr>
            </thead>
            <tbody>
            <input type="hidden" value="1" name="next_item_id" id="next_item_id"/>
            <tr class="filter" id="item-row-1">
                <td>
                    <?php $item_datas = SupplierwiseRowMaterial::findAll(['status' => 1]); ?>
                    <select id="invoice-item_id-1" class="form-control invoice-item_id" name="create[item_id][1]" required>
                        <option value="">-Choose a Item-</option>
                        <?php foreach ($item_datas as $item_data) {
                            ?>
                            <option value="<?= $item_data->id ?>"><?= $item_data->item_name ?></option>
                        <?php }
                        ?>
                    </select>
                </td>
                <td>
                    <input style="width: 70% !important" type="number" id="invoice-qty-1" value="" class="form-control invoice-qty" name="create[qty][1]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off"  step="any" required>
                    <span id="invoice-unit-1"></span>
                </td>
                <td>
                    <input type="text" id="invoice-price-1" value="" class="form-control invoice-price flt-right" name="create[price][1]" placeholder="Price" aria-invalid="false" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" id="invoice-total-1" value="" class="form-control invoice-total flt-right" name="create[total][1]" placeholder="Total" aria-invalid="false" autocomplete="off" required>
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
        <table cellspacing="0" class="table table-small-font table-bordered table-striped" id="add-invoicee">
            <thead>
                <tr>
                    <th data-priority="3">Item Total</th>
                    <th data-priority="6" style="width: 13%;"></th>
                    <th data-priority="6" style="width: 10%;"><span style="float:right" id="price-tot-amt"></span></th>
                    <th data-priority="6" style="width: 15%;"><span style="float:right" id="grand-tot-amt"></span></th>
                    <th data-priority="6" style="width: 20%;"></th>
                    <th data-priority="1" style="width: 50px;   "></th>
                </tr>
            </thead>
        </table>
    </div>
    <a href="" id="add_another_line"><i class="fa fa-plus" aria-hidden="true"></i> Add Another Line</a>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).ready(function () {
        $(document).on('click', '#add_another_line', function (e) {
            e.preventDefault();
            var next_row_id = $('#next_item_id').val();
            var next = parseInt(next_row_id) + 1;
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {next_row_id: next_row_id},
                url: homeUrl + 'purchase/purchase-master/add-another-row',
                success: function (data) {
                    var res = $.parseJSON(data);
                    console.log(res);
                    $('#add-invoicee tr:last').after(res.result['next_row_html']);
                    $("#next_item_id").val(next);
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
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var item_id = $(this).val();
            itemChange(item_id, current_row_id);
        });
        $(document).on('keyup mouseup', '.invoice-qty', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var qty = $(this).val();
            var price = $('#invoice-price-' + current_row_id).val();
            var item = $('#invoice-item_id-' + current_row_id).val();
            if (item == '') {
                $('.salesinvoicedetails-qty-' + current_row_id).val('');
                e.preventDefault();
            }
            if (qty != "" && item != '' && price != '') {
                lineTotalAmount(current_row_id);
            }
        });
        $(document).on('keyup mouseup', '.invoice-price', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var qty = $(this).val();
            var price = $('#invoice-price-' + current_row_id).val();
            var item = $('#invoice-item_id-' + current_row_id).val();
            if (item == '') {
                $('.salesinvoicedetails-qty-' + current_row_id).val('');
                e.preventDefault();
            }
            if (qty != "" && item != '' && price != '') {
                lineTotalAmount(current_row_id);
            }
        });
    });
    function itemChange(item_id, current_row_id) {
        $.ajax({
            type: 'POST',
            cache: false,
            async: false,
            data: {item_id: item_id},
            url: '<?= Yii::$app->homeUrl; ?>purchase/purchase-master/get-items',
            success: function (data) {
                var res = $.parseJSON(data);
                $("#invoice-qty-" + current_row_id).val('1');
                $("#invoice-price-" + current_row_id).val(res.result['price']);
                $("#invoice-unit-" + current_row_id).text(res.result['unit']);
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
