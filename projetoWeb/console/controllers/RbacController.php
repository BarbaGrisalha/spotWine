<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Limpar todas as roles e permissões existentes
        $auth->removeAll();

        // Criar permissões
        /*
         * Notamos que primeiro é criada a permissão, depois ela é
         * implementada a quem precisa dela **/
        $manageProducts = $auth->createPermission('manageProducts');//Não alterei esse aqui.
        $manageProducts->description = 'Gerenciar produtos';
        $auth->add($manageProducts);

        $createProducts = $auth->createPermission('createProducts');
        $createProducts->description='Criar produtos';
        $auth->add($createProducts);

        $readProducts = $auth->createPermission('readProducts');
        $readProducts->description = 'Ler produtos';
        $auth->add($readProducts);

        $updateProducts = $auth->createPermission('updateProducts');
        $updateProducts->description = 'Atualizar produtos';
        $auth->add($updateProducts);

        $deleteProducts = $auth->createPermission('deleteProducts');
        $deleteProducts->description = 'Deletar produtos';
        $auth->add($deleteProducts);

        $accessBackend = $auth->createPermission('accessBackend');//Ok esse está correto.
        $accessBackend->description = 'Acessar painel administrativo';
        $auth->add($accessBackend);

        $createUsers = $auth->createPermission('createUsers');
        $createUsers->description = 'Criar utilizador';
        $auth->add($createUsers);

        // Criar roles Consumidor
        $consumer = $auth->createRole('consumer');
        $auth->add($consumer);

        // Criar roles Produtor
        $producer = $auth->createRole('producer');
        $auth->add($producer);
        $auth->addChild($producer,$createProducts);
        $auth->addChild($producer,$readProducts);
        $auth->addChild($producer,$updateProducts);
        $auth->addChild($producer,$deleteProducts);

        // Criar roles Administrador
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $producer); // Admin herda permissões de produtor
        $auth->addChild($admin, $accessBackend); // Admin pode acessar o backend
        $auth->addChild($admin, $createUsers);// Admin pode criar utilizadores.
        $auth->addChild($admin, $createProducts); //Admin pode criar produtos.

        echo "Roles e permissões configuradas com sucesso.\n";
    }
}