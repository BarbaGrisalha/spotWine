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
        // Check if the column already exists
        if ($this->db->getTableSchema('{{%promotions}}')->getColumn('producer_id') === null) {
            $this->addColumn('{{%promotions}}', 'producer_id', $this->integer()->notNull());

            // Check if the foreign key already exists
            $foreignKeys = $this->db->getSchema()->getTableForeignKeys('{{%promotions}}');
            $foreignKeyExists = false;
            foreach ($foreignKeys as $fk) {
                if ($fk->columnNames === ['producer_id'] && $fk->refTable === '{{%producers}}') {
                    $foreignKeyExists = true;
                    break;
                }
            }

            if (!$foreignKeyExists) {
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
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {// Check if the foreign key exists
        $foreignKeys = $this->db->getSchema()->getTableForeignKeys('{{%promotions}}');
        foreach ($foreignKeys as $fk) {
            if ($fk->columnNames === ['producer_id'] && $fk->refTable === '{{%producers}}') {
                $this->dropForeignKey('fk_promotions_producer_id', '{{%promotions}}');
                break;
            }
        }

        // Check if the column exists
        if ($this->db->getTableSchema('{{%promotions}}')->getColumn('producer_id') !== null) {
            $this->dropColumn('{{%promotions}}', 'producer_id');
        }
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
