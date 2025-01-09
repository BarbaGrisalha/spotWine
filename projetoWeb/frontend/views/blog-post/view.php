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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><?= Html::encode($model->title) ?></h1>
        <?php if (Yii::$app->user->id === $model->user_id || Yii::$app->user->can('admin')): ?>
            <div class="d-flex">
                <?= Html::a(
                    '<i class="fas fa-edit me-1"></i> Editar',
                    ['update', 'id' => $model->id],
                    ['class' => 'btn btn-sm btn-warning d-flex align-items-center me-2'] // Margem à direita
                ) ?>
                <?= Html::a(
                    '<i class="fas fa-trash me-1"></i> Deletar',
                    ['delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-sm btn-danger d-flex align-items-center',
                        'data' => [
                            'confirm' => 'Tem certeza de que deseja deletar este post?',
                            'method' => 'post',
                            'params' => [
                                Yii::$app->request->csrfParam => Yii::$app->request->csrfToken, // Adiciona o token CSRF
                            ],
                        ],
                    ]
                ) ?>

            </div>
        <?php endif; ?>
    </div>

    <p class="text-muted">
        <i class="fas fa-user"></i> <?= Html::encode($model->user->username ?? 'Autor Desconhecido') ?> |
        <i class="far fa-clock"></i> <?= Yii::$app->formatter->asDate($model->created_at, 'long') ?>
    </p>

    <div class="mb-4 p-3 bg-light rounded">
        <h4 class="fs-2"><?= nl2br(Html::encode($model->content)) ?></h4>
    </div>

    <hr>

    <h4>Comentários</h4>

    <?php if ($commentsDataProvider->totalCount > 0): ?>
        <div class="comments-list">
            <?php foreach ($commentsDataProvider->models as $comment): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <p><?= Html::encode($comment->comment_text) ?></p>
                            <?php if ($comment->user_id === Yii::$app->user->id): ?>
                                <div class="form-group">
                                    <?= Html::a('<i class="fas fa-trash me-1"></i> Deletar',
                                        ['/comment-post/delete', 'id' => $comment->id],
                                        ['class' => 'btn btn-danger',
                                            'data' => [
                                                'confirm' => 'Tem certeza de que deseja deletar este post?',
                                                'method' => 'post',
                                                'params' => [
                                                    Yii::$app->request->csrfParam => Yii::$app->request->csrfToken,
                                                ],
                                            ],
                                        ]
                                    ) ?>

                                    <?= Html::a('Atualizar',
                                        ['/comment-post/update', 'id' => $comment->id],
                                        ['class' => 'btn btn-warning',])?>
                                </div>
                            <?php endif?>
                        </div>
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

    <?php $form = ActiveForm::begin(['action' => ['/comment-post/create', 'id' => $model->id]]); ?>
    <?= $form->field($newComment, 'comment_text')->textarea(['rows' => 4, 'placeholder' => 'Escreva seu comentário aqui...'])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Comentar', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
