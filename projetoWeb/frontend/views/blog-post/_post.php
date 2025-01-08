<?php
use yii\helpers\Html;

/** @var common\models\BlogPosts $model */
?>

<?= Html::a(
    "<div class='card h-100'>
        <img src='{$model->image_url}' class='card-img-top' alt='" . Html::encode($model->title) . "'>
        <div class='card-body'>
            <h5 class='card-title'>" . Html::encode($model->title) . "</h5>
            <p class='card-text text-muted'>" . Yii::$app->formatter->asNtext($model->content) . "</p>
        </div>
        <div class='card-footer'>
            <small class='text-muted'>
                <i class='fas fa-user'></i> " . Html::encode($model->user->username ?? 'Autor Desconhecido') . " |
                <i class='far fa-clock'></i> " . Yii::$app->formatter->asRelativeTime($model->created_at) . "
            </small>
        </div>
    </div>",
    ['view', 'id' => $model->id],
    ['class' => 'text-decoration-none']
) ?>
