<?php

use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Promotions $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="promotions-form h-auto">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_type')->dropDownList([
        'percent' => 'Percentual (%)',
        'fixed' => 'Valor Fixo (€)',
    ], ['prompt' => 'Selecione o tipo de desconto']) ?>

    <?= $form->field($model, 'discount_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condition_type')->dropDownList([
        'none' => 'Sem condição',
        'min_purchase' => 'Mínimo de Compra (€)',
        'quantity' => 'Quantidade Mínima',
    ], ['prompt' => 'Selecione a condição']) ?>

    <?= $form->field($model, 'condition_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'productsIds')->checkboxList(
        ArrayHelper::map($availableProducts, 'product_id', 'name') // Mapeando os produtos para o checkboxList
    ) ?>


    <?= $form->field($model, 'start_date')->input('date') ?>

    <?= $form->field($model, 'end_date')->input('date') ?>


    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
