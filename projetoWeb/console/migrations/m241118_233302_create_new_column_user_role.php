<?php

use yii\db\Migration;

/**
 * Class m241118_233302_create_new_column_user_role
 */
class m241118_233302_create_new_column_user_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','role',$this->string()->notNull()->defaultValue('consumidor'));
        $this->update('user',['role'=> 'admin'],['id'=>1]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('user','role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241118_233302_create_new_column_user_role cannot be reverted.\n";

        return false;
    }
    */
}
