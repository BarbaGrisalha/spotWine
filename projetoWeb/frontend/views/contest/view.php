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

<?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
    <div class="alert alert-<?= $type ?>"><?= $message ?></div>
<?php endforeach; ?>


<div class="container text-center">
    <!-- Nome do Concurso e Status -->
    <h1 class="mb-3 d-flex justify-content-center align-items-center">
        <?= Html::encode($contest->name) ?>
        <span class="badge <?= $status['class'] ?> ml-2" style="font-size:1rem;"><?= $status['label'] ?></span>
    </h1>


    <div class="d-flex justify-content-around align-items-start">
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
                <h2 class="mt-5 text-success">🏆 Vinho Vencedor</h2>
                <div class="card mx-auto mt-3 shadow-lg mb-5" style="max-width: 250px;">
                    <?php $winnerProduct = $contest->winnerProduct; ?>
                    <a href="<?= Url::to(['product/view', 'id' => $winnerProduct->product_id]) ?>">
                        <img src="<?= Yii::getAlias('@backendUrl') . $winnerProduct->image_url ?>" class="card-img-top" alt="<?= Html::encode($winnerProduct->name) ?>">
                    </a>
                    <div class="card-body text-center">
                        <h4 class="card-title font-weight-bold">
                            <a href="<?= Url::to(['product/view', 'id' => $winnerProduct->product_id]) ?>" class="text-decoration-none text-dark">
                                <?= Html::encode($winnerProduct->name) ?>
                            </a>
                        </h4>
                        <p class="card-text">🍇 Produtor: <?= Html::encode($winnerProduct->producers->winery_name) ?></p>
                        <a href="<?= Url::to(['product/view', 'id' => $winnerProduct->product_id]) ?>" class="btn btn-primary">
                            Ver Produto
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>



</div>
