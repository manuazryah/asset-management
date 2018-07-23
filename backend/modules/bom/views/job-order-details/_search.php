<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JobOrderDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-order-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'master_id') ?>

    <?= $form->field($model, 'named_bottle') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'bottle') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'damaged') ?>

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
