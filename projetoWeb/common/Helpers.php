<?php
namespace common\helpers;

class CartHelper
{
    public static function calculateCartTotal(array $items): float
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}