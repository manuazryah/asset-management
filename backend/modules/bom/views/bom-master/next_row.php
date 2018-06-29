<tr style="border: none;">
    <td>
        <select id="invoice-material_id_<?= $current_row_id ?>-<?= $next ?>" class="form-control invoice-material_id" name="creatematerial[<?= $current_row_id ?>][material_id][]" required>
            <option value="">Select Material</option>
            <?php foreach ($supplier_materials as $supplier_material) { ?>
                <option value="<?= $supplier_material->id ?>"><?= $supplier_material->item_name ?></option>
            <?php }
            ?>
        </select>
        <span id="material_comment_<?= $current_row_id ?>-<?= $next ?>">Comment : </span>
    </td>
    <td>
        <input id="material_qty_val_<?= $current_row_id ?>-<?= $next ?>" type="hidden" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_qty_val][]" value=""placeholder="Material" required readonly>
        <input id="material_qty_<?= $current_row_id ?>-<?= $next ?>" data-val="<?= $current_row_id ?>" type="number" min="1" max="0" autocomplete="off" class="form-control material_qty" name="creatematerial[<?= $current_row_id ?>][material_qty][]" value=""placeholder="Qty" required>
        <span title="Available Quantity">AVL : <span id="material_avail_qty_<?= $current_row_id ?>-<?= $next ?>"></span> </span><span title="Reserved Quantity" style="float:right">RES : <span id="material_reserve_qty_<?= $current_row_id ?>-<?= $next ?>"></span></span>
    </td>
    <td>
        <span id="material_unit_<?= $current_row_id ?>-<?= $next ?>"></span>
    </td>
    <td>
        <input id="material_comment_<?= $current_row_id ?>" type="text" autocomplete="off" class="form-control" name="creatematerial[<?= $current_row_id ?>][material_comment][]" value=""placeholder="Comment">
    </td>
    <td style="margin-top:6px;"><a id="del" style="border: 1px solid red;padding: 5px 10px;color: red;background: #ecc8c8;" ><i class="fa fa-times material-row-delete" title="Remove Row"></i></a></td>
</tr>

