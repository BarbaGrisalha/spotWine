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

    <?php if ($user->role === 'admin'):  ?>
        <!-- DropDownList para o administrador ou quem tenha a role dele -->

    <?php else: ?>
        <!-- Campo oculto para produtores -->
        <?= $form->field($model, 'producer_id')->hiddenInput([
            'value' => $user->id, // Preenche com o ID do produtor logado
        ])->label(false) ?>
    <?php endif; ?>
    <!-- Substituir textInput para category_id por dropdown ou outro widget -->
    <?= $form->field($model, 'category_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(
            \common\models\Categories::find()->asArray()->all(),
            'id', // ID da categoria
            'name' // Nome da categoria
        ),
        ['prompt' => 'Select Category']
    ) ?>


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