<?php

use yii\helpers\Html;

?>

<div class="card bg-light mb-4 d-flex flex-column align-items-stretch text-center">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0 text-white">
            <?= Html::encode($model->winery_name) ?>
        </h6>
    </div>
    <div class="product-img position-relative overflow-hidden">
        <?= Html::img('@web/img/produtor.png', [
            'class' => 'img-fluid w-100',
            'alt' => 'Imagem do local de produção',
            'style' => 'max-height: 200px; object-fit: cover;', // Ajusta a imagem para caber no card
        ]) ?>
    </div>
    <div class="card-body">
        <p class="text-muted mb-2">
            <strong>Localização:</strong> <?= Html::encode($model->location) ?>
        </p>
    </div>
    <div class="card-footer bg-transparent mt-auto">
        <?= Html::a('<i class="fa fa-info mr-2"></i> Saber Mais', ['producers/view', 'producer_id' => $model->id], [
            'class' => 'btn btn-primary w-75 mx-auto', // Centraliza e ajusta o botão
            'style' => 'display: block; margin: 0 auto;',
        ]) ?>
    </div>
</div>
