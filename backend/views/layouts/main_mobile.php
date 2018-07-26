<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use backend\assets\AppAssetMobile;

AppAssetMobile::register($this);
?>
<?php $this->beginPage()
?>

<!DOCTYPE html>
<html lang="en">


    <!-- Mirrored from templates.scriptsbundle.com/logistic-pro/demo/logistic-pro/index-4.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Sep 2016 15:24:06 GMT -->
    <head>
        <title>AL ORCHID PERFUME</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="<?= Yii::$app->homeUrl; ?>/js/jquery.min.js"></script>
        <script src="https://use.fontawesome.com/2853c84fb5.js"></script>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
        <style>
            body{
                text-transform: uppercase;
            }
            input,textarea,select{
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <section id="header">
            <h2 style="color:#063c55;font-weight: 600;text-align: center;">AL ORCHID PERFUME</h2>
        </section>
        <section id="heading-box">

            <div class="navbar">
                <div class="dropdown">
                    <button class="dropbtn">
                        <?= Html::a('<i class="fa fa-home" aria-hidden="true"></i>', ['/site/index'], ['class' => 'title']) ?>
                    </button>
                </div>
                <button style="padding-left: 0px;">
                    <?php
                    echo ''
                    . Html::beginForm(['/site/logout'], 'post', ['style' => '']) . '<a>'
                    . Html::submitButton(
                            '<i class="fa fa-power-off" aria-hidden="true"></i>', ['class' => '', 'style' => 'padding-top: 5px;color:white;']
                    ) . '</a>'
                    . Html::endForm()
                    . '';
                    ?>
                </button>
            <!--<a href="<?= Yii::$app->homeUrl; ?>site/logout"><i class="fa fa-power-off" aria-hidden="true"></i></a>-->
            </div>
        </section>
        <?php $this->beginBody() ?>


        <?= $content ?>




        <?php $this->endBody() ?>

        <section id="footr-bar"><p>Copyright © AL ORCHID PERFUME</p></section>
    </body>
</html>
<?php $this->endPage() ?>
