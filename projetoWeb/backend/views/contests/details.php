
<?php
use yii\helpers\Html;
use yii\helpers\Url;

// Obtendo as datas do concurso
$startDate = strtotime($contest->registration_start_date);
$endDate = strtotime($contest->registration_end_date);
$now = time();

// Definindo status e cores
if ($now < $startDate) {
    $status = "Inscrições em breve";
    $badgeClass = "badge-secondary";
    $showButton = false;
} elseif ($now >= $startDate && $now <= $endDate) {
    $status = "Inscrições abertas";
    $badgeClass = "badge-success";
    $showButton = true;
} else {
    $status = "Concurso em andamento";
    $badgeClass = "badge-primary";
    $showButton = false;
}
?>

<div class="container text-center">
    <!-- Nome do Concurso e Status -->
    <h1 class="mb-3 d-flex justify-content-center align-items-center gap-2">
        <?= Html::encode($contest->name) ?>
        <span class="badge <?= $badgeClass ?>" style="font-size:1rem;"><?= $status ?></span>
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
        <p><strong>Início:</strong> <?= date('d/m/Y', $startDate) ?> | <strong>Término:</strong> <?= date('d/m/Y', $endDate) ?></p>
    </div>

    <!-- Botão Inscreva-se -->
    <?php if ($showButton): ?>
        <div class="mt-4">
            <?= Html::a('Inscreva-se', ['contests/register-producer', 'id' => $contest->id], [
                'class' => 'btn btn-lg btn-success px-4 shadow-sm'
            ]) ?>
        </div>
    <?php endif; ?>
</div>

