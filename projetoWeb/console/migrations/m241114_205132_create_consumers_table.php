<?php
use yii\db\Migration;

/**
 * Handles the creation of table `{{%consumers}}`.
 */
class m241114_205132_create_consumers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%consumers}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->text()->notNull(),
            'apelido' => $this->text()->notNull(),
            'email' => $this->string()->unique(),
            'password' => $this->string()->notNull(),
            'nif_consumer' => $this->string()->notNull()->unique(),
            'telefone' => $this->string(),
            'celular' => $this->string(),
            'address' => $this->text()->notNull(),
            'codigo_postal' => $this->string(),
            'cidade' => $this->string()->notNull(),
            'pais' => $this->string()->notNull(),
        ]);

        // Adicionando a chave estrangeira para user_id
        $this->addForeignKey(
            'fk-consumers-user_id',
            '{{%consumers}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Removendo a chave estrangeira antes de apagar a tabela
        $this->dropForeignKey('fk-consumers-user_id', '{{%consumers}}');

        $this->dropTable('{{%consumers}}');
    }
}