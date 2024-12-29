<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="dropdown ml-3">
    <button id="dropdownCart" class="btn px-0 d-flex align-items-center" type="button">
        <i class="fas fa-shopping-cart fa-lg text-secondary"></i>
        <span class="badge text-third border border-secondary rounded-circle" style="padding-bottom: 2px;">
            <?= count($cartItems) ?>
        </span>
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
                    <div class="dropdown-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= Html::encode($model->product->name) ?></strong>
                            <!--TODO MUDAR A QUANTIDADE PARA SER UM INPUT QUE AUMENTA E DIMINUI , ALGO EDITÁVEL -->
                            <small class="d-block text-muted"><?= $model->quantity ?>x</small>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <?php if ($model->isOnPromotion()): ?>
                                <h5 class="text-muted"><del><?= Html::encode($model->product->price) ?> €</del></h5>
                                <h5 class="text-danger ml-2 font-weight-bold"><?= Html::encode($model->getFinalPrice()) ?> €</h5>
                            <?php else: ?>
                                <h5 class="text-primary"><?= Html::encode($model->product->price) ?> €</h5>
                            <?php endif; ?>

                            <!-- Formulário para deletar o item -->
                            <?php $form = ActiveForm::begin([
                                'action' => ['cart/delete', 'id' => $model->product->product_id],
                                'method' => 'post',
                                'options' => ['class' => 'd-inline-block'], // Evita quebra de layout
                            ]); ?>
                            <?= Html::submitButton('<i class="fas fa-trash "></i>', [
                                'class' => 'btn btn-outline-danger ml-2 delete-item',
                                'data' => ['confirm' => 'Tem certeza que deseja remover este item do carrinho?'],
                                'title' => 'Remover do Carrinho',
                            ]) ?>
                            <?php ActiveForm::end(); ?>
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
