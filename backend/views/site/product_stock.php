<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\FinishedProduct;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StockViewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Material Stock';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="login-box">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 shadow">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'product_id',
                            'label' => 'Product Name',
                            'value' => 'product.product_name',
                            'filter' => ArrayHelper::map(FinishedProduct::find()->asArray()->all(), 'id', 'product_name'),
                        ],
                        [
                            'attribute' => 'available_qty',
                            'filter' => false,
                        ],
                    ],
                ]);
                ?>

            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

</section>
