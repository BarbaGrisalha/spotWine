<?php

use common\models\Favorites;
use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$productId = $model->product->product_id;

?>

<div class="product-item bg-light mb-4 d-flex flex-column align-items-stretch position-relative h-100" style="cursor: pointer;">
    <!-- Ícone de Favorito -->
    <div class="position-absolute" style="top: 10px; right: 10px; z-index: 10;">
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php $product = Product::findOne($productId) ?>
            <a href="<?= Url::to(['favorites/toggle-favorite', 'productId' => $productId]) ?>" class="btn btn-link" onclick="event.stopPropagation(); return false;">
                <?php if ($product->isFavorited()): ?>
                    <i class="fa fa-heart fa-lg text-danger"></i>
                <?php else: ?>
                    <i class="fa fa-heart fa-lg text-muted"></i>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    </div>

    <!-- Link para a página do produto -->
    <a href="<?= Url::to(['product/view', 'id' => $productId]) ?>" class="text-decoration-none d-block">
        <!-- Imagem do Produto -->
        <div class="product-img position-relative overflow-hidden" style="height: 280px;">
            <?= Html::img(
                !empty($model->product->image_url)
                    ? Yii::getAlias('@backendUrl') . $model->product->image_url
                    : Yii::getAlias('@web') . '/img/wineBottle.png',
                [
                    'class' => 'img-fluid w-100 h-100 object-fit-cover',
                    'alt' => Html::encode($model->product->name),
                ]
            ) ?>
        </div>

        <!-- Nome e Produtor -->
        <div class="text-center py-3">
            <h5 class="text-truncate text-dark mb-1"><?= Html::encode($model->product->name) ?></h5>
            <small class="text-muted">
                <?= Html::a(Html::encode($model->product->producers->winery_name ?? 'N/A'), ['producers/view', 'producer_id' => $model->product->producers->id], ['class' => 'text-secondary', 'onclick' => 'event.stopPropagation(); return false;']) ?>
            </small>
        </div>
    </a>

    <!-- Preços e Botão de Adicionar ao Carrinho (sem espaços excessivos) -->
    <div class="text-center p-2">
        <div class="d-flex align-items-center justify-content-center">
            <?php if ($model->isOnPromotion()): ?>
                <h5 class="text-muted mb-0">
                    <del><?= Html::encode($model->product->price) ?> €</del>
                </h5>
                <h5 class="text-danger ml-2 font-weight-bold mb-0"><?= Html::encode($model->getFinalPrice()) ?> €</h5>
            <?php else: ?>
                <h5 class="text-primary mb-0"><?= Html::encode($model->product->price) ?> €</h5>
            <?php endif; ?>
        </div>

        <!-- Botão Adicionar ao Carrinho -->
        <?php $form = ActiveForm::begin([
            'action' => ['cart/add'],
            'method' => 'post',
            'options' => ['class' => 'mt-2', 'onsubmit' => 'event.stopPropagation();']
        ]); ?>
        <?= $form->field($cartItemModel, 'product_id')->hiddenInput(['value' => $model->product->product_id])->label(false) ?>
        <?= $form->field($cartItemModel, 'quantity')->hiddenInput(['value' => 1])->label(false) ?>
        <?= Html::submitButton('<i class="fa fa-cart-plus"></i> Adicionar ao Carrinho', [
            'class' => 'btn btn-primary w-100',
            'encode' => false,
            'onclick' => 'event.stopPropagation();'
        ]) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
