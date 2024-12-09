<?php

use yii\data\Pagination;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProductSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php $query = \common\models\Product::find() ?>
    <?php $pagination = new Pagination([
        'defaultPageSize' => 5,
        'totalCount'=> $query->count(),
    ])?>

    <?php //$form->field($model, 'product_id') ?>

    <?php //$form->field($model, 'producer_id') ?>

    <?php //$form->field($model, 'category_id') ?>

    <?php //$form->field($model, 'name') ?>

    <?php //$form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'stock') ?>

    <?php // echo $form->field($model, 'image_url') ?>

    <div class="form-group">
        <?php // Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php // Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php $query = \common\models\Product::find() ?>
    <?php $pagination = new Pagination([
        'defaultPageSize' => 5,
        'totalCount'=> $query->count(),
    ])?>

</div>
