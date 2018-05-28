<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\BomMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bom-master-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'bom_no')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'> 
            <?php
            $model->date = date('d-M-Y');
            ?>
            <?=
            $form->field($model, 'date')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-M-yyyy',
                ]
            ]);
            ?>
        </div>
    </div>
    <h5 style="color: #313131;font-weight: 600;">BOM Details</h5>
    <div id="p_scents">
        <input type="hidden" id="bom_row_count" value="1"/>
        <div class="append-box">
            <div class="row">
                <div class="col-md-6">
                    <div class="formrow">
                        <?php
                        $products = \common\models\FinishedProduct::find()->where(['status' => 1])->all();
                        ?>
                        <select class="form-control product_id" name="create[product][]" id="product_id-1" required>
                            <option value="">Select Product</option>
                            <?php
                            if (!empty($products)) {
                                foreach ($products as $product) {
                                    ?>
                                    <option value="<?= $product->id ?>"><?= $product->product_name ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="formrow">
                        <input type="number" min="1" autocomplete="off"  step="any" class="form-control product_qty" name="create[product_qty][]" placeholder="Quantity" id="product_qty-1" required>
                    </div>
                </div>
                <div id="bom-material-details-1" class="bom-material-details">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="form-group field-portcalldatarob-fresh_water_arrival_quantity">
        <a id="addbomdetails" class="btn btn-icon btn-blue addScnt btn-larger btn-block" ><i class="fa fa-plus"></i> Add More</a>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).ready(function () {
        $(document).on('click', '#addbomdetails', function (event) {
            var row_id = $('#bom_row_count').val();
            var next = parseInt(row_id) + 1;
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {next: next},
                url: '<?= Yii::$app->homeUrl ?>bom/bom-master/get-bom',
                success: function (data) {
                    $('#p_scents').append(data);
                }
            });
            counter++;
        });
        $(document).on('click', '.ibtnDel', function () {
            $(this).parents('.append-box').remove();
            return false;
        });
        $(document).on('change', '.product_id', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var item_id = $(this).val();
            itemChange(item_id, current_row_id);
        });
    });
    function itemChange(item_id, current_row_id) {
        $.ajax({
            type: 'POST',
            cache: false,
            async: false,
            data: {item_id: item_id, current_row_id: parseInt(current_row_id)},
            url: '<?= Yii::$app->homeUrl; ?>bom/bom-master/get-items',
            success: function (data) {
                $("#bom-material-details-" + current_row_id).html(data);
            }
        });
        return true;
    }
</script>
