<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RowMaterialCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row-material-category-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'> 
            <?php
            if ($model->photo != '') {
                $label = 'Change Photo';
            } else {
                $label = 'Photo';
            }
            ?>
            <div class='col-md-6 col-sm-6 col-xs-12 left_padd'> 
                <?= $form->field($model, 'photo')->fileInput(['maxlength' => true])->label($label) ?>
            </div>
            <div class='col-md-6 col-sm-6 col-xs-12 left_padd'> 
                <?php
                if ($model->photo != '') {
                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/material_category/' . $model->id . '.' . $model->photo;
                    if (file_exists($dirPath)) {
                        echo '<img width="100" class="img-responsive" src="' . Yii::$app->homeUrl . 'uploads/material_category/' . $model->id . '.' . $model->photo . '?' . rand() . '"/>';
                    } else {
                        echo '';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

        </div>
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
