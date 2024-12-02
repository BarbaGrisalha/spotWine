<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'producer_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                    \common\models\User::find()
                ->select(['id','username']) //substituir se for o caso o username por qualquer campo identificador do produtor
                ->innerJoin('producers','user.id = producers.user_id')//Relacione com a tabela 'producers'
                ->asArray()
                ->all(),
                'id',//Chave do dropDownList
                'username' //Valor visível do dropDownList
            ),
        ['prompt'=>'Select Producer']
    ) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '']) ?>//incluí a password como vazio para poder alterar.

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
