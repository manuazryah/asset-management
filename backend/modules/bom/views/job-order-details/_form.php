<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JobOrderDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-order-details-form form-inline">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'master_id')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'named_bottle')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'quantity')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'bottle')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'qty')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'damaged')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'status')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'CB')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'UB')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'DOC')->textInput() ?>

</div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'DOU')->textInput() ?>

</div>        </div>


        <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
        </div>


        <?php ActiveForm::end(); ?>

</div>
