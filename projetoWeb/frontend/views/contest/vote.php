<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Votação - " . Html::encode($contest->name);
?>

<div class="container text-center">
    <h1 class="mb-4"><?= Html::encode($contest->name) ?></h1>

    <p class="lead"><?= Html::encode($contest->description) ?></p>

    <h3 class="mt-4">Vote em um dos produtos abaixo:</h3>

    <div class="row">
        <?php foreach ($products as $participation): ?>
            <?php $product = $participation->product; ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 d-flex flex-column align-items-center p-3">
                    <!-- Imagem do Produto -->
                    <?= Html::img(
                        !empty($product->image_url)
                            ? Yii::getAlias('@backendUrl') . '/uploads/products/' . basename($product->image_url)
                            : Yii::getAlias('@web') . '/img/wineBottle.png',
                        [
                            'class' => 'img-fluid w-75 ',
                            'alt' => Html::encode($product->name),
                        ]
                    ) ?>

                    <div class="card-body text-center">
                        <h5 class="card-title"><?= Html::encode($product->name) ?></h5>
                        <p class="text-muted"><?= Html::encode($product->producers->winery_name) ?></p>

                        <?php if ($hasVoted): ?>
                            <button class="btn btn-secondary" disabled>✅ Você já votou neste concurso!</button>
                        <?php else: ?>
                            <?= Html::a(
                                '<i class="fas fa-check-circle"></i> Votar',
                                ['submit-vote', 'contest_id' => $contest->id, 'product_id' => $product->product_id],
                                [
                                    'class' => 'btn btn-success',
                                    'data-confirm' => 'Tem certeza que deseja votar neste produto?',
                                ]
                            ) ?>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
