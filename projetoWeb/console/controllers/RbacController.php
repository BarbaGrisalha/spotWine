<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\rbac\OwnPromotionRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Limpar todas as roles e permissões existentes
        $auth->removeAll();

        // Adicionar regras
        $this->addRules($auth);

        // Criar permissões
        $this->addPermissions($auth);

        // Criar roles e associar permissões
        $this->addRoles($auth);

        echo "RBAC configurado com sucesso.\n";
    }

    /**
     * Adiciona regras ao sistema de RBAC.
     *
     * @param \yii\rbac\ManagerInterface $auth
     */
    private function addRules($auth)
    {
        $ownPromotionRule = new OwnPromotionRule();
        $auth->add($ownPromotionRule);
    }

    /**
     * Adiciona permissões ao sistema de RBAC.
     *
     * @param \yii\rbac\ManagerInterface $auth
     */
    private function addPermissions($auth)
    {
        // Permissão para gerenciar produtos
        $manageProducts = $auth->createPermission('manageProducts');
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

        // Permissão para criar usuários
        $createUsers = $auth->createPermission('createUsers');
        $createUsers->description = 'Criar utilizadores';
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
