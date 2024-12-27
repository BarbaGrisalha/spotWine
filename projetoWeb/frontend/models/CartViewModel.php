<?php

namespace frontend\models;

use common\models\Product;

class CartViewModel
{
    public $product;
    public $quantity;
    public $isOnPromotion;
    public $finalPrice;

    public function __construct($cartItem)
    {
        $this->product = $cartItem->product;
        $this->quantity = $cartItem->quantity;
        $this->isOnPromotion = $this->product->promotion !== null; // Exemplo, se existir promoção
        $this->finalPrice = $this->isOnPromotion
            ? $this->product->getFinalPrice()
            : $this->product->price;
    }
}
