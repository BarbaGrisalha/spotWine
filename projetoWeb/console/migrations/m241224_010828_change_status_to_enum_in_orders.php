<?php

use yii\db\Migration;

/**
 * Class m241224_010828_change_status_to_enum_in_orders
 */
class m241224_010828_change_status_to_enum_in_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE {{%orders}} 
            MODIFY COLUMN status ENUM('Pending', 'Completed', 'Cancelled', 'Shipped') NOT NULL DEFAULT 'Pending'
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
            ALTER TABLE {{%orders}} 
            MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'Pending'
        ");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241224_010828_change_status_to_enum_in_orders cannot be reverted.\n";

        return false;
    }
    */
}
