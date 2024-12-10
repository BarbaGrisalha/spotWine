<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var common\models\ProductSearch $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Gestão de Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-management">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="search-filters">
        <?= $form->field($model, 'product_id') ?>
        <?= $form->field($model, 'producer_id') ?>
        <?= $form->field($model, 'category_id') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->field($model, 'price') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    // Configurando o DataProvider com paginação
    $dataProvider = new ActiveDataProvider([
        'query' => \common\models\Product::find(),
        'pagination' => [
            'pageSize' => 5, // Altere aqui para o número máximo de itens por página
        ],
    ]);
    ?>

    <!-- GridView para exibir os dados -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Coluna de número de série

            'product_id',
            'producer_id',
            'category_id',
            'name',
            'description',
            [
                'attribute' => 'price',
                'format' => ['decimal', 2],
            ],
            // Outras colunas podem ser adicionadas conforme necessidade

            ['class' => 'yii\grid\ActionColumn'], // Coluna para ações (editar/excluir)
        ],
    ]); ?>

    <!-- Links de paginação -->
    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]); ?>
</div>