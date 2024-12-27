<?php

use yii\db\Migration;

/**
 * Class m241220_143055_add_foreign_key_to_cart_items
 */
class m241220_143055_add_foreign_key_to_cart_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Adiciona a coluna product_id, caso não exista
        if (!$this->db->getTableSchema('{{%cart_items}}')->getColumn('product_id')) {
            $this->addColumn('{{%cart_items}}', 'product_id', $this->integer()->notNull()->after('id'));
        }

        // Cria a chave estrangeira para products
        $this->addForeignKey(
            'fk-cart_items-product_id',
            '{{%cart_items}}',  // Tabela `cart_items`
            'product_id',       // Coluna `product_id` em `cart_items`
            '{{%products}}',    // Tabela `products`
            'product_id',       // Coluna `product_id` em `products`
            'CASCADE',          // On delete
            'CASCADE'           // On update
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove a chave estrangeira
        $this->dropForeignKey('fk-cart_items-product_id', '{{%cart_items}}');

        // Remove a coluna product_id
        $this->dropColumn('{{%cart_items}}', 'product_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241220_143055_add_foreign_key_to_cart_items cannot be reverted.\n";

        return false;
    }
    */
}
