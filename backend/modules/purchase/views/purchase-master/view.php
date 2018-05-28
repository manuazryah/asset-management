<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseMaster */

$this->title = $model->invoice_no;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Purchase Master</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body">
                    <div class="purchase-master-view">
                        <?php if (!empty($model)) { ?>
                            <table class="table table-borderless purchase-view-head">
                                <tr>
                                    <th>Invoice Date</th>
                                    <th>:</th>
                                    <th><?= date("d-M-Y", strtotime($model->date)) ?></th>
                                    <th>Invoice No</th>
                                    <th>:</th>
                                    <th><?= $model->invoice_no ?></th>
                                    <th>Supplier</th>
                                    <th>:</th>
                                    <th><?= $model->supplier != '' ? common\models\Supplier::findOne($model->supplier)->company_name : '' ?></th>
                                </tr>
                            </table>
                        <?php }
                        ?>
                        <?php if (!empty($model_details)) { ?>
                            <table class="table table-borderless purchase-view-details">
                                <tr>
                                    <th>SNo.</th>
                                    <th>Material</th>
                                    <th>Warehouse</th>
                                    <th>Shelf</th>
                                    <th class="flt-right">Quantity</th>
                                    <th class="flt-right">Price</th>
                                    <th class="flt-right">Total</th>
                                </tr>
                                <?php
                                $i = 0;
                                $qty_tot = 0;
                                $price_tot = 0;
                                $amount_tot = 0;
                                foreach ($model_details as $value) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $value->material != '' ? \common\models\SupplierwiseRowMaterial::findOne($value->material)->item_name : '' ?></td>
                                        <td><?= $value->warehouse != '' ? \common\models\Warehouse::findOne($value->warehouse)->warehouse_name : '' ?></td>
                                        <td><?= $value->shelf != '' ? \common\models\ShelfDetails::findOne($value->shelf)->shelf_name : '' ?></td>
                                        <td class="flt-right"><?= $value->qty ?></td>
                                        <td class="flt-right"><?= $value->price ?></td>
                                        <td class="flt-right"><?= $value->total ?></td>
                                    </tr>
                                    <?php
                                    $qty_tot += $value->qty;
                                    $price_tot += $value->price;
                                    $amount_tot += $value->total;
                                }
                                ?>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th class="flt-right"><?= $qty_tot ?></th>
                                    <th class="flt-right"><?= sprintf('%0.3f', $price_tot); ?></th>
                                    <th class="flt-right"><?= sprintf('%0.3f', $amount_tot); ?></th>
                                </tr>
                            </table>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


