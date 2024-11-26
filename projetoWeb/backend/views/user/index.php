<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\UserDetails;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'SpotWine_Backend';
?>
<div class="site-index">
    <div class="text-center bg-transparent">
        <h1 class="display-4">Gestão de Utilizadores</h1>
    </div>
    <div class="body-content">
        <p>
            <?= Html::a('Create User', ['user/create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'username',
                'email',
                // Colunas de `user_details`
                [
                    'attribute' => 'userDetails.nif',
                    'value' => 'userDetails.nif',
                ],
                [
                    'attribute' => 'phone_number',
                    'value' => function ($model) {
                        return $model->userDetails->phone_number ?? 'N/A';
                    },
                ],
                // Coluna de status
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        return $model->userDetails && $model->userDetails->status == 1 ? 'Ativo' : 'Inativo';
                    },
                    'filter' => [
                        1 => 'Ativo',
                        0 => 'Inativo',
                    ],
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {deactivate}', // Adiciona um botão personalizado
                    'buttons' => [
                        'deactivate' => function ($url, $model, $key) {
                            if ($model->userDetails && $model->userDetails->status == 1) {
                                return Html::a(
                                    '<i class="fas fa-ban"></i>', // Ícone de desativar
                                    ['user/deactivate', 'id' => $model->id], // URL para a actionDeactivate
                                    [
                                        'title' => 'Desativar',
                                        'data-confirm' => 'Você tem certeza que deseja desativar este usuário?',
                                        'data-method' => 'post', // Envia como POST para segurança
                                    ]
                                );
                            } else {
                                return Html::a(
                                    '<i class="fas fa-check"></i>', // Ícone de ativar
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

    </div>
</div>
