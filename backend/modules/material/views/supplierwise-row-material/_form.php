<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Supplier;
use common\models\Unit;
use yii\helpers\Url;
use common\components\ModalViewWidget;

/* @var $this yii\web\View */
/* @var $model common\models\SupplierwiseRowMaterial */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    label {
        font-weight: bold;
        color: #484848;
    }
</style>
<div class="supplierwise-row-material-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php
    echo ModalViewWidget::widget();
    ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php $category = ArrayHelper::map(\common\models\RowMaterialCategory::findAll(['status' => 1]), 'id', 'category'); ?>
            <?= $form->field($model, 'material_ctegory')->dropDownList($category, ['prompt' => '-Choose Category-']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'item_code')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php $units = ArrayHelper::map(Unit::findAll(['status' => 1]), 'id', 'unit_name'); ?>
            <?= $form->field($model, 'item_unit')->dropDownList($units, ['prompt' => '-Choose Unit-']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php $supplier = ArrayHelper::map(Supplier::findAll(['status' => 1]), 'id', 'company_name'); ?>
            <?= $form->field($model, 'supplier')->dropDownList($supplier, ['prompt' => '-Choose Supplier-']) ?>
            <?= Html::button('<span> Not in the list ? Add New</span>', ['value' => Url::to('../supplierwise-row-material/add-supplier'), 'class' => 'btn btn-icon btn-white extra_btn candidate_prof_add modalButton']) ?>
        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'purchase_price')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'minimum_quantity')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'reference')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
            <?php
            if ($model->photo != '') {
                $label = 'Change Photo';
            } else {
                $label = 'Photo';
            }
            ?>
            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                <?= $form->field($model, 'photo')->fileInput(['maxlength' => true])->label($label) ?>
                <?php
                if ($model->photo != '') {
                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/supplierwise_material/' . $model->id . '.' . $model->photo;
                    if (file_exists($dirPath)) {
                        echo '<img width="70" height="70" class="img-responsive" src="' . Yii::$app->homeUrl . 'uploads/supplierwise_material/' . $model->id . '.' . $model->photo . '?' . rand() . '"/>';
                    } else {
                        echo '';
                    }
                }
                ?>

            </div>
            <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>
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
<script>
    $("document").ready(function () {
        $(document).on('click', '.modalButton', function () {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr("value"));
        });
    });
</script>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#supplierwiserowmaterial-supplier").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#supplierwiserowmaterial-material_ctegory").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

    });
</script>