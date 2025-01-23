<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Contests $contest */
/** @var common\models\Product[] $products */
/** @var common\models\ContestParticipations $participation */

$this->title = 'Inscrição no Concurso: ' . $contest->name;
$this->params['breadcrumbs'][] = ['label' => 'Concursos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="register-producer">

    <p>Escolha o produto que deseja inscrever no concurso:</p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($participation, 'product_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($products, 'product_id', 'name'),
        ['prompt' => 'Selecione um produto']
    )->label('Produto') ?>

    <div class="form-group">
        <?= Html::submitButton('Registrar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
