<?php


namespace common\tests\Functional;

use common\models\Invoices;
use common\models\Orders;
use common\tests\UnitTester;

class CreateInvoiceTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {

    }
    public function testCreateInvoice()
    {
        // Cria um pedido para o teste
        $order = new Orders();
        $order->user_id = 20;
        $order->id = 200; // Defina o ID manualmente ou remova essa linha se a PK for auto-increment
       // $order->customer_id = 20; // Substitua pelo ID de um cliente válido
        $order->total_price = 500.00;
        $order->status = 'completed';
        $this->assertTrue($order->save(), 'O pedido não foi salvo corretamente.');

        // Cria a fatura associada
        $invoice = new Invoices();
        $invoice->order_id = $order->id;  // Use o ID do pedido criado acima
        $invoice->invoice_number = "INV-677c593888f19";
        $invoice->total_amount = 200.50;
        $invoice->status = 'paid';
        $invoice->invoice_date = date('Y-m-d');

        if (!$invoice->save()) {
            var_dump($invoice->getErrors()); // Exibe os erros de validação
            die();
        }

        $this->assertTrue($invoice->save(), 'A fatura não foi salva corretamente.');
        $this->assertNotNull(Invoices::findOne(['order_id' => $order->id]), 'Fatura não encontrada no banco.');
    }
}
