<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\BlogPosts $model */

?>

<div class="card h-auto shadow-lg">
    <?php if (!empty($model->image_url)): ?>
        <div class="card-img-top" style="height: 50%; overflow: hidden;">
            <img src="<?= Url::to('@web' . $model->image_url) ?>"
                 alt="<?= Html::encode($model->title) ?>"
                 class="img-fluid w-100"
                 style="object-fit: cover; height: 100%;">
        </div>
    <?php endif; ?>

    <div class="card-body d-flex flex-column justify-content-between">
        <h5 class="card-title"><?= Html::encode($model->title) ?></h5>
        <p class="card-text text-muted mb-3">
            <i class="fas fa-user"></i> <?= Html::encode($model->user->username ?? 'Desconhecido') ?> |
            <i class="far fa-clock"></i> <?= Yii::$app->formatter->asDate($model->created_at, 'long') ?>
        </p>
        <p class="card-text mb-4"><?= Html::encode(substr($model->content, 0, 100)) ?>...</p>
        <div class="d-flex justify-content-between align-items-center mt-auto">
            <?= Html::a('Ver Mais', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>

            <?php if (Yii::$app->user->id === $model->user_id || Yii::$app->user->can('admin')): ?>
                <div class="d-flex">
                    <?= Html::a('<i class="fas fa-edit fa-lg"></i>', ['update', 'id' => $model->id], [
                        'class' => 'btn btn-warning btn-sm',
                    ]) ?>
                    <?= Html::a('<i class="fas fa-trash fa-lg"></i>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Tem certeza de que deseja deletar este post?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
