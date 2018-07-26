<?php

use yii\helpers\Html;
use kartik\grid\GridView;
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
                    <?php
                    $gridColumns = [
                        ['class' => 'kartik\grid\SerialColumn'],
                        [
                            'attribute' => 'material_id',
                            'label' => 'Item Name',
                            'value' => 'material.item_name',
                            'filter' => ArrayHelper::map(SupplierwiseRowMaterial::find()->asArray()->all(), 'id', 'item_name'),
                        ],
                        [
                            'attribute' => 'material_category',
                            'format' => 'raw',
                            'value' => function($data, $key, $index, $column) {
                                return $data->getMaterialCategory($data->material_id);
                            },
                            'filter' => ArrayHelper::map(\common\models\RowMaterialCategory::find()->asArray()->all(), 'id', 'category'),
                        ],
                        'available_qty',
                        'reserved_qty',
                        [
                            'attribute' => 'image',
                            'filter' => '',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if ($data->material_id != '') {
                                    $item = SupplierwiseRowMaterial::find()->where(['id'=>$data->material_id])->one();
                                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/supplierwise_material/' . $item->id . '.' . $item->photo;
                                    if (file_exists($dirPath)) {
                                        $img = '<img width="70px" height="70" src="' . Yii::$app->homeUrl . 'uploads/supplierwise_material/' . $item->id . '.' . $item->photo . '?' . rand() . '"/>';
                                    } else {
                                        $img = 'No Image';
                                    }
                                } else {
                                    $img = 'No Image';
                                }
                                return $img;
                            },
                        ],
                    ];
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $gridColumns,
                        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                        'toolbar' => [
                            '{export}',
                            '{toggleData}'
                        ],
//                        'pjax' => true,
                        'bordered' => true,
                        'striped' => false,
                        'condensed' => false,
                        'responsive' => true,
                        'hover' => true,
                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
//                        'showPageSummary' => true,
                        'panel' => [
                            'type' => GridView::TYPE_PRIMARY
                        ],
                        'caption' => 'Stock Report'
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


