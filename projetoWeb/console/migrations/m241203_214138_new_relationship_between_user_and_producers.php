<?php

use yii\db\Migration;

/**
 * Handles adding a foreign key and setting up a relationship between `producer` and `user` tables.
 */
class m241203_214138_new_relationship_between_user_and_producers extends Migration
{
    public function safeUp()
    {
        // Adicionar chave estrangeira ligando producer.user_id ao user.id
        $this->addForeignKey(
            'fk-producers-user_id', // Nome da chave estrangeira
            'producers',            // Tabela filha
            'user_id',             // Coluna na tabela filha
            'user',                // Tabela pai
            'id',                  // Coluna na tabela pai
            'CASCADE',             // Ação na exclusão
            'CASCADE'              // Ação na atualização
        );
    }

    public function safeDown()
    {
        // Remover a chave estrangeira
        $this->dropForeignKey('fk-producer-user_id', 'producer');
    }
}
