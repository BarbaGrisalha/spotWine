<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var common\models\ProductSearch $model */
/** @var common\models\User $produtor */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Gestão de Produtos';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="product-management">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    // Get the current user ID if logged in
    $currentUserId = Yii::$app->user->isGuest ? null : Yii::$app->user->id;

    // Configurando o DataProvider com paginação e filtro pelo usuário autenticado
    $query = \common\models\Product::find();

    // Apply filter for signed-in user
    if ($currentUserId !== null) {
        $query->joinWith('producers') // Ensure the relationship is loaded
        ->andWhere(['producers_details.user_id' => $currentUserId]);
    }

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 5, // Altere aqui para o número máximo de itens por página
        ],
    ]);
    ?>

    <!-- GridView para exibir os dados -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel'=> $model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Coluna de número de série
            'product_id',
            [
                'attribute' => 'producer_id',
                'value' => function($model) {
                    return $model->producers->user->username ?? 'n/a';
                },
            ],
            [
                'attribute' => 'winery_name',
                'value' => function($model) {
                    return $model->producers->winery_name ?? 'n/a';
                },
            ],
            [
                'attribute' => 'category_id',
                'value' => function($model) {
                    return $model->categories->name ?? 'n/a';
                },
            ],
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

</div>