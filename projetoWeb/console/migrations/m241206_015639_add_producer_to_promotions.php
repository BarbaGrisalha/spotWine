<?php

use yii\db\Migration;

/**
 * Class m241206_015639_add_producer_to_promotions
 */
class m241206_015639_add_producer_to_promotions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%promotions}}', 'producer_id', $this->integer()->notNull());

        // Add foreign key constraint to producers table
        $this->addForeignKey(
            'fk_promotions_producer_id',
            '{{%promotions}}',
            'producer_id',
            '{{%producers}}',
            'producer_id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_promotions_producer_id', '{{%promotions}}');

        // Drop the producer_id column
        $this->dropColumn('{{%promotions}}', 'producer_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241206_015639_add_producer_to_promotions cannot be reverted.\n";

        return false;
    }
    */
}
