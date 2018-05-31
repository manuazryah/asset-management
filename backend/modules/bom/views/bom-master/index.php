<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BomMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BOM';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bom-master-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?= \common\components\AlertMessageWidget::widget() ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Bom</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'bom_no',
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
                            'comment',
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

