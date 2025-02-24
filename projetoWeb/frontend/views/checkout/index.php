<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var array $cartViewModels */
/** @var float $totalAmount */

$this->title = 'Checkout';
?>
<div class="container mt-5">
    <h2 class="mb-4 text-center"><i class="fas fa-shopping-cart"></i> Resumo do Pedido</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cartViewModels as $model): ?>
                <tr>
                    <td><?= Html::encode($model->product->name) ?></td>
                    <td><?= $model->quantity ?></td>
                    <td>
                        <?php if ($model->isOnPromotion()): ?>
                            <span class="text-muted text-decoration-line-through">
                                <?= Yii::$app->formatter->asCurrency($model->product->price, 'EUR') ?>
                            </span>
                            <span class="text-success">
                                <?= Yii::$app->formatter->asCurrency($model->getFinalPrice(), 'EUR') ?>
                            </span>
                        <?php else: ?>
                            <?= Yii::$app->formatter->asCurrency($model->product->price, 'EUR') ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= Yii::$app->formatter->asCurrency($model->getTotalPrice(), 'EUR') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total Geral</th>
                <th><?= Yii::$app->formatter->asCurrency($totalAmount, 'EUR') ?></th>
            </tr>
            </tfoot>
        </table>
    </div>

    <div class="payment-method mt-4">
        <h3 class="text-center"><i class="fas fa-credit-card"></i> Escolha o Método de Pagamento</h3>
        <form method="post" action="<?= Url::to(['checkout/index']) ?>" class="mt-3">
            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
            <div class="form-group">
                <div class="d-flex flex-column">
                    <label class="btn btn-outline-secondary mb-2">
                        <input type="radio" name="payment_method" value="Mbway">
                        <i class="fas fa-mobile-alt"></i> Mbway
                    </label>
                    <label class="btn btn-outline-secondary mb-2">
                        <input type="radio" name="payment_method" value="Cartão de Crédito">
                        <i class="fas fa-credit-card"></i> Cartão de Crédito
                    </label>
                    <label class="btn btn-outline-secondary mb-2">
                        <input type="radio" name="payment_method" value="Multibanco">
                        <i class="fas fa-university"></i> Multibanco
                    </label>
                    <label class="btn btn-outline-secondary">
                        <input type="radio" name="payment_method" value="PayPal">
                        <i class="fab fa-paypal"></i> PayPal
                    </label>
                </div>
            </div>

            <?= Html::submitButton('<i class="fas fa-check"></i> Confirmar Pedido', ['class' => 'btn btn-success btn-block']) ?>
        </form>
    </div>
</div>
