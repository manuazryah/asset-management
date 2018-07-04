<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductAdjustmentMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Adjustment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-adjustment-master-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> New Product Adjustment</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                                                            'id',
                            [
                                'attribute' => 'transaction',
                                'format' => 'raw',
                                'filter' => [0 => 'Opening', 1 => 'Addition', 2 => 'Deduction'],
                                'value' => function ($model) {
                                    if ($model->transaction == 0) {
                                        return 'Opening';
                                    } elseif ($model->transaction == 1) {
                                        return 'Addition';
                                    } elseif ($model->transaction == 2) {
                                        return 'Deduction';
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            'document_no',
                            'document_date',
//            'status',
                            // 'CB',
                            // 'UB',
                            // 'DOC',
                            // 'DOU',
                           ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


