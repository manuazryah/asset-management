<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\SupplierwiseRowMaterial;
use common\models\Warehouse;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StockRegisterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Registers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-register-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php //  Html::a('<i class="fa-th-list"></i><span> Create Stock Register</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                            'id',
//                            'document_line_id',
                            [
                                'attribute' => 'type',
                                'format' => 'raw',
                                'filter' => [1 => 'Purchase', 2 => 'BOM'],
                                'value' => function ($model) {
                                    if ($model->type == 1) {
                                        return 'Purchase';
                                    } elseif ($model->type == 2) {
                                        return 'BOM';
                                    } elseif ($model->type == 3) {
                                        return 'Opening Stock';
                                    }elseif ($model->type == 4) {
                                        return 'Addition';
                                    }elseif ($model->type == 5) {
                                        return 'Deduction';
                                    }else {
                                        return '';
                                    }
                                },
                            ],
                            'invoice_no',
                            'invoice_date',
                                [
                                'attribute' => 'item_id',
                                'label' => 'Item Name',
                                'value' => 'item.item_name',
                                'filter' => ArrayHelper::map(SupplierwiseRowMaterial::find()->asArray()->all(), 'id', 'item_name'),
                            ],
                            // 'item_code',
                            // 'item_name',
                            [
                                'attribute' => 'warehouse',
                                'value' => 'warehouse0.warehouse_name',
                                'filter' => ArrayHelper::map(Warehouse::find()->asArray()->all(), 'id', 'warehouse_name'),
                            ],
                            // 'item_cost',
                            [
                                'attribute' => 'weight_in',
                                'value' => function ($model) {
                                    return $model->weight_in != '' ? $model->weight_in : '';
                                },
                            ],
                                [
                                'attribute' => 'weight_out',
                                'value' => function ($model) {
                                    return $model->weight_out != '' ? $model->weight_out : '';
                                },
                            ],
                        // 'balance_qty',
                        // 'status',
                        // 'CB',
                        // 'UB',
                        // 'DOC',
                        // 'DOU',
//                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


