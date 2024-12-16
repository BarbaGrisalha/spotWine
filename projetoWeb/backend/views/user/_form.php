<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\ProducerDetails $producerDetails */

?>

<div class="producer-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campos do modelo User -->
    <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($user, 'password')->passwordInput(['maxlength' => true]) ?>

    <!-- Campos do modelo ProducerDetails -->
    <?= $form->field($producerDetails, 'document_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'nif')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'mobile')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'winery_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'location')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($producerDetails, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($producerDetails, 'number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($producerDetails, 'postal_code')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($producerDetails, 'region')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($producerDetails, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($producerDetails, 'complement')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
