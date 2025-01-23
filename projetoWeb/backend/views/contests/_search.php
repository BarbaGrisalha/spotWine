<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ContestsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contests-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'registration_start_date') ?>

    <?php // echo $form->field($model, 'registration_end_date') ?>

    <?php // echo $form->field($model, 'contest_start_date') ?>

    <?php // echo $form->field($model, 'contest_end_date') ?>

    <?php // echo $form->field($model, 'image_url') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
