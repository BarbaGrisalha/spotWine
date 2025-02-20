<?php

/** @var yii\web\View $this */


use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';


AppAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!-- Search and filter -->
   <!-- <div class="container-fluid">
        <div class="row align-items-center bg-body py-3 px-xl-5 d-none d-lg-flex justify-content-center">

            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-third m-0" ><i class="fa fa-bars mr-2 text-third"></i>Categories</h6>
                    <i class="fa fa-angle-down text-white"></i>
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
    -->
    <!-- Search and filter End -->

<!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <?= Html::img('@web/img/vinhoTintoCarrossel.jpg', [
                                'class' => 'position-absolute w-100 h-100',
                                'style' => 'object-fit: cover;',
                                'alt' => 'Vinho Tinto Carrossel'
                            ]) ?>

                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Vinhos Tintos</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                    <?=html::a('Ver Mais', ['product/index', 'ProductFrontSearch[category_id]' => 1], ['class' => 'btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp'])?>;
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <?= Html::img('@web/img/vinhoBrancoCarrossel.jpg', [
                                'class' => 'position-absolute w-100 h-100',
                                'style' => 'object-fit: cover;',
                                'alt' => 'Vinho branco Carrossel'
                            ]) ?>
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Vinhos Brancos</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                    <?=html::a('Ver Mais', ['product/index', 'ProductFrontSearch[category_id]' => 2], ['class' => 'btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp'])?>;
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <?= Html::img('@web/img/vinhoRoséCarrossel.jpg', [
                                'class' => 'position-absolute w-100 h-100',
                                'style' => 'object-fit: cover;',
                                'alt' => 'Vinho Rosé Carrossel'
                            ]) ?>
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Vinhos Rosés</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                    <?=html::a('Ver Mais', ['product/index', 'ProductFrontSearch[category_id]' => 3], ['class' => 'btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp'])?>;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <?= Html::img('@web/img/blackFriday.jpg', [
                        'class' => 'img-fluid',
                        'alt' => 'Imagem black friday'
                    ]) ?>
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">até 50%%</h6>
                        <h3 class="text-white mb-3">Black Friday</h3>
                        <a href="" class="btn btn-primary"><span class="text-white">Shop Now</span></a>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <?= Html::img('@web/img/70off.jpg', [
                        'class' => 'img-fluid',
                        'alt' => 'Imagem 70% desconto'
                    ]) ?>
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Poupe até 70%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary"><span class="text-white">Shop Now</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3 text-primary">Coleção por Região</span></h2>
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="product-item d-flex align-items-center mb-4 flex-column">
                        <div class="overflow-hidden mb-3 product-img ">
                            <?= Html::img('@web/img/regiaoDouro.jpg', [
                                'class' => 'img-fluid rounded-circle shadow',
                                'style' => 'width:200px; height:200px;',
                                'alt' => 'Imagem Região do Douro'
                            ]) ?>

                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Vinhos do Douro</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="product-item d-flex align-items-center mb-4 flex-column ">
                        <div class="overflow-hidden mb-3 product-img ">
                            <?= Html::img('@web/img/regiaoAlentejo.jpg', [
                                'class' => 'img-fluid rounded-circle shadow',
                                'style' => 'width:200px; height:200px;',
                                'alt' => 'Imagem Região do Douro'
                            ]) ?>

                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Vinhos do Alentejo</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="product-item d-flex align-items-center mb-4 flex-column ">
                        <div class="overflow-hidden mb-3 product-img ">
                            <?= Html::img('@web/img/regiaoAcores.jpg', [
                                'class' => 'img-fluid rounded-circle shadow',
                                'style' => 'width:200px; height:200px;',
                                'alt' => 'Imagem Região do Douro'
                            ]) ?>

                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Vinhos dos Açores</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="product-item d-flex align-items-center mb-4 flex-column ">
                        <div class="overflow-hidden mb-3 product-img ">
                            <?= Html::img('@web/img/regiaoDao.jpg', [
                                'class' => 'img-fluid rounded-circle shadow',
                                'style' => 'width:200px; height:200px;',
                                'alt' => 'Imagem Região do Douro'
                            ]) ?>

                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Vinhos do Dao</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- Categories End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3 text-center">
        <div class="d-flex justify-content-between">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3 text-primary">Mais Vendidos</span></h2>
            <?= Html::a(html::tag('h5', 'Ver mais',['class' => 'text-secondary']), ['product/index', 'ProductFrontSearch[filter]' => 'mais_vendidos']) ?>
        </div>

            <!--TODO iGUALAR AO RENDER DE PROMOÇOES DA LINHA 317 -->
            <div class="row px-xl-10">
                <?php foreach ($produtosMaisVendidos as $produto): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex">
                        <?= $this->render('@frontend/views/product/_product', [
                            'model' => $produto,
                            'cartItemModel' => $cartItemModel,
                        ]) ?>
                    </div>
                <?php endforeach; ?>
            </div>



    </div>
    <!-- Products End -->


    <!-- Offer Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <?= Html::img('@web/img/bestProducers.jpg', [
                        'class' => 'img-fluid',
                        'alt' => 'Imagem de um produtor'
                    ]) ?>     
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Produtores </h6>
                        <h3 class="text-white mb-3">Mais bem avaliados</h3>
                        <a href="" class="btn btn-primary w-25"><span class="text-white">Ver mais</span></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                <?= Html::img('@web/img/bemAvaliados.jpg', [
                        'class' => 'img-fluid',
                        'alt' => 'Imagem de um produtor'
                    ]) ?>  
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Vinhos</h6>
                        <h3 class="text-white mb-3">Mais bem avaliados</h3>
                        <a href="" class="btn btn-primary w-25"><span class="text-white">Ver mais</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Promotions Start -->
    <div class="container-fluid pt-5 pb-3 text-center">
        <div class="d-flex justify-content-between">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3 text-primary">Promoções</span></h2>
            <?= Html::a(html::tag('h5', 'Ver mais',['class' => 'text-secondary']), ['product/index', 'ProductFrontSearch[filter]' => 'promocoes']) ?>
        </div>
        <div class="row px-xl-10">
            <?php foreach ($produtosEmPromocao as $produto): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex">
                    <?= $this->render('@frontend/views/product/_product', [
                        'model' => $produto,
                        'cartItemModel' => $cartItemModel,
                    ]) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Products End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up text-white"></i></a>

</body>

</html>
<?php $this->endPage(); ?>