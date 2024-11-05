<?php

use yii\db\Migration;

/**
 * Class m241105_223659_insert_fake_producers
 */
class m241105_223659_insert_fake_producers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Inserindo produtores
        $this->batchInsert('Producers',['user_id','winery_name','location','document_id'],[
            [1, 'Produtor_teste Alentejo Um', 'Lisboa', '111.111.101'],
            [2, 'Produtor_teste Alentejo Dois', 'Lisboa', '111.111.102'],
            [3, 'Produtor_teste Alentejo Três', 'Lisboa', '111.111.103'],
            [4, 'Produtor_teste Alentejo Quatro', 'Lisboa', '111.111.104'],
            [5, 'Produtor_teste Alentejo Cinco', 'Lisboa', '111.111.105'],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('Producers');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241105_223659_insert_fake_producers cannot be reverted.\n";

        return false;
    }
    */
}
