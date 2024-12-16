<?php

use yii\db\Migration;

/**
 * Class m241213_074820_update_consumer_and_producers
 */
class m241213_074820_update_consumer_and_producers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Renomear a tabela `user_details` para `consumer_details`
        $this->renameTable('{{%user_details}}', '{{%consumer_details}}');

        // Renomear a tabela `producers` para `producer_details`
        $this->renameTable('{{%producers}}', '{{%producer_details}}');

        // Alterar estrutura da tabela `producer_details`
        // Renomear `producer_id` para `id`
        $this->renameColumn('{{%producer_details}}', 'producer_id', 'id');

        // Adicionar colunas `nif` e `status`
        $this->addColumn('{{%producer_details}}', 'nif', $this->string(15)->notNull()->after('user_id'));
        $this->addColumn('{{%producer_details}}', 'status', $this->string(10)->defaultValue('active')->after('nif'));

        // Remover colunas `contact_number` e `role`
        $this->dropColumn('{{%producer_details}}', 'contact_number');
        $this->dropColumn('{{%producer_details}}', 'role');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Reverter alterações
        // Renomear `id` de volta para `producer_id`
        $this->renameColumn('{{%producer_details}}', 'id', 'producer_id');

        // Remover colunas `nif` e `status`
        $this->dropColumn('{{%producer_details}}', 'nif');
        $this->dropColumn('{{%producer_details}}', 'status');

        // Adicionar colunas removidas
        $this->addColumn('{{%producer_details}}', 'contact_number', $this->string()->after('location'));
        $this->addColumn('{{%producer_details}}', 'role', $this->string(50)->after('contact_number'));

        // Renomear tabela `producer_details` de volta para `producers`
        $this->renameTable('{{%producer_details}}', '{{%producers}}');

        // Renomear tabela `consumer_details` de volta para `user_details`
        $this->renameTable('{{%consumer_details}}', '{{%user_details}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241213_074820_update_consumer_and_producers cannot be reverted.\n";

        return false;
    }
    */
}
