<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ProductCategory;
use common\models\Unit;
use common\models\Fragrance;
Use common\models\Brand;

/* @var $this yii\web\View */
/* @var $model common\models\FinishedProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finished-product-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php $category = ArrayHelper::map(ProductCategory::findAll(['status' => 1]), 'id', 'product_category'); ?>
            <?= $form->field($model, 'product_category')->dropDownList($category, ['prompt' => '-Choose a Category-']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'product_name',['inputOptions' => ['autocomplete' => 'off','class'=>'form-control']])->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'product_code')->textInput(['maxlength' => true, 'readonly' => TRUE]) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php $fragrance = ArrayHelper::map(Fragrance::findAll(['status' => 1]), 'id', 'name'); ?>
            <?= $form->field($model, 'fragrance_type')->dropDownList($fragrance, ['prompt' => '-Choose Fragrance-']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php
            if ($model->isNewRecord) {
                $deault_brand = Brand::find()->where(['set_as_default' => 1])->one();
                if (!empty($deault_brand)) {
                    $model->brand = $deault_brand->id;
                }
            }
            ?>
            <?php $brands = ArrayHelper::map(Brand::findAll(['status' => 1]), 'id', 'brand'); ?>
            <?= $form->field($model, 'brand')->dropDownList($brands, ['prompt' => '-Choose Brand-']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php
            if ($model->isNewRecord) {
                $deault_unit = Unit::find()->where(['set_as_default' => 1])->one();
                if (!empty($deault_unit)) {
                    $model->unit = $deault_unit->id;
                }
            }
            ?>
            <?php $units = ArrayHelper::map(Unit::findAll(['status' => 1]), 'id', 'unit_name'); ?>
            <?= $form->field($model, 'unit')->dropDownList($units, ['prompt' => '-Choose Unit-']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
           <?= $form->field($model, 'gender')->dropDownList(['1' => 'Men', '2' => 'Women','3' => 'Unisex', '4' => 'Oriental']) ?>

        </div>
      
    </div>
    <div class="row">
        <div class='col-md-8 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'comment')->textarea(['rows' => 2]) ?>

        </div>
          <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php // $form->field($model, 'gender')->dropDownList(['1' => 'Men', '2' => 'Women','3'=>'Unisex','4'=>'Oriental']) ?>
            <?php
            if ($model->item_photo != '') {
                $label = 'Change Photo';
            } else {
                $label = 'Item Photo';
            }
            ?>
            <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
                <?= $form->field($model, 'item_photo')->fileInput(['maxlength' => true])->label($label) ?>
            </div>
            <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
                <?php
                if ($model->item_photo != '') {
                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/finished_product/' . $model->id . '.' . $model->item_photo;
                    if (file_exists($dirPath)) {
                        echo '<img width="100" class="img-responsive" src="' . Yii::$app->homeUrl . 'uploads/finished_product/' . $model->id . '.' . $model->item_photo . '?' . rand() . '"/>';
                    } else {
                        echo '';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#finishedproduct-product_category").select2({
            placeholder: 'Choose Category',
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#finishedproduct-brand").select2({
            placeholder: 'Choose Brand',
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $('#finishedproduct-product_name').keyup(function () {
            var name = slug($(this).val());
            $('#finishedproduct-product_code').val(slug($(this).val()));
        });
        var slug = function (str) {
            var $slug = '';
            var trimmed = $.trim(str);
            $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
                    replace(/-+/g, '-').
                    replace(/^-|-$/g, '');
            return $slug.toLowerCase();
        }
    });
</script>
