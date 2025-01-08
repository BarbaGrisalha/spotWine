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
        $I->wait(2); // wait for page to be opened
        $I->see('O Mercado de Vinhos Diretamente das Caves');

    }
}
