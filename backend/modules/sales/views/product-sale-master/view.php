<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSaleMaster */

$this->title = $model->invoice_no;
$this->params['breadcrumbs'][] = ['label' => 'Product Sale Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Sale</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body">
                    <div class="product-sale-master-view">
                        <?php if (!empty($model)) { ?>
                            <table class="table table-borderless purchase-view-head">
                                <tr>
                                    <th>Invoice Date</th>
                                    <th>:</th>
                                    <th><?= date("d-M-Y", strtotime($model->date)) ?></th>
                                    <th>Invoice No</th>
                                    <th>:</th>
                                    <th><?= $model->invoice_no ?></th>
                                </tr>
                            </table>
                        <?php }
                        ?>
                         <?php if (!empty($model_details)) { ?>
                            <table class="table table-borderless purchase-view-details">
                                <tr>
                                    <th>SNo.</th>
                                    <th>Material</th>
                                    <th class="flt-right">Quantity</th>
                                    <th class="flt-right">Unit</th>
                                </tr>
                                <?php
                                $i = 0;
                                foreach ($model_details as $value) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $value->material != '' ? \common\models\SupplierwiseRowMaterial::findOne($value->material)->item_name : '' ?></td>
                                        <td class="flt-right"><?= $value->quantity ?></td>
                                        <td class="flt-right"><?= $value->unit != ''? \common\models\Unit::findOne($value->unit)->unit_name:'' ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


