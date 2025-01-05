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

    <!-- Campos do modelo ProducersDetails -->
    <?= $form->field($producerDetails, 'winery_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'location')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'nif')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'complement')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'postal_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'region')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'city')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($producerDetails, 'notes')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>
    <?php endif;?>
    <?php ActiveForm::end(); ?>

</div>
