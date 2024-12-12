<?php

use yii\helpers\Html;

?>
<div class="container-fluid pt-5 pb-3 text-center">
    <div class="d-flex justify-content-between">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3 text-primary">Promoções</span>
        </h2>
        <?= Html::a('Ver Tudo', ['product/index', 'ProductFrontSearch[filter]' => 'promocoes'], [
            'class' => 'btn btn-primary',
        ]) ?>
    </div>

    <div class="row px-xl-10">
        <?php foreach ($produtosEmPromocao as $promotion): ?>
            <?php foreach ($promotion->products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <?= Html::img('@web/img/wineBottle.png', ['class' => 'img-fluid w-100']) ?>
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <h5 class="text-primary">
                                <del><?= Html::encode($product->price) ?>€</del>
                                <?= Html::encode($promotion->discount_type === 'percent'
                                    ? $product->price * (1 - $promotion->discount_value / 100)
                                    : $product->price - $promotion->discount_value
                                ) ?>€
                            </h5>
                            <a class="h6 text-decoration-none text-truncate" href="#">
                                <?= Html::encode($product->name) ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>
