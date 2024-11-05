<?php

use yii\db\Migration;

/**
 * Class m241105_222640_insert_fake_costumers
 */
class m241105_222640_insert_fake_costumers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Inserindo consumidores
        $this->batchInsert('Users',['user_id','name','email','password','role'],
            [
                [1,'Consumidor_teste Lisboa Um', 'consumidor1@example.com', 'senha123', 'consumer'],
                [2,'Consumidor_teste Lisboa Dois', 'consumidor2@example.com', 'senha123', 'consumer'],
                [3,'Consumidor_teste Lisboa Três', 'consumidor3@example.com', 'senha123', 'consumer'],
                [4,'Consumidor_teste Lisboa Quatro', 'consumidor4@example.com', 'senha123', 'consumer'],
                [5,'Consumidor_teste Lisboa Cinco', 'consumidor5@example.com', 'senha123', 'consumer'],
            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('Users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241105_222640_insert_fake_costumers cannot be reverted.\n";

        return false;
    }
    */
}
