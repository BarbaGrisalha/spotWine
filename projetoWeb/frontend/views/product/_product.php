<?php

use yii\helpers\Html;

?>
<div class="product-item bg-light mb-4">
    <div class="product-img position-relative overflow-hidden">
        <?= Html::img('@web/img/wineBottle.png', [
            'class' => 'img-fluid w-100',
            'alt' => 'Imagem garrafa de vinho',
        ]) ?>
        <div class="product-action">
            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
        </div>
    </div>
    <div class="text-center py-4">
        <div class="d-flex align-items-center justify-content-center mt-2">
            <small>Produtor: <?= Html::encode($model->producers->winery_name ?? 'N/A') ?></small>
        </div>
        <span class="h6 text-decoration-none text-truncate"><?= Html::encode($model->name) ?></span>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <small>Categoria: <?= Html::encode($model->categories->name ?? 'N/A') ?></small>
        </div>
        <div class="d-flex align-items-center justify-content-center mb-1">
            <small class="fa fa-star text-primary mr-1"></small>
            <small class="fa fa-star text-primary mr-1"></small>
            <small class="fa fa-star text-primary mr-1"></small>
            <small class="fa fa-star-half-alt text-primary mr-1"></small>
            <small class="far fa-star text-primary mr-1"></small>
            <small>(99)</small>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <h5 class="text-primary"><?= Html::encode($model->price) ?> €</h5>
        </div>
        <!-- Botão ou Link separado -->
        <?= Html::a(Html::tag('span','Ver Produto', ['class' => 'text-white']), ['product/view', 'id' => $model->product_id], [
            'class' => 'btn btn-primary mt-2',
        ]) ?>
    </div>
</div>
