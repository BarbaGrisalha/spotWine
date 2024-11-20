<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Spotwine</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</head>

<?php $this->beginBody(); ?>
<body>

<div class="container-fluid ">
    <div class="row bg-banner py-1 px-xl-5 text-center">

        <div class="col-12 d-flex align-items-center justify-content-center banner-none">
            <i class="fas fa-wine-glass fa-lg text-dark"></i>
            <?= Html::tag('span', 'O Mercado de Vinhos Diretamente das Caves', ['class' => 'text-black ml-2']) ?>
        </div>

        <!--
            <div class="col-lg-6 text-center text-lg-right">
                Moeda
                <div class="btn-group mx-2">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">USD</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">EUR</button>
                        <button class="dropdown-item" type="button">GBP</button>
                        <button class="dropdown-item" type="button">CAD</button>
                    </div>
                </div>
               -->
                <!--Idiomas
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">EN</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">FR</button>
                        <button class="dropdown-item" type="button">AR</button>
                        <button class="dropdown-item" type="button">RU</button>
                    </div>
                </div>

            </div>
            -->
            <div class="d-inline-flex align-items-center d-block d-lg-none">
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-heart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                </a>
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                </a>
                <a href="" class="btn px-0 ml-2">
                    <!-- User Dropdown -->
                    <div class="btn-group ml-3 d-flex align-items-center">
                        <button type="button" class="btn btn-sm dropdown-toggle text-white d-flex align-items-center" data-toggle="dropdown">
                            <i class="fas fa-user fa-lg text-dark"></i>
                            <h5 class="text-dark ml-2 mb-0">Account</h5>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">Sign in</button>
                            <button class="dropdown-item" type="button">Sign up</button>
                        </div>
                    </div>
                </a>
            </div>
    </div>
</div>

<!-- Navbar Start -->
<div class="container-fluid bg-primary mb-30">
    <div class="row px-xl-5 justify-content-around">
        <div class="col-lg-9 ">
            <nav class="navbar navbar-expand-lg navbar-dark py-3 py-lg-0 px-0 ">
                <!-- Logo para dispositivos maiores -->
                <div class="navbar-brand" style="width: 100px; height: auto; padding: 0; margin: 0;">
                    <a href="index.html" class="text-decoration-none">
                        <?= Html::img('img/logoSpotWine.png', ['style' => 'width: 100%; height: auto; display: block;']); ?>
                    </a>
                </div>
                <!-- Botão para colapso -->
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="true">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Conteúdo da Navbar -->
                <div class="navbar-collapse justify-content-between collapse show" id="navbarCollapse">
                    <!-- Links de Navegação -->
                    <div class="navbar-nav mx-auto">

                        <a href="#" class="nav-item nav-link active">Produtores</a>
                        <a href="#" class="nav-item nav-link">Vinhos</a>
                        <a href="#" class="nav-item nav-link">Promoções</a>
                        <a href="#" class="nav-item nav-link">Concurso</a>
                        <a href="#" class="nav-item nav-link">Blogue</a>
                        <!-- Para um item com mais opções
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Pages <i class="fa fa-angle-down mt-1"></i>

                            </a>


                            <div class="dropdown-menu bg-secondary rounded-0 border-0 m-0">
                                <a href="cart.html" class="dropdown-item text-primary">Shopping Cart</a>
                                <a href="checkout.html" class="dropdown-item text-primary">Checkout</a>

                         </div>
                               -->
                    </div>

                </div>

                    <!-- Ícones de Ação -->
                <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                    <div class="d-flex align-items-center">
                        <!-- Heart Icon -->
                        <a href="#" class="btn px-0 ml-3 d-flex align-items-center">
                            <i class="fas fa-heart fa-lg text-secondary"></i>
                            <span class="badge text-third border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>

                        <!-- Cart Icon -->
                        <a href="#" class="btn px-0 ml-3 d-flex align-items-center">
                            <i class="fas fa-shopping-cart fa-lg text-secondary"></i>
                            <span class="badge text-third border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>

                        <!-- User Dropdown -->
                        <div class="btn-group ml-3 d-flex align-items-center">
                            <button type="button" class="btn btn-sm dropdown-toggle text-white d-flex align-items-center" data-toggle="dropdown">
                                <i class="fas fa-user fa-lg text-secondary"></i>
                                <h5 class="text-white ml-2 mb-0">Account</h5>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button">Sign in</button>
                                <button class="dropdown-item" type="button">Sign up</button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

<!-- Navbar End -->

<!-- Search and filter -->
<div class="container-fluid">
    <div class="row align-items-center bg-body py-3 px-xl-5 d-none d-lg-flex">

        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-third m-0" ><i class="fa fa-bars mr-2 text-third"></i>Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <div class="nav-item dropdown dropright">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dresses <i class="fa fa-angle-right float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                            <a href="" class="dropdown-item">Men's Dresses</a>
                            <a href="" class="dropdown-item">Women's Dresses</a>
                            <a href="" class="dropdown-item">Baby's Dresses</a>
                        </div>
                    </div>
                    <a href="" class="nav-item nav-link">Shirts</a>
                    <a href="" class="nav-item nav-link">Jeans</a>
                    <a href="" class="nav-item nav-link">Swimwear</a>
                    <a href="" class="nav-item nav-link">Sleepwear</a>
                    <a href="" class="nav-item nav-link">Sportswear</a>
                    <a href="" class="nav-item nav-link">Jumpsuits</a>
                    <a href="" class="nav-item nav-link">Blazers</a>
                    <a href="" class="nav-item nav-link">Jackets</a>
                    <a href="" class="nav-item nav-link">Shoes</a>
                </div>
            </nav>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for products">
                    <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Search and filter End -->

<main role="main" class="flex-shrink-0 bg-body">
    <div class="container">
        <!-- exibe a navegação em trilhas EX: Página Inicial > Categoria > Subcategoria > Página Atual -->
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?= $this->render('footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
