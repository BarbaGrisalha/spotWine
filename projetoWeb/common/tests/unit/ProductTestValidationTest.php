<?php
namespace common\tests\Unit;

use common\tests\UnitTester;
use common\models\Product;
use common\models\ProducerDetails;
use common\models\Categories;
use yii\codeception\TestCase;

class ProductTestValidationTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
        // Criar instâncias diretamente no teste
        $producer = new ProducerDetails();
        $producer->user_id = 'Producer Test';
        $producer->save();  // Salvando no banco de dados, se necessário

        $category = new Categories();
        $category->name = 'Category Test';
        $category->save();  // Salvando no banco de dados, se necessário

        $this->producerId = $producer->id;
        $this->categoryId = $category->category_id;

    }


    // Teste para validar regras de validação
    public function testValidation()
    {
        // Criando um produto para teste
        $product = new Product();

        // Caso 1: Testando se o nome é obrigatório
        $product->name = null;
        // Testa a validação e espera um valor falso (validação deve falhar)
        $this->assertFalse($product->validate(), 'A validação deveria falhar devido ao nome ser nulo');

        // Caso 2: Testando o preço
        $product->name = 'Vinho Teste';
        $product->price = null;
        $this->assertFalse($product->validate(), 'A validação deveria falhar devido ao preço nulo');

        // Caso 3: Testando se o produto pode ser validado com dados corretos
        $product->price = 50.00;
        $product->stock = 10;
        $product->producer_id = 100; // Definindo um producer_id válido
        $product->category_id = 1; // Definindo um category_id válido
        //$this->assertTrue($product->validate()); // O produto deve passar pela validação
    }
}