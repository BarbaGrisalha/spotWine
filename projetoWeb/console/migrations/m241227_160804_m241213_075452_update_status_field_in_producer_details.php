<?php

use yii\db\Migration;

/**
 * Class m241227_160804_m241213_075452_update_status_field_in_producer_details
 */
class m241227_160804_m241213_075452_update_status_field_in_producer_details extends Migration
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
        echo "m241227_160804_m241213_075452_update_status_field_in_producer_details cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241227_160804_m241213_075452_update_status_field_in_producer_details cannot be reverted.\n";

        return false;
    }
    */
}
