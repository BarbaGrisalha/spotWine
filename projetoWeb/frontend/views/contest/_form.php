<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Contests $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'registration_start_date')->textInput() ?>

    <?= $form->field($model, 'registration_end_date')->textInput() ?>

    <?= $form->field($model, 'contest_start_date')->textInput() ?>

    <?= $form->field($model, 'contest_end_date')->textInput() ?>

    <?= $form->field($model, 'image_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'pending' => 'Pending', 'registration' => 'Registration', 'voting' => 'Voting', 'finished' => 'Finished', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
