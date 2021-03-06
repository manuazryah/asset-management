<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminPosts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-posts-form form-inline">
    <?= \common\widgets\Alert::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'post_name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'admin')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'masters')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'purchase')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'stock')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'bom')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'sale')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'supplier_customer')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

        </div>
    </div>
    <div class="">
        <div class="form-group" style="float: right;">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
