<?php

namespace common\tests\Functional;

use common\models\Orders;
use Codeception\Test\Unit;

class UpdateOrderStatusTest extends Unit
{
    protected function _before()
    {
        // Configuração inicial antes de cada teste, se necessário
    }

    public function testUpdateOrderStatus()
    {
        // Insere um pedido diretamente no banco para o teste
        $order = new Orders();
        $order->id = 5;
        $order->user_id = 5;
        $order->order_date = '2024-12-03';
        $order->status = 'Pending';
        $order->total_price = 180.00;
        $order->created_at = '2024-12-24 00:40:07';
        $order->updated_at = '2024-12-24 00:40:07';
        $this->assertTrue($order->save(), 'Pedido de teste não foi salvo no banco.');

        // Busca o pedido para garantir que foi salvo
        $orderFromDb = Orders::findOne(5);
        $this->assertNotNull($orderFromDb, 'O pedido com ID 5 não foi encontrado no banco.');

        // Atualiza o status do pedido
        $orderFromDb->status = 'Completed';
        $this->assertTrue($orderFromDb->save(), 'Status do pedido não foi atualizado corretamente.');

        // Verifica se a atualização foi realizada
        $this->assertEquals('Completed', $orderFromDb->status, 'O status do pedido não foi alterado.');
    }
}