<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAssetMobile;
use common\widgets\Alert;

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
        </head>
        <body>
                <section id="header">
                    <h2 style="color:#063c55;font-weight: 600;text-align: center;">AL ORCHID PERFUME</h2>
                </section>
                <section id="heading-box"></section>

                <?php $this->beginBody() ?>


                <?= $content ?>




                <?php $this->endBody() ?>

                <section id="footr-bar"><p>Copyright © AL ORCHID PERFUME</p></section>
        </body>
</html>
<?php $this->endPage() ?>
