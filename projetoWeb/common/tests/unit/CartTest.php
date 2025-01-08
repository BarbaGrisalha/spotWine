<?php

namespace common\tests\Unit;

use common\models\Cart;
use common\models\Product;
use common\models\CartItems;
use yii\web\NotFoundHttpException;

class CartTest extends \Codeception\Test\Unit
{
    public function testAddItem()
    {
        /*
        // Configuração inicial
        $cart = new Cart();
        $cart->save();

        $product = new Product([
            'id' => 1,
            'price' => 50.00,
        ]);
        $product->save();

        // Adicionar um item ao carrinho
        $cartItem = $cart->addItem($product->id, 2);

        $this->assertInstanceOf(CartItems::class, $cartItem);
        $this->assertEquals(2, $cartItem->quantity);
        $this->assertEquals(50.00, $cartItem->price);

        // Adicionar o mesmo item novamente (quantidade deve ser atualizada)
        $updatedCartItem = $cart->addItem($product->id, 3);

        $this->assertEquals($cartItem->id, $updatedCartItem->id);
        $this->assertEquals(5, $updatedCartItem->quantity); // 2 + 3 = 5
        */
    }

    public function testAddItemWithInvalidProduct()
    {

        $cart = new Cart();
        $cart->save();

        $this->expectException(NotFoundHttpException::class);

        // Tentando adicionar um produto inexistente
        $cart->addItem(999, 1);

    }
}