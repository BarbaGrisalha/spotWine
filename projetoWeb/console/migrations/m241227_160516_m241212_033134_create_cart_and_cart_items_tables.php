<?php

use yii\db\Migration;

/**
 * Class m241227_160516_m241212_033134_create_cart_and_cart_items_tables
 */
class m241227_160516_m241212_033134_create_cart_and_cart_items_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241227_160516_m241212_033134_create_cart_and_cart_items_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241227_160516_m241212_033134_create_cart_and_cart_items_tables cannot be reverted.\n";

        return false;
    }
    */
}
