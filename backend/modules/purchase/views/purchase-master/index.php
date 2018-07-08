<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Supplier;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PurchaseMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-master-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> New Purchase</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                                                            'id',
                            [
                                'attribute' => 'date',
                                'value' => function ($data) {
                                    return date("Y-m-d", strtotime($data->date));
                                },
                                'headerOptions' => [
                                    'class' => 'col-md-2'
                                ],
                                'filter' => DateRangePicker::widget(['model' => $searchModel, 'attribute' => 'date', 'pluginOptions' => ['format' => 'd-m-Y', 'autoUpdateInput' => false]]),
                            ],
                            'invoice_no',
                                [
                                'attribute' => 'supplier',
                                'value' => 'supplier0.company_name',
                                'filter' => ArrayHelper::map(Supplier::find()->asArray()->all(), 'id', 'company_name'),
                            ],
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


