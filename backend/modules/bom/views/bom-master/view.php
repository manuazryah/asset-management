<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BomMaster */

$this->title = $model->bom_no;
$this->params['breadcrumbs'][] = ['label' => 'Bom Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .tb1{
        border: none;
        background: #edf8f5;
        border-radius: 5px;
    }
    .tb1 tr{
        border: none !important;
    }
    .bom-detai-tbl {
        border-collapse: collapse;
    }
    .bom-span{
        color: #017101;
        font-weight: 600;
    }
    .bom-title{
        color: #0d5980;
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Bom Master</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body">
                    <div class="bom-master-view">
                        <table class="table table-responsive tb1">
                            <tr>
                                <th>BOM No</th>
                                <th>:</th>
                                <th><?= $model->bom_no ?></th>
                                <th>BOM Date</th>
                                <th>:</th>
                                <th><?= date("d-M-Y", strtotime($model->date)); ?></th>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <th>:</th>
                                <th>
                                    <?php
                                    if ($model->status == 1) {
                                        echo 'Pending';
                                    } elseif ($model->status == 2) {
                                        echo 'Start Production';
                                    } elseif ($model->status == 3) {
                                        echo 'Production Completed';
                                    }
                                    ?>
                                </th>
                                <th>Comment</th>
                                <th>:</th>
                                <th><?= $model->comment ?></th>
                            </tr>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <h5 class="bom-title">BOM Details</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Comment</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (!empty($bom_details)) {
                                foreach ($bom_details as $bom_detail) {
                                    $material_details = \common\models\BomMaterialDetails::find()->where(['bom_id' => $bom_detail->id])->all();
                                    ?>
                                    <tr>
                                        <td><?= $bom_detail->product ?></td>
                                        <td><?= $bom_detail->qty ?></td>
                                        <td><?= $bom_detail->comment ?></td>
                                    </tr>
                                    <?php if (!empty($material_details)) { ?>
                                        <tr>
                                            <td colspan="3"><span class="bom-span">BOM material Details</span></td>
                                        </tr>
                                        <tr>
                                            <th>Material</th>
                                            <th>Quantity</th>
                                            <th>Comment</th>
                                        </tr>
                                        <?php foreach ($material_details as $material_detail) { ?>
                                            <tr>
                                                <td><?= $material_detail->material ?></td>
                                                <td><?= $material_detail->quantity ?></td>
                                                <td><?= $material_detail->comment ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>


