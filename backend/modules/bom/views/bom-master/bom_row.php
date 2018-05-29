<div class="append-box">
    <a class="ibtnDel remove"><i class="fa fa-close"></i></a>
    <div class="row box_row" id="box_row-<?= $j ?>">
        <div class="col-md-3">
            <div class="formrow">
                <select class="form-control product_id" name="create[<?= $j ?>][product]" id="product_id-<?= $j ?>" required>
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
                <input type="hidden" class="form-control product_qty" name="create[<?= $j ?>][product]" placeholder="Product" id="product-<?= $j ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="formrow">
                <input type="number" min="1" autocomplete="off"  step="any" class="form-control product_qty" name="create[<?= $j ?>][product_qty]" placeholder="Quantity" id="product_qty-<?= $j ?>" required>
            </div>
        </div>
        <div class="col-md-5">
                    <div class="formrow">
                        <input type="text" class="form-control product_comment" name="create[<?= $j ?>][product_comment]" placeholder="Product Comment" id="product_comment-<?= $j ?>">
                    </div>
                </div>
        <div class="col-md-1">
                    <div class="formrow">
                        <a class="btn btn-secondary box_btn" id="box_btn-<?= $j ?>" style="display:none;">Add</a>
                    </div>
                </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
           <div>Product Comment : <span id="exist_product_comment-<?= $j ?>"> </span></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row table_row" id="table_row-<?= $j ?>">
        <div id="bom-material-details-<?= $j ?>" class="bom-material-details">

        </div>
    </div>
</div>