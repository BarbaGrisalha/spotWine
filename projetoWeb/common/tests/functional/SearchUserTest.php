<?php

namespace common\tests\Functional;

use common\models\UserSearch;
use common\models\User;
use common\tests\UnitTester;

class SearchUserTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
        // Configuração inicial antes de cada teste
    }

    public function testSearchUser()
    {
        // Busca um usuário existente no banco de dados
        $user = User::findOne(['username' => 'judas']);

        // Verifica se o usuário foi encontrado
        $this->assertNotNull($user, 'Usuário não encontrado.');

        // Verifica os dados do usuário encontrado
        $this->assertEquals('judas', $user->username, 'Nome de usuário incorreto.');
        $this->assertEquals('judas@gmail.com', $user->email, 'E-mail incorreto.');
    }
}
