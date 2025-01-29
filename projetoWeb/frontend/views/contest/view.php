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
    <h1 class="mb-3 d-flex justify-content-center align-items-center">
        <?= Html::encode($contest->name) ?>
        <span class="badge <?= $status['class'] ?> ml-2" style="font-size:1rem;"><?= $status['label'] ?></span>
    </h1>


    <div class="d-flex justify-content-around align-items-center">
        <?= Html::img(
            !empty($contest->image_url)
                ? Yii::getAlias('@backendUrl') . '/uploads/contests/' . basename($contest->image_url)
                : Yii::getAlias('@web') . '/img/wineBottle.png',
            [
                'class' => 'img-fluid rounded shadow-sm w-25 mb-4',
                'alt' => Html::encode($contest->name),
            ]
        ) ?>

        <div class="d-flex flex-column">
            <!-- Descrição -->
            <div class="w-75 mx-auto text-justify">

                <p><?= Html::encode($contest->description) ?></p>
            </div>

            <!-- Datas do Concurso -->
            <div class="mt-4 mx-auto text-center">
                <h5 class="text-muted">Período do Concurso</h5>
                <p><strong>Início:</strong> <?= date('d/m/Y', strtotime($contest->contest_start_date)) ?> | <strong>Término:</strong> <?= date('d/m/Y', strtotime($contest->contest_end_date)) ?></p>
            </div>

            <?php if ($contest->status === 'registration'): ?>
                <div class="mt-4 d-flex justify-content-center align-items-baseline ">
                    <i class="fas fa-clock mr-1"></i><h5 class="text-muted">Votação abre em breve...</h5>
                </div>
            <?php elseif ($contest->status === 'voting'): ?>
                <div class="mt-4 d-flex justify-content-center align-items-baseline ">
                    <?= Html::a('Votar', ['contest/vote', 'id' => $contest->id], [
                        'class' => ' px-4 btn btn-warning ml-4'
                    ]) ?>
                </div>
            <?php endif; ?>

            <?php if ($contest->status === 'finished' && $contest->winner_product_id): ?>
                <div class="mt-4 alert alert-success text-center">
                    <h4>🏆 Vencedor: <?= Html::encode($contest->winnerProduct->name) ?> 🏆</h4>
                    <p>Parabéns ao produtor <?= Html::encode($contest->winnerProduct->producers->winery_name) ?>!</p>
                </div>
            <?php endif; ?>



        </div>


    </div>
    <!-- Imagem do Concurso -->

    <!-- Botão Inscreva-se (só aparece se status for "registration") -->






</div>
