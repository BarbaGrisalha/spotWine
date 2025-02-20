<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Alterar Password';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="change-password-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'enableClientValidation' => true, // Habilita validação no cliente
        'enableAjaxValidation' => false, // Mantém a validação do Yii2
    ]); ?>

    <?= $form->field($model, 'atualPassword')->passwordInput() ?>
    <?= $form->field($model, 'novaPassword')->passwordInput() ?>
    <?= $form->field($model, 'confirmarPassword')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Confirmar Alteração', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>