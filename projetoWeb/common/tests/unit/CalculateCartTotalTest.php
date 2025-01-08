<?php


namespace common\tests\Unit;

use common\tests\UnitTester;
use common\helpers\Carthelper;

class CalculateCartTotalTest extends \Codeception\Test\Unit
{
    public function testCalculateCartTotal()
    {
        //Definido os itens do carrinho
        $items = [
            ['price' => 10.0, 'quantity'=>2],//total tem que ser 20
            ['price' => 5.5, 'quantity' =>3],//total tem que ser 16.5
        ];
        //Calculando o total
        $total = CartHelper::calculateCartTotal($items);
        //Verificando se o total está correto
        $this->assertEquals(36.5, $total,  'O total está correto');
    }

}
