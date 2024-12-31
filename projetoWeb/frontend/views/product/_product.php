<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<a href="<?= Url::to(['product/view', 'id' => $model->product->product_id]) ?>" class="product-link text-decoration-none">
    <div class="product-item bg-light mb-4 d-flex flex-column align-items-stretch" style="cursor: pointer;">
        <div class="product-img position-relative overflow-hidden">
            <?= Html::img('@web/img/wineBottle.png', [
                'class' => 'img-fluid w-100',
                'alt' => 'Imagem garrafa de vinho',
            ]) ?>
            <?php if ($model->isOnPromotion()): ?>
                <div class="ribbon bg-danger text-white position-absolute"
                     style="top: 15px; left: -10px; transform: rotate(-45deg); padding: 5px 20px;">
                    Promoção
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center py-4 flex-grow-1 d-flex flex-column justify-content-between">
            <!-- Nome do Produto -->
            <div>
                <div class="d-flex align-items-center justify-content-center mt-2">
                    <?= Html::a(Html::tag('span', $model->product->producers->winery_name ?? 'N/A'), ['producers/view', 'producer_id' => $model->product->producers->id], ['class' => 'text-secondary']) ?>
                </div>
                <h6 class="text-truncate text-dark"><?= Html::encode($model->product->name) ?></h6>
            </div>

            <!-- Preços -->
            <div class="d-flex align-items-center justify-content-center mt-2">
                <?php if ($model->isOnPromotion()): ?>
                    <h5 class="text-muted">
                        <del><?= Html::encode($model->product->price) ?> €</del>
                    </h5>
                    <h5 class="text-danger ml-2 font-weight-bold"><?= Html::encode($model->getFinalPrice()) ?> €</h5>
                <?php else: ?>
                    <h5 class="text-primary"><?= Html::encode($model->product->price) ?> €</h5>
                <?php endif; ?>
            </div>

            <!-- Botão Adicionar ao Carrinho -->
            <div class="mt-2">
                <?php $form = ActiveForm::begin([
                    'action' => ['cart/add'], // Ação no controlador
                    'method' => 'post',
                ]); ?>
                <?= $form->field($cartItemModel, 'product_id')->hiddenInput(['value' => $model->product->product_id])->label(false) ?>
                <?= $form->field($cartItemModel, 'quantity')->hiddenInput(['value' => 1])->label(false) ?>
                <?= Html::submitButton('<i class="fa fa-cart-plus"></i> Adicionar ao Carrinho', [
                    'class' => 'btn-primary',
                    'encode' => false,
                ]) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <span class="h6 text-decoration-none text-truncate"><?= Html::encode($model->name) ?></span>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <small>Categoria: <?= Html::encode($model->categories->name ?? 'N/A') ?></small>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <small>Email do Usuário: <?= Html::encode($model->producers->user->email ?? 'N/A') ?></small>
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
</a>
