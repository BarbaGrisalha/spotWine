<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var frontend\models\promocoesViewModel $productView */
/** @var common\models\Reviews $reviewModel */
/** @var array $reviews */

$this->title = $productView->product->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="product-view container py-4">
    <div class="row">
        <!-- Imagem do Produto -->
        <div class="col-md-6 text-center">
            <?= Html::img(
                !empty($productView->product->image_url)
                    ? Yii::getAlias('@backendUrl') . $productView->product->image_url
                    : Yii::getAlias('@web') . '/img/wineBottle.png',
                [
                    'class' => 'img-fluid w-50',
                    'alt' => Html::encode($productView->product->name),
                ]
            ) ?>
        </div>

        <!-- Detalhes do Produto -->
        <div class="col-md-6">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="text-muted"><?= Html::encode($productView->product->producers->winery_name ?? 'N/A') ?></p>

            <!-- Avaliação Média -->
            <div class="d-flex align-items-center mb-2">
                <?php $averageRating = round(array_sum(array_column($reviews, 'rating')) / max(count($reviews), 1)); ?>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <small class="fa <?= $i <= $averageRating ? 'fa-star text-yellow' : 'fa-star-o text-secondary' ?> mr-1"></small>
                <?php endfor; ?>
                <small>(<?= count($reviews) ?> avaliações)</small>
            </div>

            <!-- Preço -->
            <?php if ($productView->isOnPromotion()): ?>
                <div class="promotion-highlight p-3 mb-4"
                     style="border: 2px solid #dc3545; border-radius: 10px; background: #ffe6e6;">
                    <p class="mb-1 text-danger font-weight-bold">Produto em Promoção!</p>
                    <p class="mb-1">
                        <span class="text-muted">Preço Original:</span>
                        <del class="text-muted"><?= Html::encode($productView->product->price) ?>€</del>
                    </p>
                    <p>
                        <span class="text-success font-weight-bold">Preço Promocional:</span>
                        <strong><?= Html::encode($productView->getFinalPrice()) ?>€</strong>
                    </p>
                </div>
            <?php else: ?>
                <p>Preço: <strong><?= Html::encode($productView->product->price) ?>€</strong></p>
            <?php endif; ?>

            <div class="d-flex align-items-center mb-4">
                <?php $form = ActiveForm::begin([
                    'action' => ['cart/add'], // Ação no controlador
                    'method' => 'post',
                ]); ?>

                <!-- Campo oculto para o ID do produto -->
                <?= $form->field($cartItemModel, 'product_id')->hiddenInput(['value' => $productView->product->product_id])->label(false) ?>

                <div class="input-group quantity mb-3" style="max-width: 150px;">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary btn-minus p-0" type="button"
                                style="width: 40px; height: 38px;">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <?= $form->field($cartItemModel, 'quantity')->textInput([
                        'class' => 'form-control text-center quantity-input',
                        'value' => 1, // Valor inicial
                        'style' => 'width: 60px; height: 38px;', // Garante o mesmo tamanho que os botões
                    ])->label(false) ?>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-plus p-0" type="button"
                                style="width: 40px; height: 38px;">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>


                <!-- Botão de Adicionar ao Carrinho -->
                <?= Html::submitButton('<i class="fa fa-cart-plus"></i> Adicionar ao Carrinho', [
                    'class' => 'btn btn-primary ml-3',
                    'encode' => false,
                ]) ?>

                <?php ActiveForm::end(); ?>
            </div>


            <!-- Abas de Informações -->
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button"
                            role="tab" aria-controls="home" aria-selected="true">Descrição
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="reviews-tab" data-toggle="tab" data-target="#reviews" type="button"
                            role="tab" aria-controls="reviews" aria-selected="false">Avaliações
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="rate-tab" data-toggle="tab" data-target="#rate" type="button"
                            role="tab" aria-controls="rate" aria-selected="false">Avaliar
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?= Html::encode($productView->product->description ?? 'Descrição indisponível') ?>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <!-- Avaliações dos Clientes -->
                    <!-- TODO: SE PASSAR DE 4 REVIEWS COLOCAR PAGINAÇÃO OU SE FOR MAIS FÁCIL SE TIVER MAIS DE 4 APARECE O BOTAO PARA VER TODOS QUE LEVA PARA UM INDEX COM TODOS OS REVIEWS-->
                    <div class="customer-reviews">
                        <?php if (!empty($reviews)): ?>
                            <?php foreach (array_slice($reviews, 0, 4) as $review): ?>
                                <div class="review mb-3">
                                    <strong><?= Html::encode($review->user->username) ?>:</strong>
                                    <div class="stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <small class="fa <?= $i <= $review->rating ? 'fa-star text-yellow' : 'fa-star-o text-secondary' ?>"></small>
                                        <?php endfor; ?>
                                    </div>
                                    <p><?= Html::encode($review->comment) ?></p>
                                    <small class="text-muted">Postado
                                        em <?= Yii::$app->formatter->asDate($review->created_at) ?></small>
                                </div>
                                <hr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Este produto ainda não possui avaliações.</p>
                        <?php endif; ?>
                    </div>

                    <?php if (count($reviews) > 4): ?>
                        <div class="text-center mt-3">
                            <?= Html::a('Ver Todas as Avaliações', ['reviews/index', 'productId' => $productView->product->product_id], [
                                'class' => 'btn btn-outline-primary',
                            ]) ?>
                        </div>
                    <?php endif; ?>


                </div>
                <div class="tab-pane fade" id="rate" role="tabpanel" aria-labelledby="rate-tab">
                    <!-- Formulário de Avaliação -->
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <div class="leave-review mt-4">
                            <h4>Deixe sua Avaliação</h4>
                            <?php $form = ActiveForm::begin([
                                'action' => ['product/review', 'id' => $productView->product->product_id],
                                'method' => 'post',
                            ]); ?>

                            <?= $form->field($reviewModel, 'rating')->dropDownList([
                                5 => '★★★★★ - Excelente',
                                4 => '★★★★☆ - Muito Bom',
                                3 => '★★★☆☆ - Bom',
                                2 => '★★☆☆☆ - Regular',
                                1 => '★☆☆☆☆ - Ruim',
                            ], [
                                'prompt' => 'Escolha a quantidade de estrelas',
                                'class' => 'form-control star-dropdown',
                            ]) ?>


                            <?= $form->field($reviewModel, 'comment')->textarea(['rows' => 4, 'placeholder' => 'Escreva seu comentário aqui...']) ?>

                            <?= Html::submitButton('Enviar Avaliação', ['class' => 'btn btn-primary']) ?>

                            <?php ActiveForm::end(); ?>
                        </div>
                    <?php else: ?>
                        <p>Faça login para deixar sua avaliação.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>
