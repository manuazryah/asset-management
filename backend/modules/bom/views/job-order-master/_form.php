<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\JobOrderMaster */
/* @var $form yii\widgets\ActiveForm */
$model->bom_no = $this->context->getBomNo();
?>
<style>
    .qty_check{
        color: #b70a0a;
        font-weight: 600;
        position: absolute;
        bottom: 0px;
        left: 16px;
        display: none;
    }
</style>
<div class="job-order-master-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'bom_no')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>  
            <?php
            $model->bom_date = date('d-M-Y');
            ?>
            <?=
            $form->field($model, 'bom_date')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-M-yyyy',
                ]
            ]);
            ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <h5 style="color: #313131;font-weight: 600;font-size: 15px;">BOM Details</h5>
    <?php
    $named_bottle_datas = ArrayHelper::map(common\models\SupplierwiseRowMaterial::find()->where(['status' => 1, 'material_ctegory' => 5])->all(), 'id', function($model) {
                return ucfirst($model['item_name'] . ' ( ' . $model['item_code'] . ' ) ');
            }
    );
    $clear_bottle_datas = ArrayHelper::map(common\models\SupplierwiseRowMaterial::find()->where(['status' => 1, 'material_ctegory' => 4])->all(), 'id', function($model) {
                return ucfirst($model['item_name'] . ' ( ' . $model['item_code'] . ' ) ');
            }
    );
    ?>
    <div class="append-box">
        <div class="row">
            <div class='col-md-4 col-xs-12 left_padd'>   
                <?= $form->field($model_details, 'named_bottle')->dropDownList($named_bottle_datas, ['prompt' => '-Choose Material-']); ?>

            </div>
            <div class='col-md-4 col-xs-12 left_padd'>    
                <?= $form->field($model_details, 'quantity')->textInput(['maxlength' => true]) ?>

            </div>
        </div>
        <div class="row">
            <div class='col-md-4 col-xs-12 left_padd'>    
                <?= $form->field($model_details, 'bottle')->dropDownList($clear_bottle_datas, ['prompt' => '-Choose Material-']); ?>

            </div>
            <div class='col-md-4 col-xs-12 left_padd'>  
                <?= $form->field($model_details, 'qty')->textInput(['maxlength' => true, 'type' => 'number','min'=>1]) ?>
                <div class="qty_check">Available Quantity : <span id="avail-qty"></span></div>
            </div>
            <div class='col-md-4 col-xs-12 left_padd'>    
                <?= $form->field($model_details, 'damaged')->textInput(['maxlength' => true])->label('Damaged Quantity') ?>

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
        $("#joborderdetails-named_bottle").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#joborderdetails-bottle").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

    });
</script>
<script>
    $(document).ready(function () {

        $(document).on('keyup mouseup', '#joborderdetails-quantity', function (e) {
            $('#joborderdetails-qty').val($(this).val());
            $('#joborderdetails-qty').keyup();
        });
        $(document).on('keyup mouseup', '#joborderdetails-qty', function (e) {
            var item = $('#joborderdetails-bottle').val();
            if (item != '') {
                var avail = $('#avail-qty').text();
                var qty = $(this).val();
                if(parseInt(qty) > parseInt(avail)){
                    alert('Quantity exeeds the available quantity');
                    $('#joborderdetails-qty').val(avail);
                }
            }
        });

        /*
         * on click of the Add new Vessel link
         * return pop up form for add new vessel details
         */

        $(document).on('change', '#joborderdetails-bottle', function (e) {
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {material_id: $(this).val()},
                url: '<?= Yii::$app->homeUrl; ?>bom/job-order-master/bottle-details',
                success: function (data) {
                    $('#joborderdetails-qty').attr({
                        "max": data, // substitute your own
                    });
                    $(".qty_check").css({"display": "block"});
                    $("#avail-qty").text(data);
                    $('#joborderdetails-qty').keyup();
                    e.preventDefault();
                }
            });
        });
    });
</script>

