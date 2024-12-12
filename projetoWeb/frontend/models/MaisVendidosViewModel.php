<?php

namespace frontend\models;

class maisVendidosViewModel extends BaseProductViewModel
{
    public function isOnPromotion()
    {
        return false;
    }

    public function getFinalPrice()
    {
        return $this->product->price;
    }
}