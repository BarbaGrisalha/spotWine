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
        $I->maximizeWindow();
        $I->seeLink('Vinhos');

        $I->click('Vinhos');
        $I->wait(2); // Aguarda o carregamento da página

        // Garantir que o elemento existe antes de clicar
        $I->seeElement('img', ['alt' => 'Imagem garrafa de vinho']);

        // Clicar diretamente no elemento via XPath
        $I->click('//img[@alt="Imagem garrafa de vinho"]');

        $I->click('Adicionar ao Carrinho');
        $I->wait(2);

        $I->click(['xpath'=>'//*[@id="dropdownCart"]/i']);

        $I->see('Finalizar Compra');
        $I->click(['xpath'=>'/html/body/div[2]/div/div/nav/div[3]/div/div[1]/div/div/div[4]/a/div/span[1]']);

        $I->click(['xpath'=>'/html/body/main/div/div/div[2]/form/div/div/label[1]/input']);
        $I->wait(2);

        $I->click(['xpath'=>' /html/body/main/div/div/div[2]/form/button']);


        $I->wait(2);

        $I->click(['xpath'=>'/html/body/main/div/div/form/button']);
        $I->wait(2);

        $I->see('Pedido Confirmado!');


    }
}
