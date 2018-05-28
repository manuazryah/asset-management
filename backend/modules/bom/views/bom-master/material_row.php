<table class="table table-<?= $current_row_id ?>">
    <?php
    var_dump($supplier_materials);exit;
    if (!empty($material_details)) {
        $k = 0;
        foreach ($material_details as $value) {
            $k++;
            $row_material = \common\models\SupplierwiseRowMaterial::findOne($value->row_material_id);
            ?>
            <tr style="border: none;">
                <td style="padding: 6px 0px;width: 50%;">
                    <div class="col-md-8">
                        <div class="formrow">
                            <select class="form-control" name="creatematerial[<?= $current_row_id ?>][material_id][]">
                                <option value="">Select Country</option>
                                <?php foreach ($supplier_materials as $supplier_material) { ?>
                                    <option value="<?= $row_material->id ?>" <?= $supplier_material->id == $row_material->id ? 'selected' : '' ?>><?= $row_material->item_name ?></option>
                                <?php }
                                ?>
                            </select>
                            <span>Comment : </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="formrow">
                            <input id="material_qty_val_<?= $current_row_id ?>-<?= $k ?>" type="hidden" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_qty_val][]" value="<?= $value->quantity ?>"placeholder="Material" required readonly>
                            <input id="material_qty_<?= $current_row_id ?>-<?= $k ?>" type="number" min="1" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_qty][]" value="<?= $value->quantity ?>"placeholder="Qty" required>
                            <span>Available Qty : </span>
                        </div>
                    </div>
                </td>
                <td style="padding: 12px 0px;">
                    <span><?= $value->unit != '' ? \common\models\Unit::findOne($value->unit)->unit_name : '' ?></span>
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
</table>