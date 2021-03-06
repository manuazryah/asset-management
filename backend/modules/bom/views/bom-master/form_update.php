<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\BomMaster */

$this->title = 'Update Job Order(BOM)';
$this->params['breadcrumbs'][] = ['label' => 'Bom Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Job Order</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <?= Html::a('<i class="fa-print"></i><span> Generate Job Order</span>', ['job-order', 'id' => $model->id], ['class' => 'btn btn-secondary btn-icon btn-icon-standalone', 'target' => 'blank']) ?>
                <ul class="nav nav-tabs nav-tabs-justified">
                    <li  class="active">
                        <?php
                        if ($model->status == 1) {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">BOM Details</span>', ['bom-master/update', 'id' => $model->id]);
                        } else {
                            echo '<a><span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">BOM Details</span></a>';
                        }
                        ?>

                    </li>
                    <li>
                        <?php
                        if ($model->status == 2) {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Production</span>', ['bom-master/production', 'id' => $model->id]);
                        } else {
                            echo '<a><span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Production</span></a>';
                        }
                        ?>

                    </li>

                </ul>
                <div class="panel-body">
                    <div class="bom-master-create">
                        <div class="bom-master-form form-inline">
                            <?= \common\components\AlertMessageWidget::widget() ?>
                            <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                                    <?= $form->field($model, 'bom_no')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                                </div>
                                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                                    <?php
                                    if ($model->date == '') {
                                        $model->date = date('d-M-Y');
                                    } else {
                                        $model->date = date("d-M-Y", strtotime($model->date));
                                    }
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
                            <h5 style="color: #313131;font-weight: 600;font-size: 15px;">BOM Details</h5>
                            <div id="p_scents">
                                <input type="hidden" id="bom_row_count" value="1"/>
                                <?php
                                if (!empty($model_bom)) {
                                    foreach ($model_bom as $bom) {
                                        ?>
                                        <div class="append-box">
                                            <div class="row box_row" id="box_row-1">
                                                <div class="col-md-3">
                                                    <div class="formrow">
                                                        <?php
                                                        $products = \common\models\FinishedProduct::find()->where(['status' => 1])->all();
                                                        ?>
                                                        <label class="control-label">Product Name</label>
                                                        <select class="form-control product_id" name="update[<?= $bom->id ?>][product]" id="product_id-<?= $bom->id ?>" required readonly>
                                                            <option value="">Select Product</option>
                                                            <?php
                                                            if (!empty($products)) {
                                                                foreach ($products as $product) {
                                                                    ?>
                                                                    <option value="<?= $product->id ?>" <?= $bom->product == $product->id ? 'selected' : '' ?>><?= $product->product_name ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
        <!--<input type="hidden" class="form-control product_qty" name="create[1][product]" placeholder="Product" id="product-1">-->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="formrow">
                                                        <label class="control-label">Quantity</label>
                                                        <input type="number"  min="1" autocomplete="off"  step="any" class="form-control product_qty" name="update[<?= $bom->id ?>][product_qty]" placeholder="Quantity" id="product_qty-1" value="<?= $bom->qty ?>" required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="formrow">
                                                        <label class="control-label">Product Comment</label>
                                                        <input type="text" class="form-control product_comment" name="update[<?= $bom->id ?>][product_comment]" placeholder="Product Comment" id="product_comment-1" value="<?= $bom->comment ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <!--                                                    <div class="formrow">
                                                                                                            <a class="btn btn-secondary box_btn" id="box_btn-1" style="display:none;">Add</a>
                                                                                                        </div>-->
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-12">
                                                    <div>Product Comment : <span id="exist_product_comment-<?= $bom->id ?>"> </span></div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="row table_row" id="table_row-<?= $bom->id ?>">
                                                <div id="bom-material-details-<?= $bom->id ?>" class="bom-material-details">
                                                    <?php
                                                    $material_details = \common\models\BomMaterialDetails::find()->where(['bom_id' => $bom->id])->all();
                                                    ?>
                                                    <input type="hidden" name="material_row_count" id="material_row_count" value="<?= count($material_details) ?>"/>
                                                    <table class="table table-1" id="add-materials">
                                                        <thead>
                                                            <tr style="border: none;">
                                                                <th>Material</th>
                                                                <th>Quantity</th>
                                                                <th>Unit</th>
                                                                <th>Comment</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($material_details)) {
                                                                $k = 0;
                                                                foreach ($material_details as $value) {
                                                                    $avail = 0;
                                                                    $avail_reserve = $value->quantity;
                                                                    $k++;
                                                                    $row_material = \common\models\SupplierwiseRowMaterial::findOne($value->material);
                                                                    $stock_view = common\models\StockView::find()->where(['material_id' => $row_material->id])->one();
                                                                    if (!empty($stock_view)) {
                                                                        $avail = $stock_view->available_qty;
                                                                    }
                                                                    ?>
                                                                    <tr style="border: none;">
                                                                        <td>
                                                                            <select id="invoice-material_id_1-<?= $k ?>" class="form-control" name="updatematerial[<?= $value->id ?>][material_id]" disabled>
                                                                                <option value="">Select Material</option>
                                                                                <?php foreach ($supplier_materials as $supplier_material) { ?>
                                                                                    <option value="<?= $row_material->id ?>" <?= $supplier_material->id == $row_material->id ? 'selected' : '' ?>><?= $supplier_material->item_name ?></option>
                                                                                <?php }
                                                                                ?>
                                                                            </select>
                                                                            <span>Comment : <?= $value->comment ?></span>
                                                                        </td>
                                                                        <td>
                                                                            <input id="material_qty_val_<?= $bom->id ?>-<?= $k ?>" type="hidden" autocomplete="off" class="form-control" name="updatematerial[<?= $value->id ?>][material_qty_val]" value="<?= $value->quantity ?>"placeholder="Material" required readonly>
                                                                            <input id="material_qty_<?= $bom->id ?>-<?= $k ?>" data-val="<?= $bom->id ?>" type="number"  max="<?= $avail + $avail_reserve ?>" autocomplete="off" class="form-control material_qty" name="updatematerial[<?= $value->id ?>][material_qty]" value="<?= $value->quantity ?>" placeholder="Qty" required>
                                                                            <span title="Available Quantity">AVL : <span id="material_avail_qty_<?= $bom->id ?>-<?= $k ?>"><?= $avail ?></span> </span><span title="Reserved Quantity" style="float:right">RES : <span id="material_reserve_qty_<?= $bom->id ?>-<?= $k ?>"><?= $avail_reserve ?></span></span>
                                                                        </td>
                                                                        <td>
                                                                            <span><?= $row_material->item_unit != '' ? \common\models\Unit::findOne($row_material->item_unit)->unit_name : '' ?></span>
                                                                        </td>
                                                                        <td>
                                                                            <input id="material_comment_<?= $bom->id ?>" type="text" autocomplete="off" class="form-control" name="updatematerial[<?= $value->id ?>][material_comment]" value="<?= $value->comment ?>" placeholder="Comment">
                                                                        </td>
                                                                        <td style="padding-top: 16px;"><a id="bom-del-<?= $value->id ?>" class="bom-del" style="border: 1px solid red;padding: 5px 10px;color: red;background: #ecc8c8;" ><i class="fa fa-times material-row-delete" title="Remove Row"></i></a></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <a href="" id="add_another_line"><i class="fa fa-plus" aria-hidden="true"></i> Add Another Material</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <!--    <div class="form-group field-portcalldatarob-fresh_water_arrival_quantity">
                                    <a id="addbomdetails" class="btn btn-icon btn-blue addScnt btn-larger btn-block" ><i class="fa fa-plus"></i> Add More</a>
                                </div>-->
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
                            </div>


                            <?php ActiveForm::end(); ?>
                            <?php
                            if ($model->status == 1) {
                                echo Html::a('<span> BOM Details Completed & Proceed to Production</span>', ['bom-master/bom-complete', 'id' => $model->id], ['class' => 'btn btn-secondary btn-right']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).on('change', '.product_id', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var item_id = $(this).val();
            var next_row_id = $('#material_row_count').val();
            if (next_row_id > 1) {
                for (i = 1; i <= next_row_id; i++) {
                    var item_val = $('#salesinvoicedetails-item_id-' + i).val();
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
                itemChange(item_id, current_row_id, next_row_id);
            } else {
                alert('This Item is already Choosed');
                $("#salesinvoicedetails-item_id-" + current_row_id).select2("val", "");
                e.preventDefault();
            }
            itemChange(item_id, current_row_id);
        });
        $(document).on('keyup mouseup', '.material_qty', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var array = $(this).attr('id').split("-");
            var row_id = array[array.length - 1];
            var qt_val = $(this).val();
            var material_availqty_val = parseInt($('#material_avail_qty_' + current_row_id + '-' + row_id).text());
            var material_reserve_val = parseInt($('#material_reserve_qty_' + current_row_id + '-' + row_id).text());
            if (parseInt(qt_val) <= (material_availqty_val + material_reserve_val)) {
                $('#material_qty_' + current_row_id + '-' + row_id).val(qt_val);
            } else {
                if (qt_val != '') {
                    alert('Quantity exeeds the available quantity');
                    $('#material_qty_' + current_row_id + '-' + row_id).val(material_availqty_val + material_reserve_val);
                } else {
                    $('#material_qty_' + current_row_id + '-' + row_id).val('');
                }
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
                    $('#add-materials tr:last').after(res.result['next_row_html']);
                    $("#material_row_count").val(res.result['next']);
                    e.preventDefault();
                }
            });
        });
        $(document).on('click', '#del', function (e) {
            var bid = this.id; // button ID
            var trid = $(this).closest('tr').attr('id'); // table row ID
            $(this).closest('tr').remove();
        });
        $(document).on('click', '.bom-del', function (e) {
            var material_id = $(this).attr('id').match(/\d+/); // 123456
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {material_id: material_id},
                url: homeUrl + 'bom/bom-master/remove-material-details',
                success: function (data) {
                    if (data == 1) {
                        $('#bom-del-' + material_id).closest('tr').remove();
                    }
                    e.preventDefault();
                }
            });
        });

        $(document).on('change', '.invoice-material_id', function (e) {
            var flag = 0;
            var count = 0;
            var idd = $(this).attr('id');
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var array = idd.split('-');
            var material_row_id = array[2];
            var row_count = $('#material_row_count').val();
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
                $("#product-" + current_row_id).val(item_id);
                $("#exist_product_comment-" + current_row_id).text(res.result['product_comment']);
                $("#box_btn-" + current_row_id).css('display', 'block');
                calculateQty(current_row_id);
            }
        });
        return true;
    }
</script>
