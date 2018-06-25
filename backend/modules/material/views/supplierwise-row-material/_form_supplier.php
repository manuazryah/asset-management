<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Supplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-12 col-sm-12col-xs-12 left_padd'>
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'add_supplier']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script>

    $('#add_supplier').click(function (event) {
        alert('fgb');
        event.preventDefault();
        if (valid()) {
            var company_name = $('#supplier-company_name').val();
            var email = $('#supplier-email').val();
            var address = $('#supplier-address').val();
            var phone = $('#supplier-phone').val();
            var contact_person = $('#supplier-contact_person').val();
            $.ajax({
                url: '<?= Yii::$app->homeUrl ?>material/supplierwise-row-material/add-supplier',
                type: "post",
                data: {company_name: company_name, email: email, address: address, phone: phone, contact_person: contact_person},
                success: function (data) {
                    var $data = JSON.parse(data);
                    if ($data.con === "1") {
                        var newOption = $('<option value="' + $data.id + '">' + $data.name + '</option>');
                        $('#supplierwiserowmaterial-supplier').append(newOption);
                        $('#supplierwiserowmaterial-supplier' + ' option[value=' + $data.id + ']').attr("selected", "selected");
                        var vals = $('#supplierwiserowmaterial-supplier').val();
                        $('#supplierwiserowmaterial-supplier').select2('val', vals);
                        $('#modal').modal('hide');
                    } else {
                        alert($data.error);
                    }

                }, error: function () {

                }
            });
        } else {
//            alert('Please fill the Field');
        }

    });
    var valid = function () { //Validation Function - Sample, just checks for empty fields
        var valid;
        $("input").each(function () {
            if (!$('#supplier-company_name').val()) {
                $('#supplier-company_name').focus();
                valid = false;
            }
            if (!$('#supplier-email').val()) {
                $('#supplier-email').focus();
                valid = false;
            }
            if (!$('#supplier-address').val()) {
                $('#supplier-address').focus();
                valid = false;
            }
            if (!$('#supplier-phone').val()) {
                $('#supplier-phone').focus();
                valid = false;
            }
        });
        if (valid !== false) {
            return true;
        } else {
            return false;
        }
    }
</script>
