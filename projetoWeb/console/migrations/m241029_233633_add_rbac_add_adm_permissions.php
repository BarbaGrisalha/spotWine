<?php

use yii\db\Migration;

/**
 * Class m241029_233633_add_rbac_add_adm_permissions
 */
class m241029_233633_add_rbac_add_adm_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //configurei aqui o RBAC com DbManager
        $auth = Yii::$app->authManager;

        //Criei aqui a permissão
        $manageAll = $auth->createPermission('manageAll');
        $manageAll->description = 'Manage all';
        $auth->add($manageAll);

        //Criado o papel/role do administrador
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);

        //Associei aqui a permissão ao papel/role
        $auth->addChild($adminRole,$manageAll);

        //Associei o papel/role de aministrador a um utilizador específico
        $auth->assign($adminRole,1); //ATENÇÃO. o ID '1' representa o id admin que já está na base

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //Configuração do RBAC
       $auth = Yii::$app->authManager;
       //Remover permissão e o papel de administrador
        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241029_233633_add_rbac_add_adm_permissions cannot be reverted.\n";

        return false;
    }
    */
}
