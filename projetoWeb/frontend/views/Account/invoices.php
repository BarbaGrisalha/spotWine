<?php
use yii\helpers\Html;

/** @var $invoices common\models\Invoices[] */

$this->title = 'Minhas Faturas';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (empty($invoices)): ?>
    <p>Você ainda não possui faturas.</p>
<?php else: ?>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Número da Fatura</th>
            <th>Data</th>
            <th>Total</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($invoices as $invoice): ?>
            <tr>
                <td><?= Html::encode($invoice->invoice_number) ?></td>
                <td><?= Yii::$app->formatter->asDate($invoice->invoice_date) ?></td>
                <td><?= Yii::$app->formatter->asCurrency($invoice->total_amount, 'EUR') ?></td>
                <td>
                    <?= Html::a('Ver Detalhes', ['account/invoice-details', 'id' => $invoice->id], ['class' => 'btn btn-primary btn-sm']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
