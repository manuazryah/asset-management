<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\RowMaterialCategory;
use common\models\Unit;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RowMaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Row Materials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row-material-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?= \common\components\AlertMessageWidget::widget() ?>
                    <?= Html::a('<i class="fa-th-list"></i><span> Create Row Material</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                                                            'id',
                            [
                                'attribute' => 'photo',
                                'filter' => '',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->photo != '') {
                                        $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/row_material/' . $data->id . '.' . $data->photo;
                                        if (file_exists($dirPath)) {
                                            $img = '<img width="70px" height="70" src="' . Yii::$app->homeUrl . 'uploads/row_material/' . $data->id . '.' . $data->photo . '?' . rand() . '"/>';
                                        } else {
                                            $img = 'No Image';
                                        }
                                    } else {
                                        $img = 'No Image';
                                    }
                                    return $img;
                                },
                            ],
                            [
                                'attribute' => 'category',
                                'value' => 'category0.category',
                                'filter' => ArrayHelper::map(RowMaterialCategory::find()->asArray()->all(), 'id', 'category'),
                            ],
                            'item_code',
                            'item_name',
                            [
                                'attribute' => 'item_unit',
                                'value' => 'itemUnit.unit_name',
                                'filter' => ArrayHelper::map(Unit::find()->asArray()->all(), 'id', 'unit_name'),
                            ],
                            // 'photo',
                            // 'reference',
                            // 'description:ntext',
                            // 'status',
                            // 'CB',
                            // 'UB',
                            // 'DOC',
                            // 'DOU',
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{update}{delete}',
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


