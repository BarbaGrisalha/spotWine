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
    <?= Html::tag('link', '', ['rel' => 'icon', 'href' => Url::to('@web/img/favicon.ico')]) ?>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <?= Html::cssFile('@web/css/style.css') ?>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <?= Html::jsFile('@web/js/main.js') ?>



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
                            <button class="dropdown-item" type="button">
                                <?= Html::a('Logar', Url::to(['site/login']), ['class' => 'btn btn-primary'])?>
                            </button>
                            <button xclass="dropdown-item" type="button">Sign up</button>
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
                    <a href="<?= \yii\helpers\Url::to(['/site/index'], true) ?>" class="text-decoration-none">
                        <?= Html::img('@web/img/logoSpotWine.png', ['style' => 'width: 100%; height: auto; display: block;']); ?>
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

                        <a href="#" class="nav-item nav-link active">Vinhos</a>
                        <a href="#" class="nav-item nav-link">Produtores</a>
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
                                <button class="dropdown-item btn btn-secondary" type="button">
                                    <?= Html::a('Login', Url::to(['site/login']))?>
                                </button>
                                <button class="dropdown-item btn btn-secondary" type="button">
                                    <?= Html::a('Registar-Se', Url::to(['site/signup']))?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

<!-- Navbar End -->

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



<?= $this->render('footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
