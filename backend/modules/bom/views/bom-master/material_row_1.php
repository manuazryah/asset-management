<div class="clearfix"></div>
<div class="row hr_line" style="    border-top: 2px solid #a09898;    margin: 15px 22px 15px 10px;"></div>
<table class="table table-<?= $current_row_id ?>" id="material-tables">
    <thead>
        <tr style="border: none;">
            <td style="padding: 6px 0px;width: 50%;">
                <div class="col-md-8">
                    Material
                </div>
                <div class="col-md-4">
                    Quantity
                </div>
            </td>
            <td style=""></td>
            <td style="padding: 12px 0px;">Comment</td>
        </tr>
    </thead>
    <?php
    if (!empty($material_details)) {
        $k = 0;
        foreach ($material_details as $value) {
            $avail = 0;
            $avail_reserve = 0;
            $k++;
            $row_material = \common\models\SupplierwiseRowMaterial::findOne($value->row_material_id);
            $stock_view = common\models\StockView::find()->where(['material_id' => $row_material->id])->one();
            if (!empty($stock_view)) {
                $avail = $stock_view->available_qty;
                if ($stock_view->reserved_qty != '') {
                    $avail_reserve = $stock_view->reserved_qty;
                }
            }
            ?>
            <tr style="border: none;">
                <td style="padding: 6px 0px;width: 50%;">
                    <div class="col-md-8">
                        <div class="formrow">
                            <select id="invoice-material_id_<?= $current_row_id ?>-<?= $k ?>" class="form-control invoice-material_id" name="creatematerial[<?= $current_row_id ?>][material_id][]" required>
                                <option value="">Select Material</option>
                                <?php foreach ($supplier_materials as $supplier_material) { ?>
                                    <option value="<?= $supplier_material->id ?>" <?= $supplier_material->id == $row_material->id ? ' selected' : '' ?>><?= $supplier_material->item_name ?></option>
                                <?php }
                                ?>
                            </select>
                            <span id="material_comment_<?= $current_row_id ?>-<?= $k ?>">Comment : <?= $row_material->comment ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="formrow">
                            <input id="material_qty_val_<?= $current_row_id ?>-<?= $k ?>" type="hidden" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_qty_val][]" value="<?= $value->quantity ?>"placeholder="Material" required readonly>
                            <input id="material_qty_<?= $current_row_id ?>-<?= $k ?>" data-val="<?= $current_row_id ?>" type="number" min="1" max="<?= $avail - $avail_reserve ?>" autocomplete="off" class="form-control material_qty" name="creatematerial[<?= $current_row_id ?>][material_qty][]" value="<?= $value->quantity ?>"placeholder="Qty" required>
                            <span title="Available Quantity">AVL : <span id="material_avail_qty_<?= $current_row_id ?>-<?= $k ?>"><?= $avail ?></span> </span><span title="Reserved Quantity" style="float:right">RES : <span id="material_reserve_qty_<?= $current_row_id ?>-<?= $k ?>"><?= $avail_reserve ?></span></span>
                        </div>
                    </div>
                </td>
                <td style="padding: 12px 0px;">
                    <span id="material_unit_<?= $current_row_id ?>-<?= $k ?>"><?= $value->unit != '' ? \common\models\Unit::findOne($value->unit)->unit_name : '' ?></span>
                </td>
                <td>
                    <div class="col-md-12">
                        <div class="formrow">
                            <input id="material_comment_<?= $current_row_id ?>" type="text" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_comment][]" value=""placeholder="Comment">
                        </div>
                    </div>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    <input type="hidden" id="material_cout_row-<?= $current_row_id ?>" value="<?= $k ?>"/>
</table>