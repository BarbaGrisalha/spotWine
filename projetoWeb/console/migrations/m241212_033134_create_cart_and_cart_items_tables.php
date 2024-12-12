<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart}}` and `{{%cart_items}}` with proper checks for existing tables and relations.
 */
class m241212_033134_create_cart_and_cart_items_tables extends Migration
{
    public function safeUp()
    {
        // Verifica se a tabela `cart` já existe
        if ($this->db->schema->getTableSchema('{{%cart}}') === null) {
            $this->createTable('{{%cart}}', [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->null(),
                'session_id' => $this->string()->null(),
                'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ]);

            // Foreign key para `user_id`
            $this->addForeignKey(
                'fk-cart-user_id',
                '{{%cart}}',
                'user_id',
                '{{%user}}',
                'id',
                'SET NULL'
            );
        }

        // Verifica se a tabela `cart_items` já existe
        if ($this->db->schema->getTableSchema('{{%cart_items}}') === null) {
            $this->createTable('{{%cart_items}}', [
                'id' => $this->primaryKey(),
                'cart_id' => $this->integer()->notNull(),
                'product_id' => $this->integer()->notNull(),
                'quantity' => $this->integer()->notNull()->defaultValue(1),
                'price' => $this->decimal(10, 2)->notNull(),
                'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            ]);

            // Foreign key para `cart_id`
            $this->addForeignKey(
                'fk-cart_items-cart_id',
                '{{%cart_items}}',
                'cart_id',
                '{{%cart}}',
                'id',
                'CASCADE'
            );

            // Foreign key para `product_id`
            $this->addForeignKey(
                'fk-cart_items-product_id',
                '{{%cart_items}}',
                'product_id',
                '{{%products}}',
                'product_id',
                'CASCADE'
            );
        }
    }

    public function safeDown()
    {
        // Remove foreign keys e tabelas
        if ($this->db->schema->getTableSchema('{{%cart_items}}') !== null) {
            $this->dropForeignKey('fk-cart_items-product_id', '{{%cart_items}}');
            $this->dropForeignKey('fk-cart_items-cart_id', '{{%cart_items}}');
            $this->dropTable('{{%cart_items}}');
        }

        if ($this->db->schema->getTableSchema('{{%cart}}') !== null) {
            $this->dropForeignKey('fk-cart-user_id', '{{%cart}}');
            $this->dropTable('{{%cart}}');
        }
    }
}

