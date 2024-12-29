<?php

use yii\widgets\ListView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\Product $product */

$this->title = "Avaliações";
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container py-4">

    <!-- Banner do Nome do Produto -->
    <div class="d-flex align-items-center justify-content-center product-banner bg-primary text-white py-2 px-4 mb-4" style="border-radius: 5px;">
        <i class="fa fa-comments text-white mr-3" style="font-size: 2.5rem;"></i>
        <h2 class="m-0 text-white"><?= Html::encode($product->name) ?></h2>
    </div>

    <!-- Lista de Avaliações -->
    <div class="reviews-list">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => function ($model) {
                return $this->render('_review_item', ['model' => $model]);
            },
            'summary' => false,
            'pager' => [
                'class' => 'yii\widgets\LinkPager',
                'options' => ['class' => 'pagination justify-content-center'],
            ],
        ]) ?>
    </div>
</div>
