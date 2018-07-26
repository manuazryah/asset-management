<div class="clearfix"></div>
<table class="table table-<?= $current_row_id ?>" id="add-materials">
    <thead>
        <tr style="border: none;">
            <th>Material</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
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
                    <td style="width:50%;">
                        <select id="invoice-material_id_<?= $current_row_id ?>-<?= $k ?>" class="form-control invoice-material_id" name="creatematerial[<?= $current_row_id ?>][material_id][]" required>
                            <option value="">Select Material</option>
                            <?php foreach ($supplier_materials as $supplier_material) { ?>
                                <option value="<?= $supplier_material->id ?>" <?= $supplier_material->id == $row_material->id ? ' selected' : '' ?>><?= $supplier_material->item_name ?></option>
                            <?php }
                            ?>
                        </select>
                        <span style="margin-left: 10px;font-size: 12px;" title="Available Quantity">AVL : <span id="material_avail_qty_<?= $current_row_id ?>-<?= $k ?>"><?= $avail ?></span> </span><br>
                        <span style="margin-left: 10px;font-size: 9px;color: red;" title="Requested Quantity" style="color:red;font-size: 10px;text-transform: lowercase;" id="material_requested_qty_<?= $current_row_id ?>-<?= $k ?>"></span>
                    </td>
                    <td style="width:50%;">
                        <input id="material_qty_val_<?= $current_row_id ?>-<?= $k ?>" type="hidden" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_qty_val][]" value="<?= $value->quantity ?>"placeholder="Material" required readonly>
                        <input id="material_qty_<?= $current_row_id ?>-<?= $k ?>" data-val="<?= $current_row_id ?>" type="number" min="1" max="<?= $avail - $avail_reserve ?>" autocomplete="off" class="form-control material_qty" name="creatematerial[<?= $current_row_id ?>][material_qty][]" value="<?= $value->quantity ?>"placeholder="Qty" required>
                        <span style="margin-left: 2px;font-size: 12px;" title="Reserved Quantity">RES : <span id="material_reserve_qty_<?= $current_row_id ?>-<?= $k ?>"><?= $avail_reserve ?></span></span><br>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
    <input type="hidden" id="material_cout_row-<?= $current_row_id ?>" value="<?= $k ?>"/>
</table>