<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h3>Informações do Usuário</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email',
        ],
    ]) ?>

    <h3>Detalhes Adicionais do Usuário</h3>
    <?php if ($model->userDetails): ?>
        <?= DetailView::widget([
            'model' => $model->userDetails, // Usando o relacionamento
            'attributes' => [
                'nif',
                'phone_number',
                [
                    'attribute' => 'status',
                    'value' => function ($userDetails) {
                        return $userDetails->status == 1 ? 'Ativo' : 'Inativo';
                    },
                ],
            ],
        ]) ?>
    <?php else: ?>
        <p>Sem detalhes adicionais.</p>
    <?php endif; ?>

</div>
