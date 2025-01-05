<?php

namespace frontend\widgets;

use common\models\Cart;
use common\models\CartItems;
use frontend\models\PromocoesViewModel;
use yii\base\Widget;

class CartWidget extends Widget
{
    public function run()
    {
        $userId = \Yii::$app->user->id;

        // Buscar itens do carrinho
        $cartItems = CartItems::find()
            ->with('product')
            ->where(['cart_id' => Cart::findOrCreateCart($userId)->id])
            ->all();

        $cartViewModels = array_map(function ($item) {
            return new promocoesViewModel($item->product, $item->quantity);
        }, $cartItems);

        $totalAmount = array_reduce($cartViewModels, function ($sum, $model) {
            return $sum + $model->getTotalPrice();
        }, 0);

        return $this->render('cart', [
            'cartViewModels' => $cartViewModels,
            'totalAmount' => $totalAmount,
            'cartItems' => $cartItems,
        ]);

    }
}
