<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Employee;

$this->title = 'Login';
?>
<section id="login-box">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 shadow">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= \common\widgets\Alert::widget(); ?>
                <div class="col-md-12">
                   <h1>Dear user, log in to access the admin area!</h1>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'user_name')->textInput(['autofocus' => '', 'placeholder' => 'Username']) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>
                </div>
                <div class="col-md-12">
                    <?= Html::submitButton('Login', ['class' => 'micro-submit', 'name' => 'login']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

</section>