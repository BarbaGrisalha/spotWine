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

    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?php else: ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => ''])->label('Nova Senha (deixe em branco para manter)') ?>
    <?php endif; ?>

    <!-- Campos do modelo ProducersDetails -->
    <?= $form->field($userDetails, 'winery_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'location')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'nif')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'complement')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'postal_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'region')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'city')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userDetails, 'notes')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
