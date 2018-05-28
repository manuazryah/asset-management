<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StockRegisterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-register-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'document_line_id') ?>

    <?= $form->field($model, 'invoice_no') ?>

    <?= $form->field($model, 'invoice_date') ?>

    <?php // echo $form->field($model, 'item_id') ?>

    <?php // echo $form->field($model, 'item_code') ?>

    <?php // echo $form->field($model, 'item_name') ?>

    <?php // echo $form->field($model, 'warehouse') ?>

    <?php // echo $form->field($model, 'shelf') ?>

    <?php // echo $form->field($model, 'item_cost') ?>

    <?php // echo $form->field($model, 'weight_in') ?>

    <?php // echo $form->field($model, 'weight_out') ?>

    <?php // echo $form->field($model, 'balance_qty') ?>

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
