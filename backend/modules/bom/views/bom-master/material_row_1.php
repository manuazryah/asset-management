<?php
if (!empty($material_details)) {
    foreach ($material_details as $value) {
        $row_material = \common\models\SupplierwiseRowMaterial::findOne($value->row_material_id);
        ?>
        <div class="col-md-6">
            <div class="formrow">
                <input type="hidden" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_id][]" value="<?= $row_material->id ?>" placeholder="Material">
                <input type="text" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_name][]" value="<?= $row_material->item_name ?>" placeholder="Material" required readonly>
            </div>
        </div>
        <div class="col-md-">
            <div class="formrow">
                <input type="text" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_qty][]" value="<?= $value->quantity ?>"placeholder="Material" required readonly>
            </div>
        </div>
    <?php
    }
}
?>