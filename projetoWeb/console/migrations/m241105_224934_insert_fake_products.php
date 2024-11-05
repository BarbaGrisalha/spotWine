<?php

use yii\db\Migration;

/**
 * Class m241105_224934_insert_fake_products
 */
class m241105_224934_insert_fake_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Inserindo produtos para cada produtor
        $produtos = []; // Array para armazenar os produtos
        for ($producerId = 1; $producerId <= 5; $producerId++) {
            for ($i = 1; $i <= 5; $i++) {
                $produtos[] = [
                    'producer_id' => $producerId,
                    'category_id' => rand(1, 5), // Categoria aleatória entre 1 e 5
                    'name' => "Vinho Teste {$producerId} - {$i}",
                    'description' => 'Descrição do vinho teste.',
                    'price' => rand(10, 100), // Preço aleatório entre 10 e 100
                    'stock' => rand(50, 200) // Estoque aleatório entre 50 e 200
                ];
            }
        }

        // Executa a inserção em massa dos produtos
        $this->batchInsert(
            'Products',
            ['producer_id', 'category_id', 'name', 'description', 'price', 'stock'],
            $produtos
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->delete('Products');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241105_224934_insert_fake_products cannot be reverted.\n";

        return false;
    }
    */
}
