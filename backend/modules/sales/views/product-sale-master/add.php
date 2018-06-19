<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\EstimatedProforma */

$this->title = 'Product Sale';
$this->params['breadcrumbs'][] = ['label' => ' Pre-Funding', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .form-group {
        margin-bottom: 0px;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">

            <div class="panel-heading">
                <h2  class="appoint-title panel-title"><?= Html::encode($this->title) . '</b>' ?></h2>
                <div class="diplay-amount"><i class="fa fa-inr" aria-hidden="true"></i> <span id="total-order-amount">00.00</span></div>
            </div>
            <?php //Pjax::begin();       ?>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Product Sale</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="modal fade" id="modal-6">
                    <div class="modal-dialog" id="modal-pop-up">

                    </div>
                </div>
                <?php
                $form = ActiveForm::begin();
                ?>
                <div class="panel-body">

                    <input type="hidden" id="stockinvoicemaster-amount" class="form-control" name="StockInvoiceMaster[amount]" readonly="" aria-invalid="false">

                    <div class="sales-invoice-master-create">
                        <div class="sales-invoice-master-form form-inline">
                            <div class="row">
                                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                    <?php
                                    $model_master->date = date('d-M-Y');
                                    ?>
                                    <?=
                                    $form->field($model_master, 'date')->widget(DatePicker::classname(), [
                                        'type' => DatePicker::TYPE_INPUT,
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'dd-M-yyyy',
                                        ]
                                    ]);
                                    ?>
                                </div>
                                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                    <?= $form->field($model_master, 'invoice_no')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                    <?= $form->field($model_master, 'comment')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive form-control-new" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true" style="overflow: visible;">
                    <?php
                    $items = common\models\FinishedProduct::find()->where(['status' => 1])->all();
                    ?>
                    <table cellspacing="0" class="table table-small-font table-bordered table-striped" id="add-invoicee">
                        <thead>
                            <tr>
                                <th data-priority="3" style="width: 25%;">Product</th>
                                <th data-priority="6" style="">Quantity</th>
                                <th data-priority="6" style="">Unit</th>
                                <th data-priority="6" style="">Comment</th>
                                <th data-priority="1" style="width: 1%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <input type="hidden" value="1" name="next_item_id" id="next_item_id"/>
                        <tr class="filter" id="item-row-1">
                            <td>
                                <div class="form-group field-stockadjdtl-item_code has-success">
                                    <select id="productsale_id-1" class="form-control product_id add-next" name="ProductSaleDetailsMaterial[1]" aria-invalid="false">
                                        <option value="">-Choose a Product-</option>
                                        <?php foreach ($items as $value) { ?>
                                            <option value="<?= $value->id ?>"><?= $value->product_name ?></option>
                                        <?php }
                                        ?>
                                    </select>

                                    <div class="help-block"></div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" id="productsale_qty-1" class="form-control productsale_qty" name="ProductSaleDetailsQty[1]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off">
                                    <div class="help-block"></div>
                                </div>
                                <div class="stock-check" id="stock-check-1" style="display:none;">
                                    <p style="text-align: center;font-weight: bold;color: black;">Stock :<span class="stock-exist" id="stock-exist-1"></span></p>
                                </div>
                                <input type="hidden" value=""  class="form-control" id="sales-qty-count-1" name="sales_qty_count[1]" readonly/>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" id="productsale_unit-1" class="form-control stockadjdtl-item_cost" name="ProductSaleDetailsUnit[1]" aria-invalid="false" readonly>
                                    <div class="help-block"></div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" id="productsale_comment-1" class="form-control stockadjdtl-item_cost" name="ProductSaleDetailsComment[1]" aria-invalid="false">
                                    <div class="help-block"></div>
                                </div>
                            </td>
                            <td>
                                <a id="del" class="" ><i class="fa fa-times sales-invoice-delete"></i></a>
                            </td>
                        </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th data-priority="3" style="width: 25;">Item Total</th>
                                <th data-priority="6" style=""></th>
                                <th data-priority="6" style=""></th>
                                <th data-priority="6" style=""><input type="text" id="sub_total" class="amount-receipt-1" name="sub_total" style="width: 100%;" readonly/></th>
                                <th data-priority="1" style="width: 1%;"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <a href="" id="add_another_line"><i class="fa fa-plus" aria-hidden="true"></i> Add Another Line</a>
                <div class="clear-fix"></div>
                <div class="col-md-12">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-secondary', 'name' => 'save', 'value' => 'save', 'style' => 'padding: 7px 25px 7px 25px;margin-top: 18px;']) ?>
                    <?= Html::a('Discard', ['add'], ['class' => 'btn btn-gray btn-reset']) ?>
                </div>
                <?php ActiveForm::end(); ?>



            </div>
            <?php //Pjax::end();                                   ?>
        </div>
    </div>
</div>
<style>
    .filter{
        background-color: #b9c7a7;
    }
</style>
<script>
    $(document).ready(function () {
        $(document).on('change', '.product_id', function (e) {
            alert('sdg');
            var flag = 0;
            var count = 0;
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var next_row_id = $('#next_item_id').val();
            var item_id = $(this).val();
            var row_count = $('#next_item_id').val();
            if (row_count > 1) {
                for (i = 1; i <= row_count; i++) {
                    var item_val = $('#product_id-' + i).val();
                    if (item_val == item_id) {
                        count = count + 1;
                    }
                }
                if (item_id != '') {
                    if (count > 1) {
                        flag = 1;
                    } else {
                        flag = 0;
                    }
                } else {
                    $('#product_id-' + current_row_id).val('');
                    $('#sales-qty-count-' + current_row_id).val('');
                    $('#stock-check-' + current_row_id).css('display', 'none');
                    $("#stock-check-" + current_row_id + " span").text('');
                    $('#productsale_qty-' + current_row_id).val('');
                    $("#productsale_unit-" + current_row_id).val('');
                    $('#productsale_comment-' + current_row_id).val('');
                    e.preventDefault();
                }
            }
            if (flag == 0) {
                productChange(item_id, current_row_id, next_row_id);
            } else {
                alert('This Item is already Choosed');
                $('#product_id-' + current_row_id).val('');
                $('#sales-qty-count-' + current_row_id).val('');
                $('#stock-check-' + current_row_id).css('display', 'none');
                $("#stock-check-" + current_row_id + " span").text('');
                $('#productsale_qty-' + current_row_id).val('');
                $("#productsale_unit-" + current_row_id).val('');
                $('#productsale_comment-' + current_row_id).val('');
                e.preventDefault();
            }
        });

        $('#add-invoicee').on('click', '#del', function () {
            var bid = this.id; // button ID
            var trid = $(this).closest('tr').attr('id'); // table row ID
            $(this).closest('tr').remove();
            calculateSubtotal();
        });
        $(document).on('click', '#add_another_line', function (e) {
            var rowCount = $('#add-invoicee >tbody >tr').length;
            var next_row_id = $('#next_item_id').val();
            var next = parseInt(next_row_id) + 1;
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {next_row_id: next_row_id},
                url: '<?= Yii::$app->homeUrl; ?>stock/stock-adj-dtl/add-another-row',
                success: function (data) {
                    var res = $.parseJSON(data);
                    console.log(res);
                    $('#add-invoicee tr:last').after(res.result['next_row_html']);
                    $("#next_item_id").val(next);
                    $('.stockadjdtl-qty').attr('type', 'number');
                    $('.stockadjdtl-qty').attr('min', 1);
                    $('#stockadjdtl-item_code-' + rowCount).removeClass("add-next");
                    $('#stockadjdtl-item_code-' + next).select2({
                        allowClear: true
                    }).on('select2-open', function ()
                    {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                    });
                    e.preventDefault();
                }
            });
        });
    });
    function productChange(item_id, current_row_id, next_row_id) {
        var next = parseInt(next_row_id) + 1;
        $.ajax({
            type: 'POST',
            cache: false,
            async: false,
            data: {item_id: item_id},
            url: '<?= Yii::$app->homeUrl; ?>stock/product-sale-master/get-items',
            success: function (data) {
                var res = $.parseJSON(data);
                console.log(res);
                if (data != 1) {
                    $('#stockadjdtl-qty-' + current_row_id).val(1);
                    $("#stockadjdtl-item_cost-" + current_row_id).val(res.result['item_rate']);
                    if ($('#stockadjdtl-qty-' + current_row_id).val() != "" && $("#stockadjdtl-item_cost-" + current_row_id).val() != "") {
                        lineTotalAmount(current_row_id);
                    }
                } else {
                    $('#sales-qty-count-' + current_row_id).val('');
                    $('#stock-check-' + current_row_id).css('display', 'none');
                    $("#stock-check-" + current_row_id + " span").text('');
                    $('#stockadjdtl-qty-' + current_row_id).val('');
                    $("#stockadjdtl-item_cost-" + current_row_id).val('');
                    $('#stockadjdtl-item_total-' + current_row_id).val('');
                    $("#stockadjdtl-item_code-" + current_row_id).select2('val', '');
                }
                calculateSubtotal();
            }
        });
        return true;
    }
    function lineTotalAmount(current_row_id) {
        var qty = $('#stockadjdtl-qty-' + current_row_id).val();
        var rate = $('#stockadjdtl-item_cost-' + current_row_id).val();
        total_amount = parseFloat(qty) * parseFloat(rate);
        $('#stockadjdtl-item_total-' + current_row_id).val(total_amount.toFixed(2));
        calculateSubtotal();
    }
    function calculateSubtotal() {

        var row_count = $('#next_item_id').val();
        var sub_total = 0;
        for (i = 1; i <= row_count; i++) {
            var amount = $('#stockadjdtl-item_total-' + i).val();
            if (!amount && amount == '' || amount == null) {

                amount = 0;
            }
            sub_total = parseFloat(sub_total) + parseFloat(amount);
        }
        $('#sub_total').val(sub_total.toFixed(2));
        $('#total-order-amount').text(sub_total.toFixed(2));
    }
</script>