<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Carrinho de Compras';
?>

<div class="cart-page container py-5">
    <div class="row">
        <!-- Itens do Carrinho -->
        <div class="col-md-8">
            <h3>Seu Carrinho</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($cartItems)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Seu carrinho está vazio.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= Html::encode($item->product->name) ?></td>
                            <td><?= $item->quantity ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($item->price, 'EUR') ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($item->price * $item->quantity, 'EUR') ?></td>
                            <td>
                                <?= Html::a(
                                    '<i class="fa fa-trash"></i>',
                                    ['cart/delete', 'id' => $item->product_id],
                                    [
                                        'class' => 'btn btn-danger btn-sm',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Tem certeza de que deseja remover este item?',
                                    ]
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Resumo do Pedido -->
        <div class="col-md-4">
            <h3>Resumo do Pedido</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total:
                    <span class="font-weight-bold"><?=Yii::$app->formatter->asCurrency($totalAmount, 'EUR')?> EUR</span>
                </li>
            </ul>

            <div class="btn btn-primary btn-xs d-flex align-items-center justify-content-center px-4 ">
                <!--TODO: SE NAO TIVER LOGADO E QUISER FINALIZAR COMPRA VAI SER REDIRECIONADO PARA O LOGIN -->
                <?= Html::a(
                    '<div class="d-flex align-items-center ">
                            <i class="fas fa-shopping-cart fa-lg mr-3"></i>
                            <span class="font-weight-bold mr-2">Finalizar Compra</span>
                        </div>',
                    ['checkout/index'],
                    [
                        'class' => 'text-decoration-none text-reset',
                        'encode' => false,
                    ]
                ) ?>
            </div>

            <div class="btn btn-secondary btn-xs d-flex align-items-center justify-content-center px-4 mt-2">
                <!--TODO: SE NAO TIVER LOGADO E QUISER FINALIZAR COMPRA VAI SER REDIRECIONADO PARA O LOGIN -->
                <?= Html::a(
                    '<div class="d-flex align-items-center ">
                            <i class="fas fa-arrow-left fa-lg mr-3"></i>
                            <span class="font-weight-bold mr-2">Continuar Comprando</span>
                        </div>',
                    ['product/index'],
                    [
                        'class' => 'text-decoration-none text-reset',
                        'encode' => false,
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>
