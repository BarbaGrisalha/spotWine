<?php

use yii\helpers\Html;

/** @var common\models\Reviews $model */

?>

<div class="review-item border-bottom pb-3 mb-3">
    <div class="d-flex align-items-center mb-2">
        <strong class="text-primary mr-2"><?= Html::encode($model->user->username) ?></strong>
        <div class="stars">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <i class="fa <?= $i <= $model->rating ? 'fa-star text-warning' : 'fa-star-o text-secondary' ?>"></i>
            <?php endfor; ?>
        </div>
    </div>
    <p class="text-muted mb-2"><?= Html::encode($model->comment) ?></p>
    <small class="text-secondary">
        <i class="fa fa-calendar-alt"></i> <?= Yii::$app->formatter->asDate($model->created_at) ?>
    </small>
</div>
