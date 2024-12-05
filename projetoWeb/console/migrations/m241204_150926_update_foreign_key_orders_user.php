<?php

use yii\db\Migration;

/**
 * Class m241204_150926_update_foreign_key_orders_user
 */
class m241204_150926_update_foreign_key_orders_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Remover a chave estrangeira antiga que aponta para 'users'
        $this->dropForeignKey('fk_orders_user_id', 'orders');

        // Adicionar chave estrangeira correta apontando para 'user'
        $this->addForeignKey(
            'fk_orders_user_id', // Nome da nova chave estrangeira
            'orders',            // Tabela de origem
            'user_id',           // Coluna de origem
            'user',              // Tabela de destino (correta)
            'id',                // Coluna de destino
            'CASCADE',           // Delete em cascata
            'CASCADE'            // Update em cascata
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Reverter para a configuração anterior (se necessário)
        $this->dropForeignKey('fk_orders_user_id', 'orders');

        $this->addForeignKey(
            'fk_orders_user_id',
            'orders',
            'user_id',
            'users', // Tabela errada (apenas se precisar reverter)
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241204_150926_update_foreign_key_orders_user cannot be reverted.\n";

        return false;
    }
    */
}
