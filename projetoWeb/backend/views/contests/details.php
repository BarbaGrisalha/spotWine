<?php

use common\models\CartItems;
use frontend\models\PromocoesViewModel;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

// Mapeia os status para rótulos e cores
$statusLabels = [
    'pending' => ['label' => 'Inscrições em breve', 'class' => 'badge-secondary'],
    'registration' => ['label' => 'Inscrições abertas', 'class' => 'badge-success'],
    'voting' => ['label' => 'Concurso em andamento', 'class' => 'badge-primary'],
    'finished' => ['label' => 'Concurso finalizado', 'class' => 'badge-dark'],
];

$status = $statusLabels[$contest->status];
?>

<div class="container text-center">
    <!-- Nome do Concurso e Status -->
    <h1 class="mb-3 d-flex justify-content-center align-items-center gap-2">
        <?= Html::encode($contest->name) ?>
        <span class="badge <?= $status['class'] ?>" style="font-size:1rem;"><?= $status['label'] ?></span>
    </h1>

    <!-- Imagem do Concurso -->
    <img src="<?= Yii::getAlias('@web') . $contest->image_url ?>" alt="Contest image" class="img-fluid rounded shadow-sm w-25 mb-4">

    <!-- Descrição -->
    <div class="w-75 mx-auto text-left">
        <h4 class="mb-2">Descrição</h4>
        <p><?= Html::encode($contest->description) ?></p>
    </div>

    <!-- Datas do Concurso -->
    <div class="mt-4">
        <h5 class="text-muted">Período do Concurso</h5>
        <p><strong>Início:</strong> <?= date('d/m/Y', strtotime($contest->contest_start_date)) ?> | <strong>Término:</strong> <?= date('d/m/Y', strtotime($contest->contest_end_date)) ?></p>
    </div>

    <?php if ($contest->status === 'registration'): ?>
        <div class="mt-4">
            <?= Html::a('Inscreva-se', ['contests/register-producer', 'id' => $contest->id], [
                'class' => 'btn btn-lg btn-success px-4 shadow-sm'
            ]) ?>
        </div>
    <?php endif; ?>

    <?php if ($contest->status === 'finished' && $contest->winner_product_id): ?>
        <h2 class="mt-5 text-success">🏆 Vinho Vencedor</h2>
        <div class="card mx-auto mt-3 shadow-lg" style="max-width: 300px;">
            <?php $winnerProduct = $contest->winnerProduct; ?>
            <img src="<?= Yii::getAlias('@web') . $winnerProduct->image_url ?>" class="card-img-top" alt="<?= $winnerProduct->name ?>">
            <div class="card-body text-center">
                <h4 class="card-title font-weight-bold"><?= Html::encode($winnerProduct->name) ?></h4>
                <p class="card-text">🍇 Produtor: <?= Html::encode($winnerProduct->producers->winery_name) ?></p>
                <span class="badge bg-warning text-dark p-2">Mais votado 🏅</span>
            </div>
        </div>
    <?php endif; ?>




</div>
