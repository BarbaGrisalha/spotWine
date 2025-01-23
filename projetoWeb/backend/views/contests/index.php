<?php

use common\models\Contests;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ContestsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Concursos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contests-index">

    <p>
        <?= Html::a('Create Contests', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-hover align-middle'],
        'columns' => [
            [
                'attribute' => 'image_url',
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center '], // Centraliza o conteúdo da célula
                'headerOptions' => ['class' => 'text-center', 'style' => 'width:120px;'], // Centraliza o cabeçalho
                'value' => function ($model) {
                    if ($model->image_url) {
                        return Html::img(Yii::getAlias('@web') . $model->image_url, [
                                'class' => 'w-100',
                        ]);
                    }
                    // Mensagem ou ícone padrão para quando não houver imagem
                    return '<i class="fas fa-file-image" style="font-size: 24px; color: #aaa;"></i><br><small>Sem imagem</small>';
                },
                'label' => '<i class="bi bi-image"></i> Imagem',
                'encodeLabel' => false,
            ],
            [
                'attribute' => 'category_id',
                'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
                'value' => function($model) {
                    return $model->categories->name ?? 'n/a';
                },
            ],
            [
                'attribute' => 'name',
                'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
            ],
            [
                'attribute' => 'registration_start_date',
                'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
            ],
            [
                'attribute' => 'registration_end_date',
                'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
            ],
            [
                'attribute' => 'contest_start_date',
                'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
            ],[
                'attribute' => 'contest_end_date',
                'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
            ],

            //'registration_end_date',
            //'contest_start_date',
            //'contest_end_date',
            //'image_url:url',
            //'status',
            [
                 'class' => ActionColumn::className(),
                'contentOptions' => ['class' => 'text-center align-middle'],
                'urlCreator' => function ($action, Contests $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },

            ],

        ],

    ]); ?>





</div>
