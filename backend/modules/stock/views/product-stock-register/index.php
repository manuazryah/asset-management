<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\FinishedProduct;
use common\models\Warehouse;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductStockRegisterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Stock Registers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-stock-register-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                            [
                                'attribute' => 'product_id',
                                'label' => 'Product Name',
                                'value' => 'product.product_name',
                                'filter' => ArrayHelper::map(FinishedProduct::find()->asArray()->all(), 'id', 'product_name'),
                            ],
                            'stock_in',
                            'stock_out',
                                [
                                'attribute' => 'warehouse',
                                'value' => 'warehouse0.warehouse_name',
                                'filter' => ArrayHelper::map(Warehouse::find()->asArray()->all(), 'id', 'warehouse_name'),
                            ],
                        // 'unit',
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


