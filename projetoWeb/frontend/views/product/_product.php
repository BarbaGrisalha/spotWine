<?php

use yii\helpers\Html;

?>
<div class="product-item bg-light mb-4 d-flex flex-column align-items-stretch">
    <div class="product-img position-relative overflow-hidden">
        <?= Html::img('@web/img/wineBottle.png', [
            'class' => 'img-fluid w-100',
            'alt' => 'Imagem garrafa de vinho',
        ]) ?>
        <?php if ($model->isOnPromotion()): ?>
            <div class="ribbon bg-danger text-white position-absolute" style="top: 10px; left: -10px; transform: rotate(-45deg); padding: 5px 20px;">
                Promoção
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center py-4 flex-grow-1 d-flex flex-column justify-content-between">
        <!-- Nome do Produto -->
        <div>
            <h6 class="text-truncate"><?= Html::encode($model->product->name) ?></h6>
            <div class="d-flex align-items-center justify-content-center mt-2">
                <small>Categoria: <?= Html::encode($model->product->categories->name ?? 'N/A') ?></small>
            </div>
        </div>

        <!-- Preços -->
        <div class="d-flex align-items-center justify-content-center mt-2">
            <?php if ($model->isOnPromotion()): ?>
                <h5 class="text-muted"><del><?= Html::encode($model->product->price) ?> €</del></h5>
                <h5 class="text-danger ml-2 font-weight-bold"><?= Html::encode($model->getFinalPrice()) ?> €</h5>
            <?php else: ?>
                <h5 class="text-primary"><?= Html::encode($model->product->price) ?> €</h5>
            <?php endif; ?>
        </div>

        <!-- Botão -->
        <div class="mt-2">
            <?= Html::a(
                    html::tag('span', 'Ver Produto', ['class' => 'text-white']),
                ['product/view', 'id' => $model->product->product_id], [
                'class' => 'btn btn-primary',
            ]) ?>
        </div>
    </div>
</div>
