<?php

namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage('/site/index');
        $I->see('Login');
        $I->seeLink('Vinhos');

        $I->click('Vinhos');
        $I->wait(2); // Aguarda o carregamento da página

        // Garantir que o elemento existe antes de clicar
        $I->seeElement('img', ['alt' => 'Imagem garrafa de vinho']);

        // Clicar diretamente no elemento via XPath
        $I->click('//img[@alt="Imagem garrafa de vinho"]');
        $I->wait(4);

        $I->click('Adicionar ao Carrinho');
        $I->wait(4);

    }
}
