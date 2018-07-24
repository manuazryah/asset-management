<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JobOrderMaster */

$this->title = $model->bom_no;
$this->params['breadcrumbs'][] = ['label' => 'Job Order Masters', 'url' => ['index']];
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
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Job Order</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body">
                    <div class="job-order-master-view">
                        <table class="table table-responsive tb1">
                            <tr>
                                <th>BOM No</th>
                                <th>:</th>
                                <th><?= $model->bom_no ?></th>
                                <th>BOM Date</th>
                                <th>:</th>
                                <th><?= date("d-M-Y", strtotime($model->bom_date)); ?></th>
                            </tr>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <h5 class="bom-title">BOM Details</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Printed Bottle</th>
                                <th>Quantity</th>
                                <th>Comment</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><?= $bom_detail->named_bottle != '' ? \common\models\SupplierwiseRowMaterial::findOne($bom_detail->named_bottle)->item_name : '' ?></td>
                                <td><?= $bom_detail->quantity ?></td>
                                <td><?= $bom_detail->comment ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <caption><span class="bom-span">BOM material Details</span></caption>
                        </thead>

                        <tbody>
                            <tr>
                                <th>Clear Bottle</th>
                                <th>Quantity</th>
                                <th>Damaged</th>
                                <th>Comment</th>
                            </tr>
                            <tr>
                                <td><?= $bom_detail->bottle != '' ? \common\models\SupplierwiseRowMaterial::findOne($bom_detail->bottle)->item_name : '' ?></td>
                                <td><?= $bom_detail->qty ?></td>
                                <td><?= $bom_detail->damaged ?></td>
                                <td><?= $bom_detail->comment ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


