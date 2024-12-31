<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Producers $model */
/** @var ActiveForm $form */
?>
<div class="index">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'winery_name') ?>
        <?= $form->field($model, 'location') ?>
        <?= $form->field($model, 'nif') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'number') ?>
        <?= $form->field($model, 'complement') ?>
        <?= $form->field($model, 'postal_code') ?>
        <?= $form->field($model, 'region') ?>
        <?= $form->field($model, 'city') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'notes') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- index -->
