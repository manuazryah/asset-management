<div class="append-box">
    <a class="ibtnDel remove"><i class="fa fa-close"></i></a>
    <div class="row">
        <div class="col-md-6">
            <div class="formrow">
                <select class="form-control product_id" name="create[product][]" id="product_id-<?= $j ?>" required>
                    <option value="">Select Product</option>
                    <?php
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            ?>
                            <option value="<?= $product->id ?>"><?= $product->product_name ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow">
                <input type="number" min="1" autocomplete="off"  step="any" class="form-control product_qty" name="create[product_qty][]" placeholder="Quantity" id="product_qty-<?= $j ?>" required>
            </div>
        </div>
        <div id="bom-material-details-<?= $j ?>" class="bom-material-details">

        </div>
    </div>
</div>