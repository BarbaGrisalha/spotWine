<?php

/** @var View $this */

/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use frontend\widgets\CartWidget;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;

//use yii\bootstrap5\Html;


BootstrapAsset::register($this);
AppAsset::register($this);

$user = Yii::$app->user->identity;
/** @var common\models\User $user */

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


        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>

        <!-- Contact Javascript File -->
        <?= $this->registerJsFile('@web/js/jqBootstrapValidation.min.js', ['depends' => [JqueryAsset::className()]]); ?>
        <?= $this->registerJsFile('@web/js/contact.js', ['depends' => [JqueryAsset::className()]]); ?>

        <!-- Customized Bootstrap Stylesheet -->
        <?= Html::cssFile('@web/css/style.css') ?>
        <!-- Template Javascript -->

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
                    <span class="badge text-dark border border-dark rounded-circle"
                          style="padding-bottom: 2px;">0</span>
                </a>
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle"
                          style="padding-bottom: 2px;">0</span>
                </a>
                <a href="" class="btn px-0 ml-2">
                    <!-- User Dropdown -->
                    <div class="btn-group ml-3 d-flex align-items-center">
                        <button type="button" class="btn btn-sm dropdown-toggle text-white d-flex align-items-center"
                                data-toggle="dropdown">
                            <i class="fas fa-user fa-lg text-dark"></i>
                            <h5 class="text-dark ml-2 mb-0">Account</h5>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">
                                <?= Html::a('Logar', Url::to(['site/login']), ['class' => 'btn btn-primary']) ?>
                            </button>
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
                        <a href="<?= Url::to(['/site/index'], true) ?>" class="text-decoration-none">
                            <?= Html::img('@web/img/logoSpotWine.png', ['style' => 'width: 100%; height: auto; display: block;']); ?>
                        </a>
                    </div>
                    <!-- Botão para colapso -->
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse"
                            aria-expanded="true">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Conteúdo da Navbar -->
                    <div class="navbar-collapse justify-content-between collapse show" id="navbarCollapse">
                        <!-- Links de Navegação -->
                        <div class="navbar-nav mx-auto">

                            <?= Html::a('Vinhos', Url::to(['/product/index']), ['class' => 'nav-item nav-link']) ?>
                            <?= Html::a('Produtores', Url::to(['/producers/index']), ['class' => 'nav-item nav-link']) ?>
                            <?= Html::a('Promoções', Url::to(['/product/index', 'ProductFrontSearch[filter]' => 'promocoes']), ['class' => 'nav-item nav-link']) ?>
                            <?= Html::a('Concurso', Url::to(['/contest/index']), ['class' => 'nav-item nav-link']) ?>
                            <?= Html::a('Blogue', Url::to(['/blog-post/index']), ['class' => 'nav-item nav-link']) ?>
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
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <!-- Favorites and Cart Section -->
                            <div class="d-flex align-items-center">
                                <!-- Heart Icon -->
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <a href="<?= Url::to(['/favorites/index']) ?>"
                                       class="btn px-0 ml-3 d-flex align-items-center">
                                        <i class="fas fa-heart fa-lg text-secondary"></i>
                                        <span class="badge text-third border border-secondary rounded-circle"
                                              style="padding-bottom: 2px;">
                                            <?= Yii::$app->user->identity->getFavorites()->count() ?>
                                        </span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= Url::to(['/favorites/index']) ?>"
                                       class="btn px-0 ml-3 d-flex align-items-center">
                                        <i class="fas fa-heart fa-lg text-secondary"></i>
                                        <span class="badge text-third border border-secondary rounded-circle"
                                              style="padding-bottom: 2px;">
                                            0
                                        </span>
                                    </a>
                                <?php endif; ?>
                                <!-- CART -->
                                <?= CartWidget::widget() ?>

                            </div>

                            <!-- Space between sections -->
                            <div class="mx-4"></div>

                            <!-- User Dropdown Section -->
                            <div class="d-flex align-items-center">
                                <div class="btn-group">
                                    <?php if (Yii::$app->user->isGuest): ?>
                                        <a class="btn btn-primary mr-2" href="<?= Url::to(['/site/signup']) ?>">
                                            <span class="text-white">Registo</span>
                                        </a>
                                        <a class="btn btn-primary" href="<?= Url::to(['/site/login']) ?>">
                                            <span class="text-white">Login</span>
                                        </a>
                                    <?php else: ?>
                                        <?php $idUser = Yii::$app->user->id; ?>
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-user-circle fa-lg mr-2 text-secondary"></i><?= $user->username ?>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <?= Html::a(
                                                    '<i class="fas fa-user fa-lg text-secondary mr-2"></i> Ver Perfil',
                                                    ['/perfil/view', 'id' => $idUser],
                                                    ['class' => 'dropdown-item']
                                                ) ?>
                                                <?= Html::a(
                                                    '<i class="fas fa-edit fa-lg text-secondary mr-2"></i> Alterar Dados',
                                                    ['/perfil/update', 'id' => $idUser],
                                                    ['class' => 'dropdown-item']
                                                ) ?>
                                                <?= Html::a(
                                                    '<i class="fas fa-star fa-lg text-secondary mr-2"></i> Minhas Avaliações',
                                                    ['/avaliacao/index'],
                                                    ['class' => 'dropdown-item']
                                                ) ?>
                                                <?= Html::a(
                                                    '<i class="fas fa-file-invoice fa-lg text-secondary mr-2"></i> Minhas Faturas',
                                                    ['/account/invoices'],
                                                    ['class' => 'dropdown-item']
                                                ) ?>
                                                <?= Html::a(
                                                    '<i class="fas fa-key fa-lg text-secondary mr-2"></i> Alterar Password',
                                                    ['/account/change-password'], ['class' => 'dropdown-item']
                                                ) ?>
                                                <?= Html::beginForm(['/site/logout'], 'post', ['id' => 'logout-form']) ?>
                                                <?= Html::submitButton(
                                                    '<i class="fas fa-sign-out-alt fa-lg text-secondary mr-2"></i> Logout',
                                                    ['class' => 'dropdown-item']
                                                ) ?>
                                                <?= Html::endForm() ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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
