<?php
use yii\helpers\Html;
?>
<div class="container mt-5 text-center">
    <h3 class="mb-4 text-success"><i class="fas fa-check-circle"></i> Pedido Confirmado!</h3>
    <p><strong>Número do Pedido:</strong> <?= $order->id ?></p>
    <p><strong>Status do Pedido:</strong> <?= $order->getStatusLabel() ?></p>
    <p><strong>Total Pago:</strong> <?= Yii::$app->formatter->asCurrency($order->invoice->total_amount, 'EUR') ?></p>
    <p><strong>Status da Fatura:</strong> <?= $order->invoice ? $order->invoice->getStatusLabel() : 'Sem Fatura' ?></p>
    <?= Html::a('<i class="fas fa-arrow-left"></i> Continuar Comprando', ['product/index'], ['class' => 'btn btn-primary']) ?>
</div>
