<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\BomMaster */

$this->title = 'Update Bom';
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
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Bom Master</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <ul class="nav nav-tabs nav-tabs-justified">
                    <li>
                        <?php
                        if ($model->status == 1) {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">BOM Details</span>', ['bom-master/update', 'id' => $model->id]);
                        } else {
                            echo '<a><span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">BOM Details</span></a>';
                        }
                        ?>

                    </li>
                    <li class="active">
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
                                    <?= $form->field($model, 'status')->dropDownList(['2' => 'Production']) ?>

                                </div>
                                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                                    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

                                </div>
                            </div>
                            <h5 style="color: #313131;font-weight: 600;">BOM Details</h5>
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
                                                        <input type="number"  min="1" autocomplete="off"  step="any" class="form-control product_qty" name="update[<?= $bom->id ?>][product_qty]" placeholder="Quantity" id="product_qty-1" value="<?= $bom->qty ?>" required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="formrow">
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
                                            <div class="row table_row" id="table_row-<?= $bom->id ?>">
                                                <div id="bom-material-details-<?= $bom->id ?>" class="bom-material-details">
                                                    <?php
                                                    $material_details = \common\models\BomMaterialDetails::find()->where(['bom_id' => $bom->id])->all();
                                                    ?>
                                                    <table class="table table-1">
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
                                                                    <td style="padding: 6px 0px;width: 50%;">
                                                                        <div class="col-md-8">
                                                                            <div class="formrow">
                                                                                <select class="form-control" name="updatematerial[<?= $value->id ?>][material_id]" disabled>
                                                                                    <option value="">Select Material</option>
                                                                                    <?php foreach ($supplier_materials as $supplier_material) { ?>
                                                                                        <option value="<?= $row_material->id ?>" <?= $supplier_material->id == $row_material->id ? 'selected' : '' ?>><?= $supplier_material->item_name ?></option>
                                                                                    <?php }
                                                                                    ?>
                                                                                </select>
                                                                                <span>Comment : <?= $value->comment ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="formrow">
                                                                                <input id="material_qty_val_<?= $bom->id ?>-<?= $k ?>" type="hidden" autocomplete="off" class="form-control" name="updatematerial[<?= $value->id ?>][material_qty_val]" value="<?= $value->quantity ?>"placeholder="Material" required readonly>
                                                                                <input id="material_qty_<?= $bom->id ?>-<?= $k ?>" data-val="<?= $bom->id ?>" type="number"  max="<?= $avail + $avail_reserve ?>" autocomplete="off" class="form-control material_qty" name="updatematerial[<?= $value->id ?>][material_qty]" value="<?= $value->quantity ?>" placeholder="Qty" required readonly>
                                                                                <span>Available Qty : <span id="material_avail_qty_<?= $bom->id ?>-<?= $k ?>"><?= $avail ?></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="padding: 6px 0px;">
                                                                        <input id="material_actual_qty_<?= $bom->id ?>-<?= $k ?>" data-val="<?= $bom->id ?>" type="number"  min="1" max="<?= $avail + $avail_reserve ?>" autocomplete="off" class="form-control material_actual_qty" name="updatematerial[<?= $value->id ?>][actual_qty]" value="<?= $value->quantity ?>" placeholder="Actual Qty" required>
                                                                    </td>
                                                                    <td style="padding: 12px 0px;">
                                                                        <span><?= $row_material->item_unit != '' ? \common\models\Unit::findOne($row_material->item_unit)->unit_name : '' ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="col-md-12">
                                                                            <div class="formrow">
                                                                                <input id="material_comment_<?= $bom->id ?>" type="text" autocomplete="off" class="form-control" name="updatematerial[<?= $value->id ?>][material_comment]" value=""placeholder="Comment">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                            $ware_houses = \common\models\Warehouse::find()->all();
                                            ?>
                                            <div class="row">
                                                <div class="col-md-4 right-div">
                                                    <select class="form-control" name="product_warehouse" required>
                                                        <option value="">Select Warehouse</option>
                                                        <?php
                                                        if(!empty($ware_houses)){
                                                            foreach ($ware_houses as $ware_house) { ?>
                                                                <option value="<?= $ware_house->id ?>"><?= $ware_house->warehouse_name ?></option>
                                                           <?php }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 right-div">
                                                    <input type="text" name="no_of_product" class="form-control" placeholder="Number of Product" required/>
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
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Complete Production', ['class' => 'btn btn-success']) ?>
                            </div>


                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).on('keyup mouseup', '.material_actual_qty', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var array = $(this).attr('id').split("-");
            var row_id = array[array.length - 1];
            var qt_val = $(this).val();
            var material_availqty_val = parseInt($('#material_avail_qty_' + current_row_id + '-' + row_id).text());
            var material_reserve_qty = parseInt($('#material_qty_' + current_row_id + '-' + row_id).val());
            var actual_avail = material_availqty_val + material_reserve_qty;
            if (parseInt(qt_val) <= actual_avail) {
                $('#material_actual_qty_' + current_row_id + '-' + row_id).val(qt_val);
            } else {
                if (qt_val != '') {
                    alert('Quantity exeeds the available quantity');
                    $('#material_actual_qty_' + current_row_id + '-' + row_id).val(actual_avail);
                } else {
                    $('#material_actual_qty_' + current_row_id + '-' + row_id).val(0);
                }
            }
        });
    });
</script>
