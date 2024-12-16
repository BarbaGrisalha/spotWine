<?php

use yii\db\Migration;

/**
 * Class m241213_075452_update_status_field_in_producer_details
 */
class m241213_075452_update_status_field_in_producer_details extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Atualizar a coluna 'status' para ter os mesmos atributos de 'consumer_details'
        $this->alterColumn('{{%producer_details}}', 'status', $this->tinyInteger(1)->notNull()->defaultValue(1)->comment('0=Desativado, 1=Ativado'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Reverter as alterações se necessário (ajustar conforme o estado original da coluna)
        $this->alterColumn('{{%producer_details}}', 'status', $this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241213_075452_update_status_field_in_producer_details cannot be reverted.\n";

        return false;
    }
    */
}
