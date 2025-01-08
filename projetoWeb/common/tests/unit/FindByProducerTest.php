<?php


namespace common\tests\Unit;

use common\models\Product;
use common\tests\UnitTester;

class FindByProducerTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {

    }

    // Teste de consulta por produtor
    public function testFindByProducer()
    {
        $producerId = 1; // ID de produtor para o qual os produtos devem ser encontrados
        $products = Product::findByProducer($producerId)->all();

        $this->assertGreaterThan(0, count($products)); // Certifique-se de que pelo menos um produto seja retornado
        $this->assertEquals($producerId, $products[0]->producer_id); // Verifique se os produtos estão relacionados ao produtor correto
    }
}
