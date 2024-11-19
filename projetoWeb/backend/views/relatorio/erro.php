<?php
/** @var yii\web\View $this */
/** @var string $mensagem */

use yii\helpers\Html;

$this->title = 'Erro no Relatório';
?>
<div class="alert alert-danger">
     <h1><?=Html::encode($this->title)?></h1>
<p><?= Html::encode($mensagem)?></p>
</div>