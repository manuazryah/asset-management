<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MaterialAdjustmentMaster */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Material Adjustment Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Purchase</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body">
                    <div class="purchase-master-view">
                        <?php if (!empty($model)) { ?>
                            <table class="table table-borderless purchase-view-head">
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>:</th>
                                    <th><?= date("d-M-Y", strtotime($model->date)) ?></th>
                                    <th>Transaction No</th>
                                    <th>:</th>
                                    <th><?= $model->invoice_no ?></th>
                                    <th>Transaction</th>
                                    <th>:</th>
                                    <th>
                                        <?php
                                        if ($model->transaction == 0) {
                                            echo 'Opening';
                                        } elseif ($model->transaction == 1) {
                                            echo 'Addition';
                                        } elseif ($model->transaction == 2) {
                                            echo 'Deduction';
                                        } else {
                                            echo '';
                                        }
                                        ?>
                                    </th>
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
                                    <th colspan="3">Total</th>
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


