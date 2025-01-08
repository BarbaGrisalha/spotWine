<?php

namespace console\controllers;

use common\rbac\OwnPostRule;
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

        $ownPostRule = new OwnPostRule();
        $auth->add($ownPostRule);
    }

    /**
     * Adiciona permissões ao sistema de RBAC.
     *
     * @param \yii\rbac\ManagerInterface $auth
     */
    private function addPermissions($auth)
    {
        // Permissões de produtos
        $manageProducts = $auth->createPermission('manageProducts');
        $manageProducts->description = 'Gerenciar produtos';
        $auth->add($manageProducts);

        $createProducts = $auth->createPermission('createProducts');
        $createProducts->description = 'Criar produtos';
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

        // Permissão para acessar backend
        $accessBackend = $auth->createPermission('accessBackend');
        $accessBackend->description = 'Acessar painel administrativo';
        $auth->add($accessBackend);

        // Permissão para criar usuários
        $createUsers = $auth->createPermission('createUsers');
        $createUsers->description = 'Criar utilizadores';
        $auth->add($createUsers);

        // Permissões específicas do blog
        $createPosts = $auth->createPermission('createPosts');
        $createPosts->description = 'Criar posts no blog';
        $auth->add($createPosts);

        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Atualizar seus próprios posts';
        $updateOwnPost->ruleName = 'isOwnPost'; // Regra associada
        $auth->add($updateOwnPost);

        $deleteOwnPost = $auth->createPermission('deleteOwnPost');
        $deleteOwnPost->description = 'Deletar seus próprios posts';
        $deleteOwnPost->ruleName = 'isOwnPost'; // Associa a regra
        $auth->add($deleteOwnPost);


        $deleteAllPosts = $auth->createPermission('deleteAllPosts');
        $deleteAllPosts->description = 'Deletar qualquer post';
        $auth->add($deleteAllPosts);

        $commentOnPosts = $auth->createPermission('commentOnPosts');
        $commentOnPosts->description = 'Comentar em posts';
        $auth->add($commentOnPosts);
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

        $commentOnPosts = $auth->getPermission('commentOnPosts');
        if ($commentOnPosts) {
            $auth->addChild($consumer, $commentOnPosts); // Consumidor pode comentar em posts
        }

        // Role: Producer
        $producer = $auth->createRole('producer');
        $auth->add($producer);

        $permissions = ['manageProducts', 'ownPromotion', 'createPosts', 'updateOwnPost', 'deleteOwnPost', 'commentOnPosts', 'accessBackend'];
        foreach ($permissions as $permissionName) {
            $permission = $auth->getPermission($permissionName);
            if ($permission) {
                $auth->addChild($producer, $permission);
            }
        }

        // Role: Admin
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $permissionsForAdmin = ['accessBackend', 'createUsers', 'deleteAllPosts'];
        foreach ($permissionsForAdmin as $permissionName) {
            $permission = $auth->getPermission($permissionName);
            if ($permission) {
                $auth->addChild($admin, $permission);
            }
        }

        $auth->addChild($admin, $producer); // Admin herda permissões de produtor

        echo "Roles e permissões configuradas com sucesso.\n";
    }


}
