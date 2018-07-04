<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!--<link rel="shortcut icon" href="<?= yii::$app->homeUrl; ?>images/fav.png" type="image/png" />-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Asset Management Admin Panel" />
        <meta name="author" content="" />
        <title>Admin Home</title>
        <script src="<?= Yii::$app->homeUrl; ?>js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript">
            var homeUrl = '<?= Yii::$app->homeUrl; ?>';
        </script>

        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body class="page-body">
        <?php $this->beginBody() ?>


        <nav class="navbar horizontal-menu navbar-fixed-top"><!-- set fixed position by adding class "navbar-fixed-top" -->

            <div class="navbar-inner">

                <!-- Navbar Brand -->
                <div class="navbar-brand">
                    <a href="" class="logo">
                        <h4>AL ORCHID PERFUME</h4>
                    </a>
                </div>

                <!-- Mobile Toggles Links -->
                <div class="nav navbar-mobile">

                    <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                    <div class="mobile-menu-toggle">
                        <a href="#" data-toggle="mobile-menu-horizontal">
                            <i class="fa-bars"></i>
                        </a>
                    </div>

                </div>

                <div class="navbar-mobile-clear"></div>
                <ul class="nav nav-userinfo navbar-left">
                    <li class="hidden-sm hidden-xs sidebar-togle">
                        <a href="#" data-toggle="sidebar">
                            <i class="fa-bars"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li>
                        <?= Html::a('<i class="fa-home"></i> <span class="title">Home</span>', ['/site/home'], ['class' => 'title']) ?>
                    </li>
                    <?php
                    if (Yii::$app->session['post']['admin'] == 1) {
                        ?>
                        <li>
                            <a href="">
                                <i class="fa fa-tachometer"></i>
                                <span class="title">Administration</span>
                            </a>
                            <ul>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Access Powers', ['/admin/admin-posts/index'], ['class' => 'title']) ?>
                                </li>

                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Admin Users', ['/admin/admin-users/index'], ['class' => 'title']) ?>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>
                    <li>
                        <?= Html::a('<i class="fa fa-shopping-cart"></i> <span class="title">BOM</span>', ['/bom/bom-master/index'], ['class' => 'title']) ?>
                    </li>
                    <li class="has-sub">
                        <a href="">
                            <i class="fa fa-folder"></i>
                            <span class="title">Stock</span>
                        </a>
                        <ul>
                            <li class="has-sub">
                                <a href="">
                                    <i class="fa fa-circle-thin"></i>
                                    <span class="title">Stock Register</span>
                                </a>
                                <ul style="display: none;">
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Row Material', ['/stock/stock-register/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Products', ['/stock/product-stock-register/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a href="">
                                    <i class="fa fa-circle-thin"></i>
                                    <span class="title">Stock View</span>
                                </a>
                                <ul style="display: none;">
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Row Material', ['/stock/stock-view/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Products', ['/stock/product-stock-view/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a href="">
                                    <i class="fa fa-circle-thin"></i>
                                    <span class="title">Stock Adjustment</span>
                                </a>
                                <ul style="display: none;">
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Row Material', ['/stock/material-adjustment-master/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Product', ['/stock/product-adjustment-master/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-briefcase"></i> <span class="title">Purchase</span>', ['/purchase/purchase-master/index'], ['class' => 'title']) ?>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-shopping-cart"></i> <span class="title">Sale</span>', ['/sales/product-sale-master/index'], ['class' => 'title']) ?>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-list"></i> Finished Product', ['/product/finished-product/index'], ['class' => 'title']) ?>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa fa-cubes"></i>
                            <span class="title">Row Material</span>
                        </a>
                        <ul>
                            <li>
                                <?= Html::a('<i class="fa fa-angle-double-right"></i> Material Category', ['/masters/row-material-category/index'], ['class' => 'title']) ?>
                            </li>
                            <li>
                                <?= Html::a('<i class="fa fa-angle-double-right"></i> Row Material', ['/material/supplierwise-row-material/index'], ['class' => 'title']) ?>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa fa-users"></i>
                            <span class="title">Suppliers & Customers</span>
                        </a>
                        <ul>
                            <li>
                                <?= Html::a('<i class="fa fa-angle-double-right"></i> Suppliers', ['/masters/supplier/index'], ['class' => 'title']) ?>
                            </li>
                            <li>
                                <?= Html::a('<i class="fa fa-angle-double-right"></i> Customers', ['/masters/customers/index'], ['class' => 'title']) ?>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa fa-database"></i>
                            <span class="title">Masters</span>
                        </a>
                        <ul>
                            <li>
                                <?= Html::a('<i class="fa fa-angle-double-right"></i> Product Category', ['/product/product-category/index'], ['class' => 'title']) ?>
                            </li>
                            <li>
                                <?= Html::a('<i class="fa fa-angle-double-right"></i> Unit', ['/masters/unit/index'], ['class' => 'title']) ?>
                            </li>
                            <li>
                                <?= Html::a('<i class="fa fa-angle-double-right"></i> Fragrance', ['/masters/fragrance/index'], ['class' => 'title']) ?>
                            </li>
                            <li>
                                <?= Html::a('<i class="fa fa-angle-double-right"></i> Brand', ['/masters/brand/index'], ['class' => 'title']) ?>
                            </li>
                            <li>
                                <?= Html::a('<i class="fa fa-angle-double-right"></i> Warehouse', ['/masters/warehouse/index'], ['class' => 'title']) ?>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- notifications and other links -->
                <ul class="nav nav-userinfo navbar-right">
                    <li>
                        <a href="<?= Yii::$app->homeUrl; ?>site/home"><i class="fa-home"></i> Home</a>
                    </li>

                    <li class="dropdown user-profile">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= yii::$app->homeUrl; ?>images/user-4.png" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
                            <span>
                                <?= Yii::$app->user->identity->user_name ?>
                                <i class="fa-angle-down"></i>
                            </span>
                        </a>

                        <ul class="dropdown-menu user-profile-menu list-unstyled">
                            <li class="user-header">
                                <img src="<?= yii::$app->homeUrl; ?>images/user-4.png" alt="user-image" class="img-circle" />
                                <p>
                                    <?= Yii::$app->user->identity->user_name ?>
                                    <!--<small>Member since Nov. 2012</small>-->
                                </p>
                            </li>
                            <li class="user-footer" style="background: #eeeeee;">
                                <div class="row">
                                    <div class="pull-left">
                                        <?= Html::a('Profile', ['/admin/admin-users/update', 'id' => Yii::$app->user->identity->id], ['class' => 'btn btn-white', 'style' => 'padding: 5px 20px;border: 1px solid #a09f9f;']) ?>
                                    </div>
                                    <div class="pull-right">
                                        <?php
                                        echo ''
                                        . Html::beginForm(['/site/logout'], 'post', ['style' => 'margin-bottom: 0px;']) . '<a>'
                                        . Html::submitButton(
                                                'Sign out', ['class' => 'btn btn-white', 'style' => 'border: 1px solid #a09f9f;']
                                        ) . '</a>'
                                        . Html::endForm()
                                        . '';
                                        ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>

        </nav>

        <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

            <div class="sidebar-menu toggle-others fixed">

                <div class="sidebar-menu-inner">



                    <ul id="main-menu" class="main-menu">
                        <li>
                            <?= Html::a('<i class="fa-home"></i> <span class="title">Home</span>', ['/site/home'], ['class' => 'title']) ?>
                        </li>
                        <?php
                        if (Yii::$app->session['post']['admin'] == 1) {
                            ?>
                            <li>
                                <a href="">
                                    <i class="fa fa-tachometer"></i>
                                    <span class="title">Administration</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Access Powers', ['/admin/admin-posts/index'], ['class' => 'title']) ?>
                                    </li>

                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Admin Users', ['/admin/admin-users/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <?= Html::a('<i class="fa fa-shopping-cart"></i> <span class="title">BOM</span>', ['/bom/bom-master/index'], ['class' => 'title']) ?>
                        </li>
                        <li class="has-sub">
                            <a href="">
                                <i class="fa fa-folder"></i>
                                <span class="title">Stock</span>
                            </a>
                            <ul>
                                <li class="has-sub">
                                    <a href="">
                                        <i class="fa fa-circle-thin"></i>
                                        <span class="title">Stock Register</span>
                                    </a>
                                    <ul style="display: none;">
                                        <li>
                                            <?= Html::a('<i class="fa fa-angle-double-right"></i> Row Material', ['/stock/stock-register/index'], ['class' => 'title']) ?>
                                        </li>
                                        <li>
                                            <?= Html::a('<i class="fa fa-angle-double-right"></i> Products', ['/stock/product-stock-register/index'], ['class' => 'title']) ?>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-sub">
                                    <a href="">
                                        <i class="fa fa-circle-thin"></i>
                                        <span class="title">Stock View</span>
                                    </a>
                                    <ul style="display: none;">
                                        <li>
                                            <?= Html::a('<i class="fa fa-angle-double-right"></i> Row Material', ['/stock/stock-view/index'], ['class' => 'title']) ?>
                                        </li>
                                        <li>
                                            <?= Html::a('<i class="fa fa-angle-double-right"></i> Products', ['/stock/product-stock-view/index'], ['class' => 'title']) ?>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-sub">
                                    <a href="">
                                        <i class="fa fa-circle-thin"></i>
                                        <span class="title">Stock Adjustment</span>
                                    </a>
                                    <ul style="display: none;">
                                        <li>
                                            <?= Html::a('<i class="fa fa-angle-double-right"></i> Row Material', ['/stock/material-adjustment-master/index'], ['class' => 'title']) ?>
                                        </li>
                                        <li>
                                            <?= Html::a('<i class="fa fa-angle-double-right"></i> Product', ['/stock/product-adjustment-master/index'], ['class' => 'title']) ?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-briefcase"></i> <span class="title">Purchase</span>', ['/purchase/purchase-master/index'], ['class' => 'title']) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-shopping-cart"></i> <span class="title">Sale</span>', ['/sales/product-sale-master/index'], ['class' => 'title']) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-list"></i> Finished Product', ['/product/finished-product/index'], ['class' => 'title']) ?>
                        </li>

                        <li>
                            <a href="">
                                <i class="fa fa-cubes"></i>
                                <span class="title">Row Material</span>
                            </a>
                            <ul>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Material Category', ['/masters/row-material-category/index'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Row Material', ['/material/supplierwise-row-material/index'], ['class' => 'title']) ?>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa fa-users"></i>
                                <span class="title">Suppliers & Customers</span>
                            </a>
                            <ul>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Suppliers', ['/masters/supplier/index'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Customers', ['/masters/customers/index'], ['class' => 'title']) ?>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa fa-database"></i>
                                <span class="title">Masters</span>
                            </a>
                            <ul>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Product Category', ['/product/product-category/index'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Unit', ['/masters/unit/index'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Fragrance', ['/masters/fragrance/index'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Brand', ['/masters/brand/index'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Warehouse', ['/masters/warehouse/index'], ['class' => 'title']) ?>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>

            </div>

            <div class="main-content">
                <?= $content; ?>

                <footer class="main-footer sticky footer-type-1">

                    <div class="footer-inner">

                        <!-- Add your copyright text here -->
                        <div class="footer-text">
                            <strong>© 2018 Linea De Bella. All rights reserved.</strong>
                        </div>


                        <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                        <div class="go-up">

                            <a href="#" rel="go-top">
                                <i class="fa-angle-up"></i>
                            </a>

                        </div>

                    </div>

                </footer>
            </div>
        </div>
        <!-- Page Loading Overlay -->
        <div class="page-loading-overlay">
            <div class="loader-2"></div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>