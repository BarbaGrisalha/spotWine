<?php

use common\models\Categories;
use common\models\User;
use yii\helpers\ArrayHelper;
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

    <?= $form->field($model, 'producer_id')->dropDownList(
        ArrayHelper::map(User::find()
            ->where(['role'=> 'producer'])//aqui fala de role .
            ->all(),
            'id', //ID do produtor
            'username'//Nome do produtor
        ),
            ['prompt'=> 'Select Producer']//texto inicial
        )?>

    <?php else: ?>
        <!-- Campo oculto para produtores -->
        <?= $form->field($model, 'producer_id')->hiddenInput([
            'value' => $user->id, // Preenche com o ID do produtor logado
        ])->label(false) ?>
    <?php endif; ?>

    <?= $form->field($model, 'category_id')
        ->dropDownList(
       ArrayHelper::map(Categories::find()
                ->asArray()
                ->all(),
            'category_id',
            'name'
        ),
        ['prompt' => 'Select Category']
    ) ?>
    <!-- A lógica é assim, para o admin tem que ter um campo de produtor, para o produtor não , ele
    já é reconhecido -->

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