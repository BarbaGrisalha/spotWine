<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var frontend\models\promocoesViewModel $productView */

$this->title = $productView->product->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="product-view container py-4">
    <div class="row">
        <!-- Imagem do Produto -->
        <div class="col-md-6 text-center">
            <?= Html::img('@web/img/wineBottle.png', [
                'class' => 'img-fluid w-75',
                'alt' => 'Imagem garrafa de vinho',
            ]) ?>
        </div>

        <!-- Detalhes do Produto -->
        <div class="col-md-6">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="text-muted"><?= Html::encode($productView->product->producers->winery_name ?? 'N/A') ?></p>

            <!-- Avaliação -->
            <div class="d-flex align-items-center mb-2">
                <small class="fa fa-star text-primary mr-1"></small>
                <small class="fa fa-star text-primary mr-1"></small>
                <small class="fa fa-star text-primary mr-1"></small>
                <small class="fa fa-star-half-alt text-primary mr-1"></small>
                <small class="far fa-star text-primary mr-1"></small>
                <small>(99)</small>
            </div>

            <!-- Preço -->
            <?php if ($productView->isOnPromotion()): ?>
                <div class="promotion-highlight p-3 mb-4" style="border: 2px solid #dc3545; border-radius: 10px; background: #ffe6e6;">
                    <p class="mb-1 text-danger font-weight-bold">Produto em Promoção!</p>
                    <p class="mb-1">
                        <span class="text-muted">Preço Original:</span> <del class="text-muted"><?= Html::encode($productView->product->price) ?>€</del>
                    </p>
                    <p>
                        <span class="text-success font-weight-bold">Preço Promocional:</span>
                        <strong><?= Html::encode($productView->getFinalPrice()) ?>€</strong>
                    </p>
                </div>
            <?php else: ?>
                <p>Preço: <strong><?= Html::encode($productView->product->price) ?>€</strong></p>
            <?php endif; ?>

            <!-- Botões de Quantidade e Adicionar ao Carrinho -->
            <div class="d-flex align-items-center mb-4">
                <div class="input-group quantity" style="max-width: 120px;">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary btn-minus" type="button">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <?= Html::textInput('quantity', '1', [
                        'class' => 'form-control text-center']) ?>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-plus" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <?= Html::button(
                    '<i class="fa fa-shopping-cart mr-2 text-white"></i><span class="text-white">Adicionar ao Carrinho</span>',
                    ['class' => 'btn btn-primary ml-3']
                ) ?>
            </div>

            <!-- Abas de Informações -->
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Descrição</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Produtor</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Avaliações</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?= Html::encode($productView->product->description ?? 'Descrição indisponível') ?>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?= Html::encode($productView->product->producers->winery_name ?? 'Informações do produtor indisponíveis') ?>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    Avaliações dos clientes.
                </div>
            </div>
        </div>
    </div>
</div>


