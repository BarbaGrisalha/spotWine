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

        // Renomear `producer_id` para `id`
        $this->renameColumn('{{%producer_details}}', 'producer_id', 'id');

        // Adicionar colunas e `status`
        $this->addColumn('{{%producer_details}}', 'status', $this->string(10)->defaultValue('active')->after('nif'));

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
