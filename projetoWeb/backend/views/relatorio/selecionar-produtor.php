<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $produtores array */

$this->title ='Selecionar Produtos';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin();?>

<?php $form->field(new \yii\base\DynamicModel(['producer_id']),'producer_id')
    ->label('Produtor') ?>
<div class="form-group">
    <?=Html::submitButton('Gerar Relatório',['class' =>'btn btn-primary'])?>
</div>
<?php ActiveForm::end();?>

