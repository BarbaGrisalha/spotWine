<?php

namespace common\tests\Functional;

use common\models\Cart;
use common\models\CartItems;
use common\models\Product;
use Codeception\Test\Unit;

class AddItemToCartTest extends Unit
{
    protected function _before()
    {
        // Limpar tabelas antes de cada teste
        CartItems::deleteAll();
        Cart::deleteAll();
        Product::deleteAll();
    }

    public function testAddItemToCart()
    {
        // Criar um produto de teste
        $product = new Product();
        $product->producer_id = 1; // Certifique-se de que o produtor com ID 1 existe no banco
        $product->category_id = 1; // Certifique-se de que a categoria com ID 1 existe no banco
        $product->name = 'Vinho Teste';
        $product->description = 'Descrição do vinho teste';
        $product->price = 50.00;
        $product->stock = 10;

        $this->assertTrue($product->save(), 'O produto de teste não foi salvo.');

        // Criar um carrinho de teste
        $cart = new Cart();
        $cart->user_id = 1; // Certifique-se de que o usuário com ID 1 existe no banco
        $this->assertTrue($cart->save(), 'O carrinho de teste não foi salvo.');

        // Adicionar o produto ao carrinho
        $cartItem = new CartItems();
        $cartItem->cart_id = $cart->id;
        $cartItem->product_id = $product->product_id;
        $cartItem->quantity = 2; // Adicionando 2 unidades
        $cartItem->price = $product->price * $cartItem->quantity; // Calculando o preço total
        $cartItem->created_at = date('Y-m-d H:i:s');

        $this->assertTrue($cartItem->save(), 'O item do carrinho não foi salvo.');

        // Verificar se o item foi adicionado corretamente ao banco
        $savedItem = CartItems::findOne(['cart_id' => $cart->id, 'product_id' => $product->product_id]);
        $this->assertNotNull($savedItem, 'Item do carrinho não encontrado no banco.');
        $this->assertEquals(2, $savedItem->quantity, 'A quantidade do item no carrinho não é a esperada.');
        $this->assertEquals(100.00, $savedItem->price, 'O preço total do item no carrinho não é o esperado.');
    }
}