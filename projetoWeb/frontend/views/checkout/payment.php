<?php
use yii\helpers\Html;
?>
<div class="container mt-5">
    <h3 class="text-center mb-4"><i class="fas fa-money-bill-wave"></i> Pagamento do Pedido</h3>
    <p class="text-center">Número do Pedido: <strong><?= $order->id ?></strong></p>
    <p class="text-center">Total: <strong><?= Yii::$app->formatter->asCurrency($order->total_price, 'EUR') ?></strong></p>
    <?= Html::beginForm(['checkout/payment', 'orderId' => $order->id], 'post', ['class' => 'text-center']) ?>
    <?= Html::submitButton('<i class="fas fa-credit-card"></i> Simular Pagamento', ['class' => 'btn btn-primary']) ?>
    <?= Html::endForm() ?>
</div>
