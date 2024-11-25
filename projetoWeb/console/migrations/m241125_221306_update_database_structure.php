<?php

use yii\db\Migration;

/**
 * Class m241125_221306_update_database_structure
 */
class m241125_221306_update_database_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Table: user
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255),
            'email' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'verification_token' => $this->string(255),
        ]);

        // Table: user_details
        $this->createTable('{{%user_details}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'phone_number' => $this->string(15),
            'address' => $this->text(),
            'profile_picture_url' => $this->string(255),
            'date_of_birth' => $this->date(),
        ]);
        $this->addForeignKey(
            'fk-user_details-user_id',
            '{{%user_details}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // Table: producers
        $this->createTable('{{%producers}}', [
            'producer_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'winery_name' => $this->string(100),
            'location' => $this->string(255),
            'document_id' => $this->string(255),
        ]);
        $this->addForeignKey(
            'fk-producers-user_id',
            '{{%producers}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // Table: consumers
        $this->createTable('{{%consumers}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'nif_consumer' => $this->string(255)->notNull(),
            'telefone' => $this->string(255),
            'celular' => $this->string(255),
            'address' => $this->text()->notNull(),
            'codigo_postal' => $this->string(255),
            'cidade' => $this->string(255),
            'pais' => $this->string(255),
        ]);
        $this->addForeignKey(
            'fk-consumers-user_id',
            '{{%consumers}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // Table: categories
        $this->createTable('{{%categories}}', [
            'category_id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->unique(),
        ]);

        // Table: products
        $this->createTable('{{%products}}', [
            'product_id' => $this->primaryKey(),
            'producer_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(100),
            'description' => $this->text(),
            'price' => $this->decimal(10, 2),
            'stock' => $this->integer(),
            'image_url' => $this->string(255),
        ]);
        $this->addForeignKey(
            'fk-products-producer_id',
            '{{%products}}',
            'producer_id',
            '{{%producers}}',
            'producer_id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-products-category_id',
            '{{%products}}',
            'category_id',
            '{{%categories}}',
            'category_id',
            'CASCADE'
        );

        // Table: promotions
        $this->createTable('{{%promotions}}', [
            'promotion_id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'discount_percentage' => $this->decimal(5, 2),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
        ]);
        $this->addForeignKey(
            'fk-promotions-product_id',
            '{{%promotions}}',
            'product_id',
            '{{%products}}',
            'product_id',
            'CASCADE'
        );

        // Table: blog_posts
        $this->createTable('{{%blog_posts}}', [
            'post_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255),
            'content' => $this->text(),
            'image_url' => $this->string(255),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey(
            'fk-blog_posts-user_id',
            '{{%blog_posts}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // Table: notifications
        $this->createTable('{{%notifications}}', [
            'notification_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text(),
            'type' => "ENUM('new_product', 'promotion', 'blog_post', 'contest_update')",
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'is_read' => $this->boolean()->defaultValue(false),
        ]);
        $this->addForeignKey(
            'fk-notifications-user_id',
            '{{%notifications}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notifications}}');
        $this->dropTable('{{%blog_posts}}');
        $this->dropTable('{{%promotions}}');
        $this->dropTable('{{%products}}');
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%consumers}}');
        $this->dropTable('{{%producers}}');
        $this->dropTable('{{%user_details}}');
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241125_221306_update_database_structure cannot be reverted.\n";

        return false;
    }
    */
}
