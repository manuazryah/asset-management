<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\models\Services;
use common\models\Employee;
use common\models\Appointment;
use common\models\Contacts;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use common\components\FinishedProductWidget;

/* @var $this yii\web\View */
/* @var $model common\models\EstimatedProforma */

$this->title = 'BOM Details';
$this->params['breadcrumbs'][] = ['label' => 'BOM Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h2  class="appoint-title panel-title"><?= Html::encode($this->title) . ' # <b style="color: #008cbd;">' . $finished_product->product_name . '</b>' ?></h2>

            </div>
            <?php //Pjax::begin();     ?>
            <div class="panel-body">
                <?= FinishedProductWidget::widget(['id' => $finished_product->id]) ?>

                <!-------------------------------------------------- Menu ----------------------------------------------------------->
                <ul class="nav nav-tabs nav-tabs-justified" style="margin-bottom: 20px;">
                    <li>
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Finished Product</span>', ['finished-product/update', 'id' => $finished_product->id]);
                        ?>

                    </li>
                    <li class="active">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">BOM Details</span>', ['finished-product/add', 'id' => $finished_product->id]);
                        ?>

                    </li>

                </ul>

                <!------------------------------------------------------------------------------------------------------------->


                <!------------------------------------------- Appointment Details ------------------------------------------------------------------>
                <?php
//                                Pjax::begin(['id' => 'some_pjax_id']);
                ?>
                <div class="outterr">

                    <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

                        <table cellspacing="0" class="table table-small-font table-bordered table-striped" id="appointment-table">
                            <thead>
                                <tr>
                                    <th data-priority="1" style="width:2%">#</th>
                                    <th data-priority="3" style="width:10%">Material Category</th>
                                    <th data-priority="3" style="width:10%">Row Material</th>
                                    <th data-priority="1" style="width:8%">Quantity</th>
                                    <th data-priority="1" style="width:5%">Comment</th>
                                    <th data-priority="1" style="width:5%">ACTIONS</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $deselct_ids = [];
                                if (!empty($bom_details)) {
                                    $i = 0;
                                    foreach ($bom_details as $bom_detail) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $bom_detail->row_material_category != '' ? \common\models\RowMaterialCategory::findOne($bom_detail->row_material_category)->category : '' ?></td>
                                            <td><?= $bom_detail->row_material_id != '' ? \common\models\SupplierwiseRowMaterial::findOne($bom_detail->row_material_id)->item_name : '' ?></td>
                                            <td><?= $bom_detail->quantity ?><span style="float:right;"><?= $bom_detail->unit != '' ? \common\models\Unit::findOne($bom_detail->unit)->unit_name : '' ?></span></td>
                                            <td><?= $bom_detail->comment ?></td>
                                            <td>
                                                <?= Html::a('<i class="fa fa-pencil"></i>', ['/product/finished-product/add', 'id' => $id, 'prfrma_id' => $bom_detail->id], ['class' => '', 'tittle' => 'Edit']) ?>
                                                <?= Html::a('<i class="fa fa-remove"></i>', ['/product/finished-product/delete-detail', 'id' => $bom_detail->id], ['class' => '', 'tittle' => 'Edit', 'data-confirm' => 'Are you sure you want to delete this item?']) ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $deselct_ids[] = $bom_detail->row_material_id;
                                    }
                                }
                                $romaterial_datas = ArrayHelper::map(\common\models\SupplierwiseRowMaterial::find()->where(['status' => 1])->andFilterWhere(['NOT IN', 'id', $deselct_ids])->all(), 'id', function($model) {
                                            return ucfirst($model['item_name'] . ' ( ' . $model['item_code'] . ' ) ');
                                        }
                                );
                                $romaterial_category = ArrayHelper::map(\common\models\RowMaterialCategory::find()->where(['status' => 1])->all(), 'id', 'category');
                                ?>
                                <tr class="formm">
                                    <?php $form = ActiveForm::begin(); ?>
                                    <td></td>
                                    <td><?= $form->field($model, 'row_material_category')->dropDownList($romaterial_category, ['prompt' => '-Choose Material-'])->label(false); ?></td>
                                    <td><?= $form->field($model, 'row_material_id')->dropDownList($romaterial_datas, ['prompt' => '-Choose Material-'])->label(false); ?></td>
                                    <td>
                                        <div class="form-group field-bomdetails-quantity required">

                                            <input type="number" id="bomdetails-quantity" class="form-control" name="BomDetails[quantity]" value="1" placeholder="Quantity" min="1" aria-required="true">
                                            <span id="unit-text"></span>
                                            <div class="help-block"></div>
                                        </div>
                                    <td><?= $form->field($model, 'comment')->textarea(['placeholder' => 'Comment'])->label(false) ?></td>
                                    <td><?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => 'btn btn-success']) ?>
                                    </td>

                                    <?php ActiveForm::end(); ?>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                </div>
                <?php // Pjax::end();  ?>

                <!------------------------------------------------------------------------------------------------------------->

            </div>
        </div>
    </div>
</div>



<style>
    .filter{
        background-color: #b9c7a7;
    }
    table.table tr td:last-child a {
        padding: inherit;padding: 4px 4px;
    }
    .error{
        color: #0553b1;
        padding-bottom: 5px;
        font-size: 18px;
        font-weight: bold;
    }.field-appointmentdetails-tax{
        width:65%!important;
        display: inline-block;
    }.field-appointmentdetails-quantity{
        width:70%!important;
        display: inline-block;
    }.formm td{
        padding: 5px !important;
    }
    .field-bomdetails-quantity{
        position: relative;
    }
    #unit-text{
        margin-left: 5px;
        position: absolute;
        top: 8px;
        right: 25px;
    }
</style>
<script>
    $("document").ready(function () {
        $(document).on('change', '#bomdetails-row_material_id', function () {
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {item_id: $(this).val()},
                url: '<?= Yii::$app->homeUrl; ?>product/finished-product/get-unit',
                success: function (data) {
                    $('#unit-text').text(data);
                }
            });
        });

        $(document).on('change', '#bomdetails-row_material_category', function () {
            var product_id = '<?php echo $id; ?>';
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {category: $(this).val(), product_id: product_id},
                url: '<?= Yii::$app->homeUrl; ?>product/finished-product/get-material',
                success: function (data) {
                    $('#bomdetails-row_material_id').html(data);
                }
            });
        });
    });
</script>


