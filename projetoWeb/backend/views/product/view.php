<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="d-flex align-items-start">

    <img src="<?= Yii::getAlias('@web') . $model->image_url ?>" alt="Blog Image" class="w-25">

    <div class="d-flex flex-column w-100 align-items-center">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'product_id',
                'producer_id',
                [
                    'attribute' => 'category_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->categories->name;
                    },
                    'encodeLabel' => false,
                ],
                'description:ntext',
                'price',
                'stock',
            ],
        ]) ?>

        <p>
            <?= Html::a('Update', ['update', 'product_id' => $model->product_id], ['class' => 'btn btn-primary'])?>

            <?= Html::a('Delete', ['delete', 'product_id' => $model->product_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

    </div>

</div>


