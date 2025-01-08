<?php


namespace common\tests\Unit;

use common\models\Categories;
use common\models\ProducerDetails;
use common\models\Product;
use common\tests\UnitTester;

class TestRelationsTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {

    }

    // Teste para verificar os relacionamentos
    public function testRelations()
    {
        // Teste de relacionamento com o Produtor
        $product = Product::findOne(1); // Suponha que o ID 1 seja um produto válido
        $this->assertInstanceOf(ProducerDetails::class, $product->producers);

        // Teste de relacionamento com a Categoria
        $this->assertInstanceOf(Categories::class, $product->categories);

        // Teste de método isFavorited
        $userId = 1; // Suponha que o usuário com ID 1 exista
        $product = Product::findOne(1); // Suponha que o produto com ID 1 exista

    }


}
