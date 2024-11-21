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
        $manageProducts = $auth->createPermission('manageProducts');
        $manageProducts->description = 'Gerenciar produtos';
        $auth->add($manageProducts);

        $accessBackend = $auth->createPermission('accessBackend');
        $accessBackend->description = 'Acessar painel administrativo';
        $auth->add($accessBackend);

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

        echo "Roles e permissões configuradas com sucesso.\n";
    }
}