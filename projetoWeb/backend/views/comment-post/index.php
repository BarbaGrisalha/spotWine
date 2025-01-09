<?php

use yii\helpers\Html;
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>


<?php foreach ($comments as $comment): ?>
    <p class="text-muted">
        <i class="fas fa-user"></i> <?= Html::encode($comment->user->username ?? 'Desconhecido') ?> |
        <i class="far fa-clock"></i> <?= Yii::$app->formatter->asDate($comment->created_at, 'long') ?>
    </p>

    <div class="mb-4 p-3 bg-light rounded">
        <h4 class="fs-3"><?= nl2br(Html::encode($comment->comment_text)) ?></h4>
    </div>
<?php endforeach; ?>