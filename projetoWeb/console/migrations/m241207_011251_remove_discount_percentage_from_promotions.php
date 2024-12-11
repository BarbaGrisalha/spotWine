<?php

use yii\db\Migration;

/**
 * Class m241207_011251_remove_discount_percentage_from_promotions
 */
class m241207_011251_remove_discount_percentage_from_promotions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Remove a coluna 'discount_percentage' da tabela 'promotions'
        $this->dropColumn('{{%promotions}}', 'discount_percentage');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Adiciona novamente a coluna 'discount_percentage' na tabela 'promotions'
        $this->addColumn('{{%promotions}}', 'discount_percentage', $this->decimal(5, 2)->defaultValue(null));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241207_011251_remove_discount_percentage_from_promotions cannot be reverted.\n";

        return false;
    }
    */
}
