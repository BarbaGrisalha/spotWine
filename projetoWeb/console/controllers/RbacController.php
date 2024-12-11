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

        // Permissão para acessar o backend
        $accessBackend = $auth->createPermission('accessBackend');
        $accessBackend->description = 'Acessar painel administrativo';
        $auth->add($accessBackend);

        // Permissão para criar usuários
        $createUsers = $auth->createPermission('createUsers');
        $createUsers->description = 'Criar utilizadores';
        $auth->add($createUsers);

        // Permissão para gerenciar promoções do próprio produtor (com regra)
        $ownPromotion = $auth->createPermission('ownPromotion');
        $ownPromotion->description = 'Gerenciar suas próprias promoções';
        $ownPromotion->ruleName = 'isOwnPromotion'; // Nome da regra associada
        $auth->add($ownPromotion);
    }

    /**
     * Adiciona roles ao sistema de RBAC e associa permissões.
     *
     * @param \yii\rbac\ManagerInterface $auth
     */
    private function addRoles($auth)
    {
        // Role: Consumer
        $consumer = $auth->createRole('consumer');
        $auth->add($consumer);

        // Role: Producer
        $producer = $auth->createRole('producer');
        $auth->add($producer);
        $auth->addChild($producer, $auth->getPermission('manageProducts')); // Associa gerenciar produtos
        $auth->addChild($producer, $auth->getPermission('ownPromotion'));   // Associa gerenciar promoções próprias

        // Role: Admin
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $producer);                     // Admin herda permissões de produtor
        $auth->addChild($admin, $auth->getPermission('accessBackend')); // Admin pode acessar o backend
        $auth->addChild($admin, $auth->getPermission('createUsers'));   // Admin pode criar usuários
    }
}
