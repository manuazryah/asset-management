<div id="print">
    <style>
        @page {
            size: A4;
        }
        .main-tbl{
            width: 100%;
        }
        .header h2{
            text-align: center;
        }
        .order-head{
            width: 100%;
        }
        .material-table{
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .material-table th{
            border: 1px solid black;
            text-align: left;
            padding: 5px 10px;
        }
        .material-table td{
            border: 1px solid black;
            padding: 5px 10px;
        }
        .material-details{
            margin: 20px 0px;
            /*min-height: 200px;*/
        }
        .flt-left{
            float: left;
        }
        .product-box{
            border: 1px solid black;
            min-width: 100px;
            min-height: 25px;
            margin-left: 20px;
        }
        .finished-pro-qty span{
            font-size: 20px;
        }
        .finished-pro-qty{
            margin: 15px 0px;
        }
        .signature{
            margin: 15px 0px;
        }
        .signature table{
            width: 100%;
        }
    </style>
    <table class="main-tbl">
        <thead>
            <tr>
                <th>
                    <div class="header">
                        <h2>JOB Order</h2>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="content">
                    <table class="order-head">
                        <tr>
                            <td>BOM No</td>
                            <td>:</td>
                            <td><?= $model->bom_no ?></td>
                            <td>Date</td>
                            <td>:</td>
                            <td><?= $model->date ?></td>
                        </tr>
                        <tr>
                            <td>Product Name</td>
                            <td>:</td>
                            <td><?= $model_bom->product != '' ? \common\models\FinishedProduct::findOne($model_bom->product)->product_name : '' ?></td>
                            <td>Quantity</td>
                            <td>:</td>
                            <td><?= $model_bom->qty ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="material-details">
                        <table class="material-table">
                            <tr>
                                <th>Material</th>
                                <th>Quantity Required</th>
                                <th>Actual Quantity</th>
                            </tr>
                            <?php
                            if (!empty($model_bom_material)) {
                                foreach ($model_bom_material as $bom_material) {
                                    if (!empty($bom_material)) {
                                        ?>
                                        <tr>
                                            <td><?= $bom_material->material != ''? \common\models\SupplierwiseRowMaterial::findOne($bom_material->material)->item_name :'' ?></td>
                                            <td><?= $bom_material->quantity ?></td>
                                            <td><?= $bom_material->actual_qty ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="finished-pro-qty">
                        <div style="float: right;">
                            <div class="flt-left"><span>Finished Product Qty</span></div>
                            <div class="flt-left product-box"></div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="signature">
                        <table>
                            <tr>
                                <th>Operations Signature</th>
                                <th>Faculty Manager Signature</th>
                                <th>Comment</th>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
<div class="print" style="text-align: center;">
        <button onclick="printContent('print')" style="font-weight: bold !important;">Print</button>
        <button onclick="window.close();" style="font-weight: bold !important;">Close</button>
    </div>