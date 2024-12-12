<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\PromotionSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="promotions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'promotion_id') ?>

    <?= $form->field($model, 'discount_percentage') ?>

    <?= $form->field($model, 'start_date') ?>

    <?= $form->field($model, 'end_date') ?>

    <?= $form->field($model, 'discount_type') ?>

    <?php // echo $form->field($model, 'discount_value') ?>

    <?php // echo $form->field($model, 'condition_type') ?>

    <?php // echo $form->field($model, 'condition_value') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
