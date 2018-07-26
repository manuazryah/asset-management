<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section id="login-box">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 shadow">
                <div class="box">
                    <div>
                        <?= Html::a('Job Order', ['/site/bom'], ['class' => 'btn btn-orange']) ?>
                    </div>
                    <div>
                        <?= Html::a('Material Stock', ['/site/bom'], ['class' => 'btn btn-orange']) ?>
                    </div>
                    <div>
                        <?= Html::a('Product Stock', ['/site/bom'], ['class' => 'btn btn-orange']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

</section>
