<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\User $user */
?>

<div class="product-form">
    <?php $form = ActiveForm::begin() ?>

    <?php if ($user->role === 'admin' ||($user->producer && $user->producer->role === 'admin')): ?>
        <!-- DropDownList para o administrador ou quem tenha a role dele -->
        <?= $form->field($model, 'producer_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                \common\models\User::find()
                    ->select(['user.id', 'username']) // Substituir se necessário para o campo identificador do produtor
                    ->innerJoin('producers', 'user.id = producers.user_id') // Relaciona com a tabela 'producers'
                    ->asArray()
                    ->all(),
                'id', // Chave do dropDownList
                'username' // Valor visível do dropDownList
            ),
            ['prompt' => 'Select Producer']
        ) ?>
    <?php elseif ($user->producer && $user->producers->role == 'producer'): ?>
        <!-- Campo oculto para produtores -->
        <?= $form->field($model, 'producer_id')->hiddenInput([
            'value' => $user->id, // Preenche com o ID do produtor logado
        ])->label(false) ?>
    <?php endif; ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock')->textInput() ?>

    <?= $form->field($model, 'image_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>