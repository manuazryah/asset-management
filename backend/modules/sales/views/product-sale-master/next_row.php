<tr class="filter" id="item-row-<?= $next ?>">
    <td>
        <div class="form-group field-stockadjdtl-item_code has-success">
            <select id="productsale_id-<?= $next ?>" class="form-control product_id" name="ProductSaleDetailsMaterial[<?= $next ?>]" aria-invalid="false">
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
            <input type="number" id="productsale_qty-<?= $next ?>" class="form-control productsale_qty" name="ProductSaleDetailsQty[<?= $next ?>]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off">
            <div class="help-block"></div>
        </div>
        <div class="stock-check" id="stock-check-<?= $next ?>" style="display:none;">
            <p style="font-size: 10px;font-weight: bold;color: #ef6262;">Stock :<span class="stock-exist" id="stock-exist-<?= $next ?>"></span></p>
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" id="productsale_unit-<?= $next ?>" class="form-control productsale_unit" name="ProductSaleDetailsUnit[<?= $next ?>]" aria-invalid="false" readonly>
            <div class="help-block"></div>
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" id="productsale_comment-<?= $next ?>" class="form-control productsale_comment" name="ProductSaleDetailsComment[<?= $next ?>]" aria-invalid="false">
            <div class="help-block"></div>
        </div>
    </td>
    <td>
        <a id="del" class="" ><i class="fa fa-times sales-invoice-delete"></i></a>
    </td>
</tr>