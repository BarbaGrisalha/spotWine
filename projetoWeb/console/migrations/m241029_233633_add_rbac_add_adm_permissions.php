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
        $auth = Yii::$app->authManager;

        // Verificar se a role "admin" já existe
        $adminRole = $auth->getRole('admin');
        if (!$adminRole) {
            $adminRole = $auth->createRole('admin');
            $auth->add($adminRole);
        } else {
            echo "Role 'admin' já existe. Nenhuma alteração foi feita.\n";
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $adminRole = $auth->getRole('admin');
        if ($adminRole) {
            $auth->remove($adminRole);
        }
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
