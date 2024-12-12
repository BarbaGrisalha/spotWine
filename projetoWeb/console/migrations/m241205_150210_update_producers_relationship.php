<?php

use yii\db\Migration;

/**
 * Class m241205_150210_update_producers_relationship
 */
class m241205_150210_update_producers_relationship extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = $this->getDb();
        $tableSchema = $db->getTableSchema('{{%producers}}');

        if ($tableSchema && isset($tableSchema->foreignKeys['fk_producers_user_id'])) {
            $this->dropForeignKey('fk_producers_user_id', '{{%producers}}');
        } else {
            echo "A chave estrangeira 'fk_producers_user_id' não existe na tabela 'producers'. Nenhuma alteração foi feita.\n";
        }

        // Adicione aqui a nova chave estrangeira ou outras alterações, se necessário.
        // Adiciona a nova chave estrangeira para a tabela `user`
        $this->addForeignKey(
            'fk_producers_user_id',  // Nome da chave estrangeira
            '{{%producers}}',       // Tabela filha
            'user_id',              // Coluna na tabela filha
            '{{%user}}',            // Tabela pai
            'id',                   // Coluna na tabela pai
            'CASCADE',              // Ação na exclusão
            'CASCADE'               // Ação na atualização
        );

        echo "Nova chave estrangeira 'fk_producers_user_id' adicionada com sucesso para a tabela 'user'.\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $db = $this->getDb();
        $tableSchema = $db->getTableSchema('{{%producers}}');

        // Remove a chave estrangeira, se ela existir
        if ($tableSchema && isset($tableSchema->foreignKeys['fk_producers_user_id'])) {
            $this->dropForeignKey('fk_producers_user_id', '{{%producers}}');
            echo "Chave estrangeira 'fk_producers_user_id' removida.\n";
        } else {
            echo "A chave estrangeira 'fk_producers_user_id' não existe. Nenhuma alteração foi feita.\n";
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241205_150210_update_producers_relationship cannot be reverted.\n";

        return false;
    }
    */
}
