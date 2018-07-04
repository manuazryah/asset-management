<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\EstimatedProforma */

$this->title = 'Sale';
$this->params['breadcrumbs'][] = ['label' => ' Pre-Funding', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .form-group {
        margin-bottom: 0px;
    }
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        cursor: not-allowed;
        background-color: #fff;
        opacity: 1;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <?php //Pjax::begin();       ?>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Sale</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="modal fade" id="modal-6">
                    <div class="modal-dialog" id="modal-pop-up">

                    </div>
                </div>
                <?= \common\components\AlertMessageWidget::widget() ?>
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
                                    <select id="productsale_id-1" class="form-control product_id add-next" name="ProductSaleDetailsMaterial[1]" aria-invalid="false" required>
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
                                    <input type="number" id="productsale_qty-1" class="form-control productsale_qty" name="ProductSaleDetailsQty[1]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off" required="">
                                    <div style="display: none;"class="avail-stock-div" id="avail-stock-div-1"><strong>AVL:<span id="avail-stock-1"></span></strong></div>
                                    <input type="hidden" id="invoice-avail-qty-1" value="0"/>
                                </div>
                                <div class="stock-check" id="stock-check-1" style="display:none;">
                                    <p style="font-size: 10px;font-weight: bold;color: #ef6262;">Stock :<span class="stock-exist" id="stock-exist-1"></span></p>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" id="productsale_unit-1" class="form-control productsale_unit" name="ProductSaleDetailsUnit[1]" aria-invalid="false" readonly>
                                    <div class="help-block"></div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" id="productsale_comment-1" class="form-control productsale_comment" name="ProductSaleDetailsComment[1]" aria-invalid="false">
                                    <div class="help-block"></div>
                                </div>
                            </td>
                            <td>
                                <a id="del" class="" ><i class="fa fa-times sales-invoice-delete"></i></a>
                            </td>
                        </tr>

                        </tbody>
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
            var flag = 0;
            var count = 0;
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var next_row_id = $('#next_item_id').val();
            var item_id = $(this).val();
            var row_count = $('#next_item_id').val();
            if (row_count > 1) {
                for (i = 1; i <= row_count; i++) {
                    var item_val = $('#productsale_id-' + i).val();
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
                    $('#productsale_id-' + current_row_id).val('');
                    $('#stock-check-' + current_row_id).css('display', 'none');
                    $("#stock-exist-" + current_row_id + " span").text('');
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
                $('#productsale_id-' + current_row_id).val('');
                $('#invoice-avail-qty-' + current_row_id).val(0);
                $("#avail-stock-div-" + current_row_id).css("display", "none");
                $('#productsale_qty-' + current_row_id).attr('max', '');
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
        $(document).on('keyup mouseup', '.productsale_qty', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var stock = $("#stock-exist-" + current_row_id).text();
            if (stock && stock != '') {
                var qty = $('#productsale_qty-' + current_row_id).val();
                if (parseInt(qty) > parseInt(stock)) {
                    alert('Quantity exeeds the availabel quantity');
                    $('#productsale_qty-' + current_row_id).val(stock);
                }
            }
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
                url: '<?= Yii::$app->homeUrl; ?>sales/product-sale-master/add-another-row',
                success: function (data) {
                    var res = $.parseJSON(data);
                    console.log(res);
                    $('#add-invoicee tr:last').after(res.result['next_row_html']);
                    $("#next_item_id").val(next);
                    $('.productsale_qty').attr('type', 'number');
                    $('.productsale_qty').attr('min', 1);
                    e.preventDefault();
                }
            });
        });

        $(document).on('keyup mouseup', '.productsale_qty', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var qty = $(this).val();
            var item = $('#productsale_id-' + current_row_id).val();
            if (item == '') {
                $('#productsale_qty-' + current_row_id).val('');
                e.preventDefault();
            } else {
                var material_availqty_val = parseInt($("#invoice-avail-qty-" + current_row_id).val());
                if (qty > material_availqty_val) {
                    alert('Quantity exeeds the available quantity');
                    $('#productsale_qty-' + current_row_id).val(material_availqty_val);
                }
            }
        });
    });
    function productChange(item_id, current_row_id, next_row_id) {
        var next = parseInt(next_row_id) + 1;
        $.ajax({
            type: 'POST',
            cache: false,
            async: false,
            data: {item_id: item_id},
            url: '<?= Yii::$app->homeUrl; ?>sales/product-sale-master/get-items',
            success: function (data) {
                var res = $.parseJSON(data);
                $("#productsale_unit-" + current_row_id).val(res.result['unit']);
                $("#invoice-avail-qty-" + current_row_id).val(res.result['avail_qty']);
                $("#productsale_qty-" + current_row_id).val('');
                $("#avail-stock-" + current_row_id).text(res.result['avail_qty']);
                $("#avail-stock-div-" + current_row_id).css("display", "block");
                $('#productsale_qty-' + current_row_id).attr('max', res.result['avail_qty']);
            }
        });
        return true;
    }
</script>