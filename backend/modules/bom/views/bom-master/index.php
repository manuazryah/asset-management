<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BomMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Order(BOM) List';
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

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Job Order</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
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
                                [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => [1 => 'Pending', 2 => 'Production', 3 => 'Completed'],
                                'value' => function ($model) {
                                    if ($model->status == 1) {
                                        return 'Pending';
                                    } elseif ($model->status == 2) {
                                        return 'Production';
                                    } elseif ($model->status == 3) {
                                        return 'Completed';
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            'comment',
                                ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}{update}{joborder}',
                                'contentOptions' => ['style' => 'width:100px;'],
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        if ($model->status != 3) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                        'title' => Yii::t('app', 'update'),
                                                        'class' => '',
                                            ]);
                                        }
                                    },
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                                    'title' => Yii::t('app', 'delete'),
                                                    'class' => '',
                                        ]);
                                    },
                                    'joborder' => function ($url, $model) {
                                        return Html::a('<span class="fa fa-print"></span>', $url, [
                                                    'title' => Yii::t('app', 'Generate Job Order'),
                                                    'target' => '_blank',
                                        ]);
                                    },
                                ],
                                'urlCreator' => function ($action, $model) {
                                    if ($action === 'update') {
                                        if ($model->status == 2) {
                                            $url = Url::to(['production', 'id' => $model->id]);
                                        } elseif ($model->status == 1) {
                                            $url = Url::to(['update', 'id' => $model->id]);
                                        } else {
                                            $url = '';
                                        }
                                        return $url;
                                    }
                                    if ($action === 'view') {
                                        $url = Url::to(['view', 'id' => $model->id]);
                                        return $url;
                                    }
                                    if ($action === 'joborder') {
                                        $url = Url::to(['job-order', 'id' => $model->id]);
                                        return $url;
                                    }
                                }],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


