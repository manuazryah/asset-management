<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\RowMaterialCategory;
use yii\helpers\ArrayHelper;
use common\models\Unit;

/* @var $this yii\web\View */
/* @var $model common\models\RowMaterial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row-material-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'> 
            <?php $category = ArrayHelper::map(RowMaterialCategory::findAll(['status' => 1]), 'id', 'category'); ?>
            <?= $form->field($model, 'category')->dropDownList($category, ['prompt' => '-Choose a Category-']) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'item_code')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>   
            <?php $units = ArrayHelper::map(Unit::findAll(['status' => 1]), 'id', 'unit_name'); ?>
            <?= $form->field($model, 'item_unit')->dropDownList($units, ['prompt' => '-Choose a Unit-']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

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
                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/row_material/' . $model->id . '.' . $model->photo;
                    if (file_exists($dirPath)) {
                        echo '<img width="70" height="70" class="img-responsive" src="' . Yii::$app->homeUrl . 'uploads/row_material/' . $model->id . '.' . $model->photo . '?' . rand() . '"/>';
                    } else {
                        echo '';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-12 col-sm-12 col-xs-12 left_padd'> 
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
