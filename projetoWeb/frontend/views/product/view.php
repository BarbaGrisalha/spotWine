<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = $model->name;
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
            <p class="text-muted"><?= Html::encode($model->producers->winery_name ?? 'N/A') ?></p>

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
            <?= Html::tag('h2', Html::encode($model->price) . ' €', ['class' => 'text-primary mb-4']) ?>

            <div class="d-flex align-items-center mb-4">
                <!-- Campo de Quantidade -->
                <div class="input-group quantity" style="max-width: 120px;">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary btn-minus" type="button">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- TODO VALIDAR CAMPO DE ENTRADA PRA SER APENAS NUMBER -->
                    <?= Html::textInput('quantity', '1', [
                        'class' => 'form-control text-center']) ?>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-plus" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>


                <!-- Botão Adicionar ao Carrinho -->
                <?= Html::button(
                    '<i class="fa fa-shopping-cart mr-2 text-white"></i><span class="text-white">Adicionar ao Carrinho</span>',
                    ['class' => 'btn btn-primary']
                ) ?>
            </div>


            <!-- Abas -->
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
                    <?= Html::encode($model->description ?? 'Descrição indisponível') ?>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?= Html::encode($model->producers->winery_name ?? 'Informações do produtor indisponíveis') ?>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <!-- Avaliações podem ser carregadas aqui -->
                    Avaliações dos clientes.
                </div>
            </div>
        </div>
    </div>
</div>


