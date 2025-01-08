<?php


namespace common\tests\Functional;

use common\models\Categories;
use common\tests\UnitTester;

class CreateCategoryTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {

    }

    public function testCreateCategory()
    {
        $category = new Categories();
        $category->name = 'Vinhos SemTinta';

        $this->assertTrue($category->save(), 'A categoria não foi salva corretamente.');
        $this->assertNotNull(Categories::findOne(['name' => 'Vinhos SemTinta']), 'Categoria não foi encontrada no banco.');
    }

}
