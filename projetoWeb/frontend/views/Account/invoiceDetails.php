<?php

use yii\helpers\Html;

?>
<div class="invoice-details">
    <h2>Fatura: <?= Html::encode($invoice->invoice_number) ?></h2>
    <p><strong>Data:</strong> <?= Yii::$app->formatter->asDate($invoice->invoice_date, 'php:d/m/Y') ?></p>
    <p><strong>Total:</strong> <?= Yii::$app->formatter->asCurrency($invoice->total_amount, 'EUR') ?></p>

    <h3>Produtos:</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Produto</th>
            <th>Preço Unitário</th>
            <th>Quantidade</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($invoice->orders->orderItems as $item): ?>
            <tr>
                <td><?= Html::encode($item->product->name) ?></td>
                <td><?= Yii::$app->formatter->asCurrency($item->unit_price, 'EUR') ?></td>
                <td><?= Html::encode($item->quantity) ?></td>
                <td><?= Yii::$app->formatter->asCurrency($item->unit_price * $item->quantity, 'EUR') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>