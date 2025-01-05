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

    <p>
        <?= Html::a('Adicionar Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'attribute' => 'producer_id',
                    'value' => function($model){
                        return $model->producers->user->username ?? 'n/a';
                    }
            ],
            [
                'attribute' => 'category_id',
                'value' => function($model) {
                    return $model->categories->name ?? 'n/a';
                },
            ],
            'name',
            'description:ntext',
            'price:currency',
            'stock',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'product_id' => $model->product_id]);//mudei de product_id para id
                }
            ],
        ],
    ]); ?>

</div>
