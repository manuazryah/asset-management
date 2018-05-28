<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-form form-inline">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'brand')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
           <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success mrg-top-btn']) ?>
            <?php if (!$model->isNewRecord) { ?>
                <?= Html::a('Reset', ['index'], ['class' => 'btn btn-success mrg-top-btn']) ?>
            <?php }
            ?>
        </div>
    </div>
        <?php ActiveForm::end(); ?>

</div>
