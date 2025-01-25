<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Concursos';

/** @var $dataProvider */
/** @var  $searchModel */
?>

<?=
GridView::widget([
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
                    'Vinho Branco' => ['cor' => '#fcec71', 'icone' => '<i class="fas fa-wine-glass" ></i>'],
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
                $now = time();
                $formatter = Yii::$app->formatter;

                if ($now < strtotime($model->registration_end_date)) {
                    $diasRestantes = $formatter->asRelativeTime($model->registration_end_date, $now);
                    return '<i class="fas fa-calendar-check text-success"></i> Inscrições abertas (' .
                        str_replace(['in ', 'a day', 'days', 'hours'], ['', '1 dia', 'dias', 'horas'], $diasRestantes) .
                        ' restantes)';
                } elseif ($now < strtotime($model->contest_start_date)) {
                    return '<i class="fa fa-clock text-danger-emphasis"></i> Aguardando início do concurso';
                } elseif ($now < strtotime($model->contest_end_date)) {
                    return '<i class="fas fa-trophy text-warning"></i> Concurso em andamento';
                } else {
                    return '<i class="fas fa-flag text-danger"></i> Concurso finalizado';
                }
            },
            'contentOptions' => ['class' => 'align-middle text-center'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{register}', // Apenas ação de inscrição
            'buttons' => [
                'register' => function ($url, $model) {
                    return Html::a('Saber mais', ['details', 'id' => $model->id], [
                        'class' => 'btn btn-primary',
                    ]);
                },
            ],
        ],
    ],
]); ?>
