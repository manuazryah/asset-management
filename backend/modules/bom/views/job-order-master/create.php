<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\JobOrderMaster */

$this->title = 'Create Job Order';
$this->params['breadcrumbs'][] = ['label' => 'Job Order Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                        </div>
                        <div class="panel-body">
                                <?=  Html::a('<i class="fa-th-list"></i><span> Manage Job Order</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                <div class="panel-body"><div class="job-order-master-create">
                                                <?= $this->render('_form', [
                                                'model' => $model,
                                                'model_details' => $model_details,
                                                ]) ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>
                
