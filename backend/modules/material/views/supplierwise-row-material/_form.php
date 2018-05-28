<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\RowMaterial;
use common\models\Supplier;
use common\models\Unit;

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
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php $category = ArrayHelper::map(RowMaterial::findAll(['status' => 1]), 'id', 'item_name'); ?>
            <?= $form->field($model, 'master_row_material_id')->dropDownList($category, ['prompt' => '-Choose Item-']) ?>

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
            <?= $form->field($model, 'item_unit')->dropDownList($units, ['prompt' => '-Choose Unit-', 'readonly' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'reference')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php $supplier = ArrayHelper::map(Supplier::findAll(['status' => 1]), 'id', 'company_name'); ?>
            <?= $form->field($model, 'supplier')->dropDownList($supplier, ['prompt' => '-Choose Supplier-']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'purchase_price')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'minimum_quantity')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?php
            if ($model->photo != '') {
                $label = 'Change Photo';
            } else {
                $label = 'Photo';
            }
            ?>
            <div class='col-md-8 col-sm-8 col-xs-12 left_padd'>
                <?= $form->field($model, 'photo')->fileInput(['maxlength' => true])->label($label) ?>
                <?php if ($model->photo == '') { ?>
                    <?= Html::checkbox('check', false, ['label' => 'Copy from row material', 'uncheck' => 0]) ?>
                <?php }
                ?>
            </div>
            <div class='col-md-4 col-sm-4 col-xs-12 left_padd'>
                <?php
                if ($model->photo != '') {
                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/supplierwise_material/' . $model->id . '.' . $model->photo;
                    if (file_exists($dirPath)) {
                        echo '<img width="70" height="70" class="img-responsive" src="' . Yii::$app->homeUrl . 'uploads/supplierwise_material/' . $model->id . '.' . $model->photo . '?'.rand().'"/>';
                    } else {
                        echo '';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-8 col-sm-8 col-xs-12 left_padd'>
            <?= $form->field($model, 'comment')->textarea(['rows' => 2]) ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script>
    $("document").ready(function () {
        $(document).on('change', '#supplierwiserowmaterial-master_row_material_id', function () {
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {item_id: $(this).val()},
                url: '<?= Yii::$app->homeUrl; ?>material/supplierwise-row-material/get-material-details',
                success: function (data) {
                    var res = $.parseJSON(data);
                    $('#supplierwiserowmaterial-item_code').val(res.result['item_code']);
                    $('#supplierwiserowmaterial-item_name').val(res.result['item_name']);
                    $('#supplierwiserowmaterial-item_unit').val(res.result['item_unit']);
                }
            });
        });
    });
</script>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#supplierwiserowmaterial-master_row_material_id").select2({
            placeholder: 'Choose Item',
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#supplierwiserowmaterial-supplier").select2({
            placeholder: 'Choose Supplier',
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
    });
</script>