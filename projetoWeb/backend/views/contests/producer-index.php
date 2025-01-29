<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Concursos';

/** @var $dataProvider */
/** @var  $searchModel */
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'name', // Nome do concurso
        [
            'attribute' => 'Categoria',
            'format' => 'raw', // Permite adicionar HTML
            'value' => function ($model) {
                $categoria = $model->categories->name ?? 'Sem categoria';

                // Ícones personalizados por categoria
                $cores = [
                    'Vinho Tinto' => ['cor' => '#8B0000', 'icone' => '<i class="fas fa-wine-glass"></i>'],
                    'Vinho Branco' => ['cor' => '#fcec71', 'icone' => '<i class="fas fa-wine-glass"></i>'],
                    'Vinho Rose' => ['cor' => '#FF69B4', 'icone' => '<i class="fas fa-wine-glass"></i>'],
                ];

                // Verifica a categoria e monta o HTML
                if (array_key_exists($categoria, $cores)) {
                    $icone = $cores[$categoria]['icone'];
                    $cor = $cores[$categoria]['cor'];
                    return "<span style='color: {$cor}; font-weight: bold;'>{$icone} {$categoria}</span>";
                }

                // Categoria padrão (sem categoria ou outras)
                return '<i class="bi bi-question-circle" style="color: #aaa;"></i> Sem categoria';
            },
            'contentOptions' => ['class' => 'align-middle text-center'], // Centraliza o texto na célula
        ],

        [
            'attribute' => 'Fase do Concurso',
            'format' => 'raw',
            'value' => function ($model) {
                // Atualiza o status antes de exibir
                $model->updateStatus();

                // Ícones e cores baseados no status atualizado
                $statusLabels = [
                    'pending' => ['label' => 'Aguardando início',  'icon' => '<i class="fa fa-clock text-secondary"></i>'],
                    'registration' => ['label' => 'Inscrições abertas', 'icon' => '<i class="fas fa-calendar-check text-success"></i>'],
                    'voting' => ['label' => 'Concurso em andamento', 'icon' => '<i class="fas fa-trophy text-warning"></i>'],
                    'finished' => ['label' => 'Concurso finalizado',  'icon' => '<i class="fas fa-flag text-danger"></i>'],
                ];

                $status = $statusLabels[$model->status] ?? $statusLabels['pending'];

                return "{$status['icon']} <span>{$status['label']}</span>";
            },
            'contentOptions' => ['class' => 'align-middle text-center'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{register}', // Apenas ação de inscrição
            'contentOptions' => ['class' => 'align-middle text-center'],
            'buttons' => [
                'register' => function ($url, $model) {
                    return Html::a('<i class="fas fa-info mr-1"></i>Saber Mais', ['details', 'id' => $model->id], [
                        'class' => 'btn btn-outline-info',
                    ]);
                },
            ],
        ],
    ],
]); ?>
