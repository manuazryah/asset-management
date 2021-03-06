<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductStockView */

$this->title = 'Update Product Stock View: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Stock Views', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


            </div>
            <div class="panel-body">
                        <?=  Html::a('<i class="fa-th-list"></i><span> Manage Product Stock View</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body"><div class="product-stock-view-create">
<?= $this->render('_form', [
                        'model' => $model,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
