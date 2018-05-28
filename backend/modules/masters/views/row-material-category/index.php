<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RowMaterialCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Row Material Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row-material-category-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?= Html::a('<i class="fa-th-list"></i><span> Create Row Material Category</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?= \common\components\AlertMessageWidget::widget() ?>
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
                                        $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/material_category/' . $data->id . '.' . $data->photo;
                                        if (file_exists($dirPath)) {
                                            $img = '<img width="100px" height="100px" src="' . Yii::$app->homeUrl . 'uploads/material_category/' . $data->id . '.' . $data->photo . '?' . rand() . '"/>';
                                        } else {
                                            $img = 'No Image';
                                        }
                                    } else {
                                        $img = 'No Image';
                                    }
                                    return $img;
                                },
                            ],
                            'category',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => [1 => 'Enabled', 0 => 'disabled'],
                                'value' => function ($model) {
                                    return $model->status == 1 ? 'Enabled' : 'disabled';
                                },
                            ],
                            [
                                'attribute' => 'comment',
                                 'filter' => '',
                                'value' => function ($model) {
                                    return $model->comment;
                                },
                            ],
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


