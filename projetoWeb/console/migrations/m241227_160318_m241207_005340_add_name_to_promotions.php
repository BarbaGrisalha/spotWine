<?php

use yii\db\Migration;

/**
 * Class m241227_160318_m241207_005340_add_name_to_promotions
 */
class m241227_160318_m241207_005340_add_name_to_promotions extends Migration
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
        echo "m241227_160318_m241207_005340_add_name_to_promotions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241227_160318_m241207_005340_add_name_to_promotions cannot be reverted.\n";

        return false;
    }
    */
}
