<?php

use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Promotions $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Product[] $availableProducts */
\backend\assets\AppAsset::register($this);

?>

<div class="promotions-form h-auto">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'promotion_type')->dropDownList([
        'direct' => 'Promoção Direta',
        'conditional' => 'Promoção Condicional',
    ], ['prompt' => 'Selecione o Tipo de Promoção']) ?>

    <?= $form->field($model, 'discount_type')->dropDownList([
        'percent' => 'Percentual (%)',
        'fixed' => 'Valor Fixo (€)',
    ], ['prompt' => 'Selecione o Tipo de Desconto']) ?>

    <?= $form->field($model, 'discount_value')->textInput(['type' => 'number', 'step' => '0.01', 'min' => 0]) ?>

    <!-- Campo de seleção de produtos, visível apenas para promoções diretas -->
    <div id="direct-fields" style="display: none;">
        <?= $form->field($model, 'productsIds')->checkboxList(
            ArrayHelper::map($availableProducts, 'product_id', 'name'),
            ['prompt' => 'Selecione os Produtos']
        ) ?>
    </div>

    <!-- Campos de condições, visíveis apenas para promoções condicionais -->
    <div id="conditional-fields" style="display: none;">
        <?= $form->field($model, 'condition_type')->dropDownList([
            'min_purchase' => 'Mínimo de Compra (€)',
            'quantity' => 'Quantidade Mínima',
        ], ['prompt' => 'Selecione o Tipo de Condição']) ?>

        <?= $form->field($model, 'condition_value')->textInput(['type' => 'number', 'step' => '0.01', 'min' => 0]) ?>
    </div>

    <?= $form->field($model, 'start_date')->input('date') ?>

    <?= $form->field($model, 'end_date')->input('date') ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


