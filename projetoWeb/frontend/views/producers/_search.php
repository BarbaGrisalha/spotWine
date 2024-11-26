<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ProducersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="producers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'producer_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'winery_name') ?>

    <?= $form->field($model, 'location') ?>

    <?= $form->field($model, 'document_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
