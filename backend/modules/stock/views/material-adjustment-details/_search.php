<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MaterialAdjustmentDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="material-adjustment-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'master_id') ?>

    <?= $form->field($model, 'material_id') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'warehouse') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'CB') ?>

    <?php // echo $form->field($model, 'UB') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <?php // echo $form->field($model, 'DOU') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
