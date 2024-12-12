<?php

use yii\db\Migration;

/**
 * Class m241212_144503_update_promotions_table
 */
class m241212_144503_update_promotions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Adicionar a coluna promotion_type
        $this->addColumn('{{%promotions}}', 'promotion_type', "ENUM('direct', 'conditional') NOT NULL DEFAULT 'direct'");

        // Alterar a coluna condition_type para ENUM
        $this->alterColumn('{{%promotions}}', 'condition_type', "ENUM('min_purchase', 'quantity') NULL");

        // Atualizar condition_value para ser opcional (apenas para conditional)
        $this->alterColumn('{{%promotions}}', 'condition_value', $this->decimal(10, 2)->null());
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%promotions}}', 'promotion_type');
        $this->alterColumn('{{%promotions}}', 'condition_type', $this->string()->null());
        $this->alterColumn('{{%promotions}}', 'condition_value', $this->decimal(10, 2)->notNull());
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241212_144503_update_promotions_table cannot be reverted.\n";

        return false;
    }
    */
}
