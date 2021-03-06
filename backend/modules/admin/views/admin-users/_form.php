<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AdminPosts;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUsers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-users-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <?= \common\widgets\Alert::widget(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?php $posts = ArrayHelper::map(AdminPosts::findAll(['status' => 1]), 'id', 'post_name'); ?>
            <?= $form->field($model, 'post_id')->dropDownList($posts, ['prompt' => '-Choose a Post-']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-8 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <?php if ($model->isNewRecord) { ?>
            <div class='col-md-4 col-sm-6 col-xs-12'>

                <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

            </div>
        <?php } ?>
        <?php if ($model->isNewRecord) { ?>
            <div class='col-md-4 col-sm-6 col-xs-12'>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>


            </div>
        <?php } ?>

        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

        </div>
    </div>
    <div class="form-group ">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>
    <div class="clearfix"></div>

    <?php ActiveForm::end(); ?>

</div>
