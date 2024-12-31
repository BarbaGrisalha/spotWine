<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Producers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="producers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'winery_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nif')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'address')->textInput(['maxlength'=> true])?>

    <?= $form->field($model,'number')->textInput(['maxlengt'=>true])?>

    <?= $form->field($model, 'city')->textInput(['maxlength'=> true]) ?>

    <?= $form->field($model,'complement')->textInput(['maxlength'=> true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
