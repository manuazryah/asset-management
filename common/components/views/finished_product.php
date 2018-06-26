<?php

use yii\helpers\Html;
use common\models\ProductCategory;
USE common\models\Fragrance;
use common\models\Brand;
use common\models\Unit;
?>
<style>
    .appoint{
        width: 100%;
        border: 1px solid #d4d4d4;
        margin-bottom: 25px;
    }
    .appoint .value{
        font-weight: bold;
        text-align: left;
    }
    .appoint .labell{
        text-align: left;
    }
    .appoint .colen{

    }
    .appoint td{
        padding: 10px;
    }
</style>
<table class="appoint">
    <tr>
        <td class="labell">PRODUCT CATEGORY </td><td class="value">: <?= ProductCategory::findOne($product->product_category)->product_category; ?> </td>
        <td class="labell">PRODUCT NAME </td><td class="value">: <?= $product->product_name ?></td>
        <td class="labell">PRODUCT CODE </td><td class="value">: <?= $product->product_code; ?> </td>
    </tr>
    <tr>
        <td class="labell">SIZE </td><td class="value">: <?= $product->size ?></td>
        <td class="labell">PRICE </td><td class="value">: <?= $product->price ?></td>
        <td class="labell">ITEM PHOTO </td><td class="value">
            <?php
            if ($product->item_photo != '') {
                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/finished_product/' . $product->id . '.' . $product->item_photo;
                if (file_exists($dirPath)) {
                    echo '<img width="50" class="img-responsive" src="' . Yii::$app->homeUrl . 'uploads/finished_product/' . $product->id . '.' . $product->item_photo . '"/>';
                } else {
                    echo '';
                }
            }
            ?>
        </td>

    </tr>

</table>

