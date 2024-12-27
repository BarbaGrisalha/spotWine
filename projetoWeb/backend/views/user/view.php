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

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Informações do Usuário</h3>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'email',
                    [
                        'label' => 'Role',
                        'value' => function ($model) {
                            return $model->authAssignment->item_name ?? 'Sem Role';
                        },
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <?php if ($model->isProducer()): ?>
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">Detalhes Produtor</h3>
            </div>
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model->producerDetails,
                    'attributes' => [
                        'document_id',
                        'nif',
                        'phone',
                        'mobile',
                        'winery_name',
                        'location',
                        [
                            'label' => 'Status',
                            'value' => function ($producerDetails) {
                                return $producerDetails->status == 1 ? 'Ativo' : 'Inativo';
                            },
                        ],
                    ],
                ]) ?>
            </div>
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0">Endereço</h3>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model->producerDetails,
                        'attributes' => [
                            'address',
                            'number',
                            'postal_code',
                            'region',
                            'city',
                            'complement',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>



    <?php elseif ($model->isConsumer()): ?>
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h3>Detalhes do Consumidor</h3>
        </div>
        <?= DetailView::widget([
            'model' => $model->consumerDetails,
            'attributes' => [
                'nif',
                'phone_number',
            ],
        ]) ?>
    </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Sem detalhes adicionais.
        </div>


    <?php endif; ?>

