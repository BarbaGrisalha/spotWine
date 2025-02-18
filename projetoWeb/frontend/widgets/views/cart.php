<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<div class="dropdown ml-3">
    <button id="dropdownCart" class="btn px-0 d-flex align-items-center" type="button">
        <?php if($versaonova):?>
        <i class="fas fa-shopping-cart fa-lg text-dark"></i>
        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">
            <?= count($cartItems) ?>
        </span>
        <?php else:?>
        <i class="fas fa-shopping-cart fa-lg text-secondary"></i>
        <span class="badge text-third border border-secondary rounded-circle" style="padding-bottom: 2px;">
            <?= count($cartItems) ?>
        </span>
        <?php endif; ?>
    </button>
    <div class="cart-dropdown shadow-lg rounded" aria-labelledby="dropdownCart">
        <div class="d-flex justify-content-between align-items-baseline">
            <h5 class="dropdown-header">O seu carrinho</h5>
            <?= Html::a('Ver Carrinho', ['cart/index'], ['class' => 'text-secondary']) ?>
        </div>
        <div class="dropdown-divider"></div>
        <?php if (empty($cartItems)): ?>
            <div class="align-content-center text-center h-75">
                <i class="fas fa-cart-arrow-down fa-4x text-dark"></i>
                <p class="dropdown-item text-muted">Seu carrinho está vazio.</p>
                <?= Html::a(Html::button('Começar a comprar', ['class' => 'btn btn-primary']), 'product/index') ?>
            </div>
        <?php else: ?>

            <div class="cart-items">
                <?php foreach ($cartViewModels as $model): ?>
                    <div class="dropdown-item d-flex align-items-center h-100">
                        <!-- Imagem do Produto -->
                        <div class="product-img position-relative overflow-hidden flex-shrink-0" style="width: 120px; height: 120px;">
                            <?= Html::img(
                                !empty($model->product->image_url)
                                    ? Yii::getAlias('@backendUrl') . '/uploads/products/' . basename($model->product->image_url)
                                    : Yii::getAlias('@web') . '/img/wineBottle.png',
                                [
                                    'class' => 'img-fluid w-100 h-100 object-fit-cover',
                                    'alt' => Html::encode($model->product->name),
                                ]
                            ) ?>
                        </div>

                        <!-- Detalhes do Produto -->
                        <div class="d-flex flex-column flex-grow-1 ml-3">
                            <h5 class="text-truncate mb-2"><?= Html::encode($model->product->name) ?></h5>
                            <small class="text-muted text-secondary mb-4">Quantidade: <?= $model->quantity ?></small>

                            <!-- Preços -->
                            <div class="d-flex gap-2 align-items-center">
                                <?php if ($model->isOnPromotion()): ?>
                                    <h6 class="text-muted"><del><?= Html::encode($model->product->price) ?> €</del></h6>
                                    <h6 class="text-danger font-weight-bold"><?= Html::encode($model->getFinalPrice()) ?> €</h6>
                                <?php else: ?>
                                    <h6 class="text-primary"><?= Html::encode($model->product->price) ?> €</h6>
                                <?php endif; ?>
                            </div>
                            <!-- Botão de Remover -->
                            <div class="ml-auto">
                                <?php $form = ActiveForm::begin([
                                    'action' => ['cart/delete', 'id' => $model->product->product_id],
                                    'method' => 'post',
                                    'options' => ['class' => 'd-inline-block'],
                                ]); ?>
                                <?= Html::submitButton('<i class="fas fa-trash"></i>', [
                                    'class' => 'btn btn-outline-danger delete-item',
                                    'data' => ['confirm' => 'Tem certeza que deseja remover este item do carrinho?'],
                                    'title' => 'Remover do Carrinho',
                                ]) ?>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>


                    </div>
                    <div class="dropdown-divider"></div>
                <?php endforeach; ?>
            </div>

            <div class="btn btn-primary btn-xs d-flex align-items-center justify-content-center px-4 ">
                <!--TODO: SE NAO TIVER LOGADO E QUISER FINALIZAR COMPRA VAI SER REDIRECIONADO PARA O LOGIN -->
                <?= Html::a(
                    '<div class="d-flex align-items-center ">
                            <i class="fas fa-shopping-bag fa-lg mr-3"></i>
                            <span class="font-weight-bold mr-2">Finalizar Compra - </span>
                            <span class="font-weight-bold">' . Yii::$app->formatter->asCurrency($totalAmount, 'EUR') . ' EUR</span>
                        </div>',
                    ['checkout/index'],
                    [
                        'class' => 'text-decoration-none text-reset',
                        'encode' => false,
                    ]
                ) ?>
            </div>
        <?php endif; ?>
    </div>
</div>
