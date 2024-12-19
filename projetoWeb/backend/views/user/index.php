<?php

use backend\assets\AppAsset;
use yii\data\Pagination;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var \common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gestão de Utilizadores';
AppAsset::register($this);

?>
<div class="site-index">
    <div class="text-center bg-transparent">

    </div>
    <div class="body-content">
        <p>
            <?= Html::a('Criar Utilizador', ['user/create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'username',
                'email',
                [
                    'attribute' => 'nif',
                    'value' => function ($model) {
                        return $model->userDetails->nif ?? 'N/A';
                    },
                ],
                [
                    'attribute' => 'phone_number',
                    'value' => function ($model) {
                        return $model->userDetails->phone_number ?? 'N/A';
                    },
                ],
                [
                    'attribute' => 'role',
                    'label' => 'Role',
                    'value' => function ($model) {
                        return $model->getRoleName(); // Retorna o nome do role
                    },
                    'filter' => [
                        'admin' => 'Admin',
                        'producer' => 'Producer',
                        'consumer' => 'Consumer',
                    ],
                    'filterInputOptions' => ['class' => 'form-control', 'prompt' => 'Todos'],
                ],

                // Coluna de status
                [
                    'attribute' => 'status',
                    'format' => 'raw', // Permite HTML na célula
                    'value' => function ($model) {
                        // Verifica o status e define a classe CSS
                        $statusClass = $model->userDetails && $model->userDetails->status == 1 ? 'badge badge-success' : 'badge badge-danger';
                        $statusLabel = $model->userDetails && $model->userDetails->status == 1 ? 'Ativo' : 'Inativo';

                        // Retorna o status com a classe CSS aplicada
                        return Html::tag('span', $statusLabel, ['class' => $statusClass]);
                    },
                    'filter' => [
                        1 => 'Ativo',
                        0 => 'Inativo',
                    ],
                    'filterInputOptions' => ['class' => 'form-control', 'prompt' => 'Todos'], // Adiciona um placeholder
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {deactivate}', // Adiciona um botão personalizado
                    'buttons' => [
                        'deactivate' => function ($url, $model, $key) {
                            if ($model->userDetails && $model->userDetails->status == 1) {
                                return Html::a(
                                    '<i class="fas fa-ban text-red"></i>', // Ícone de desativar
                                    ['user/deactivate', 'id' => $model->id], // URL para a actionDeactivate
                                    [
                                        'title' => 'Desativar',
                                        'data-confirm' => 'Você tem certeza que deseja desativar este usuário?',
                                        'data-method' => 'post', // Envia como POST para segurança
                                    ]
                                );
                            } else {
                                return Html::a(
                                    '<i class="fas fa-check text-green"></i>', // Ícone de ativar
                                    ['user/activate', 'id' => $model->id], // URL para a actionActivate
                                    [
                                        'title' => 'Ativar',
                                        'data-confirm' => 'Você tem certeza que deseja ativar este usuário?',
                                        'data-method' => 'post',
                                    ]
                                );
                            }
                        },
                    ],

                ],
            ],

        ]); ?>

    <?php $pagination = new Pagination([
            'defaultPageSize'=>5,
            'totalCount'=> $query->count(),
    ]); ?>
    </div>
</div>
