<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;

class RbacController extends Controller
{
    public function actionInit()
    {
        /** @var DbManager $auth */
        $auth = Yii::$app->authManager;

        // Limpa roles e permissões existentes
        $auth->removeAll();

        // Cria a role Administrador
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        // Cria a role Produtor
        $produtor = $auth->createRole('produtor');
        $auth->add($produtor);

        // Cria a role Consumidor
        $consumidor = $auth->createRole('consumidor');
        $auth->add($consumidor);

        // Atribuir a role admin ao usuário com ID 1 (alterar conforme necessário)
        $auth->assign($admin, 1);

        echo "Roles e permissões configuradas com sucesso.\n";
    }
}