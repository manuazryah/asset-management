<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\JobOrderMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Order (Bottle) List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-order-master-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                    <?= \common\components\AlertMessageWidget::widget() ?>
                    <?= Html::a('<i class="fa-th-list"></i><span> New Job Order</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                                                            'id',
                            'bom_no',
                            [
                                'attribute' => 'bom_date',
                                'value' => function ($data) {
                                    return date("Y-m-d", strtotime($data->bom_date));
                                },
                                'headerOptions' => [
                                    'class' => 'col-md-2'
                                ],
                                'filter' => DateRangePicker::widget(['model' => $searchModel, 'attribute' => 'bom_date', 'pluginOptions' => ['format' => 'd-m-Y', 'autoUpdateInput' => false]]),
                            ],
//            'comment',
//            'status',
                            // 'CB',
                            // 'UB',
                            // 'DOC',
                            // 'DOU',
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                                'contentOptions' => ['style' => 'width:100px;'],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


