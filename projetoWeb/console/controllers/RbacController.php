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
        $manageProducts = $auth->createPermission('manageProducts');
        $manageProducts->description = 'Gerenciar produtos';
        $auth->add($manageProducts);

        $accessBackend = $auth->createPermission('accessBackend');
        $accessBackend->description = 'Acessar painel administrativo';
        $auth->add($accessBackend);

        $createUsers = $auth->createPermission('createUsers');
        $createUsers->description = 'Criar utilizador';
        $auth->add($createUsers);

        // Criar roles
        $consumer = $auth->createRole('consumer');
        $auth->add($consumer);

        $producer = $auth->createRole('producer');
        $auth->add($producer);
        $auth->addChild($producer, $manageProducts); // Produtor pode gerenciar produtos

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $producer); // Admin herda permissões de produtor
        $auth->addChild($admin, $accessBackend); // Admin pode acessar o backend
        $auth->addChild($admin,$createUsers);// Admin pode criar utilizadores.

        echo "Roles e permissões configuradas com sucesso.\n";
    }
}