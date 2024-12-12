<?php

namespace frontend\models;

abstract class BaseProductViewModel
{
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    abstract public function isOnPromotion();

    abstract public function getFinalPrice();
}