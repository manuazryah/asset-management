<tr class="filter" id="item-row-<?= $next ?>">
    <td>
        <select id="invoice-item_id-<?= $next ?>" class="form-control invoice-item_id" name="create[item_id][<?= $next ?>]" required>
            <option value="">-Choose a Item-</option>
            <?php
            foreach ($item_datas as $item_data) {
                $ref = $item_data->reference != '' ? ' (' . $item_data->reference . ')' : '';
                ?>
                <option value="<?= $item_data->id ?>"><?= $item_data->item_name ?> - <?= common\models\RowMaterialCategory::findOne($item_data->material_ctegory)->category ?><?= $ref ?></option>
            <?php }
            ?>
        </select>
    </td>
    <td>
        <input style="width: 70% !important" type="number" id="invoice-qty-<?= $next ?>" value="" class="form-control invoice-qty" name="create[qty][<?= $next ?>]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off"  step="any" required>
        <span id="invoice-unit-<?= $next ?>"></span>
    </td>
    <td>
        <input type="text" id="invoice-price-<?= $next ?>" value="" class="form-control invoice-price flt-right" name="create[price][<?= $next ?>]" placeholder="Price" aria-invalid="false" autocomplete="off" required>
    </td>
    <td>
        <input type="text" id="invoice-total-<?= $next ?>" value="" class="form-control invoice-total flt-right" name="create[total][<?= $next ?>]" placeholder="Total" aria-invalid="false" autocomplete="off" required>
    </td>
    <td>
        <?php
        $default_warehouse = common\models\Warehouse::find()->where(['set_as_default' => 1])->one();
        if (!empty($default_warehouse)) {
            $default = $default_warehouse->id;
        } else {
            $default = '';
        }
        ?>
        <select id="invoice-warehouse-<?= $next ?>" class="form-control invoice-warehouse" name="create[warehouse][<?= $next ?>]" required>
            <option value="">-Choose a warehouse-</option>
            <?php
            foreach ($warehouse_datas as $warehouse_data) {
                if ($warehouse_data->id == $default) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
                ?>
                <option value="<?= $warehouse_data->id ?>" <?= $select ?>><?= $warehouse_data->warehouse_name ?></option>
            <?php }
            ?>
        </select>
    </td>
    <td>
        <a id="del" class="" ><i class="fa fa-times invoice-delete" title="Remove Row"></i></a>
    </td>
</tr>