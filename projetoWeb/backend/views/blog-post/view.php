<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\BlogPosts $model */
/** @var common\models\Comments $newComment */
/** @var yii\data\ActiveDataProvider $commentsDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blog Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="blog-post-view">

    <h1>
        <?= Html::encode($model->title) ?>
        <?php if (Yii::$app->user->id === $model->user_id || Yii::$app->user->can('admin')): ?>
            <div class="float-end">
                <?= Html::a('<i class="fas fa-edit"></i> Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?>
                <?= Html::a('<i class="fas fa-trash"></i> Deletar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Tem certeza de que deseja deletar este post?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php endif; ?>
    </h1>

    <p class="text-muted">
        <i class="fas fa-user"></i> <?= Html::encode($model->user->username ?? 'Desconhecido') ?> |
        <i class="far fa-clock"></i> <?= Yii::$app->formatter->asDate($model->created_at, 'long') ?>
    </p>

    <div class="mb-4">
        <p><?= nl2br(Html::encode($model->content)) ?></p>
    </div>

    <hr>

    <h4>Comentários</h4>

    <?php if ($commentsDataProvider->totalCount > 0): ?>
        <div class="comments-list">
            <?php foreach ($commentsDataProvider->models as $comment): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p><?= Html::encode($comment->comment_text) ?></p>
                        <p class="text-muted">
                            <i class="fas fa-user"></i> <?= Html::encode($comment->user->username ?? 'Anônimo') ?> |
                            <i class="far fa-clock"></i> <?= Yii::$app->formatter->asRelativeTime($comment->created_at) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">Ainda não há comentários neste post.</p>
    <?php endif; ?>

    <hr>

    <h4>Deixe um comentário</h4>

    <?php $form = ActiveForm::begin(['action' => ['comment', 'id' => $model->id]]); ?>
    <?= $form->field($newComment, 'comment_text')->textarea(['rows' => 4])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Comentar', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
