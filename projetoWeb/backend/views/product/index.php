<?php

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lista de Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?=$this->title?></h1>

    <p>
        <?= Html::a('Adicionar Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered table-hover align-middle'], // Adiciona classes Bootstrap para alinhamento
            'columns' => [
                [
                    'attribute' => 'image_url',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center '], // Centraliza o conteúdo da célula
                    'headerOptions' => ['class' => 'text-center'], // Centraliza o cabeçalho
                    'value' => function ($model) {
                        if ($model->image_url) {
                            return Html::img(Yii::getAlias('@web') . $model->image_url, [
                                'style' => 'max-width: 80px;',
                                'class' => 'img-thumbnail',
                            ]);
                        }
                        // Mensagem ou ícone padrão para quando não houver imagem
                        return '<i class="fas fa-file-image" style="font-size: 24px; color: #aaa;"></i><br><small>Sem imagem</small>';
                    },
                    'label' => '<i class="bi bi-image"></i> Imagem',
                    'encodeLabel' => false,
                ],
                [
                    'attribute' => 'producer_id',
                    'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
                    'visible' => Yii::$app->user->can('admin'),
                    'value' => function($model) {
                        return $model->producers->user->username ?? 'n/a';
                    }
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
                    'attribute' => 'description',
                    'format' => 'ntext',
                    'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
                ],
                [
                    'attribute' => 'price',
                    'format' => 'currency',
                    'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
                ],
                [
                    'attribute' => 'stock',
                    'contentOptions' => ['class' => 'align-middle text-center'], // Alinha verticalmente os dados
                ],
                [
                    'class' => ActionColumn::className(),
                    'contentOptions' => ['class' => 'text-center align-middle'], // Centraliza os botões
                    'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'product_id' => $model->product_id]);
                    }
                ],
            ],
        ]); ?>
    </div>

</div>
