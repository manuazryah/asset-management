<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ProductCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FinishedProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finished-product-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Add Product</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                                                            'id',
                            [
                                'attribute' => 'item_photo',
                                'filter' => '',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->item_photo != '') {
                                        $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/finished_product/' . $data->id . '.' . $data->item_photo;
                                        if (file_exists($dirPath)) {
                                            $img = '<img width="70px" height="70" src="' . Yii::$app->homeUrl . 'uploads/finished_product/' . $data->id . '.' . $data->item_photo . '?'.rand().'"/>';
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
                                'attribute' => 'product_category',
                                'value' => 'productCategory.product_category',
                                'filter' => ArrayHelper::map(ProductCategory::find()->asArray()->all(), 'id', 'product_category'),
                            ],
                            'product_name',
                            'product_code',
                            // 'reference',
                            // 'comment:ntext',
                            // 'status',
                            // 'CB',
                            // 'UB',
                            // 'DOC',
                            // 'DOU',
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{update}',
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


