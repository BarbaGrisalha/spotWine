<?php

namespace console\controllers;

use common\models\Cart;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionRun()
    {
        $cart = Cart::findOne(1);
        $items = $cart->getCartItems()->with('product')->all();
        var_dump($items);
    }
}
