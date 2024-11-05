<?php

use yii\db\Migration;

/**
 * Class m241105_224933_insert_fake_categories
 */
class m241105_224933_insert_fake_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('Categories',['name'],[
            ['Vinho Tinto'],
            ['Vinho Branco'],
            ['Vinho Rose'],
            ['Vinho Verde'],
            ['Espumante']
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('Categories');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241105_224933_insert_fake_categories cannot be reverted.\n";

        return false;
    }
    */
}
