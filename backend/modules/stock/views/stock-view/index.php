<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\SupplierwiseRowMaterial;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StockViewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Views';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-view-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'material_id',
                                'label' => 'Item Name',
                                'value' => 'material.item_name',
                                'filter' => ArrayHelper::map(SupplierwiseRowMaterial::find()->asArray()->all(), 'id', 'item_name'),
                            ],
                            'available_qty',
//            'status',
//            'CB',
                        // 'UB',
                        // 'DOC',
                        // 'DOU',
//                                                ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


