<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var common\models\ProducerDetails|common\models\ConsumerDetails $userDetails */

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campos do modelo User -->
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?php if ($model->isProducer()): ?>
        <h3>Detalhes do Produtor</h3>

        <!-- Campos do modelo ProducerDetails -->
        <?= $form->field($userDetails, 'document_id')->textInput(['maxlength' => true]) ?>
        <?= $form->field($userDetails, 'nif')->textInput(['maxlength' => true]) ?>
        <?= $form->field($userDetails, 'phone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($userDetails, 'mobile')->textInput(['maxlength' => true]) ?>
        <?= $form->field($userDetails, 'winery_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($userDetails, 'location')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($userDetails, 'address')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($userDetails, 'number')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($userDetails, 'postal_code')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($userDetails, 'region')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($userDetails, 'city')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($userDetails, 'complement')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    <?php elseif ($model->isConsumer()): ?>
        <h3>Detalhes do Consumidor</h3>

        <!-- Campos do modelo ConsumerDetails -->
        <?= $form->field($userDetails, 'nif')->textInput(['maxlength' => true]) ?>
        <?= $form->field($userDetails, 'phone_number')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
