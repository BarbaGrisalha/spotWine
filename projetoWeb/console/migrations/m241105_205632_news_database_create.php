<?php

use yii\db\Migration;

/**
 * Class m241105_205632_news_database_create
 */
class m241105_205632_news_database_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Table: Users
        $this->createTable('Users', [
            'user_id' => $this->primaryKey(),
            'name' => $this->string(100),
            'email' => $this->string(100)->unique(),
            'password' => $this->string(255),
            'role' => "ENUM('consumer', 'producer') NOT NULL",
        ]);

        // Table: Producers
        $this->createTable('Producers', [
            'producer_id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'winery_name' => $this->string(100),
            'location' => $this->string(255),
            'document_id' => $this->string(255),
        ]);
        $this->addForeignKey('fk_producers_user_id', 'Producers', 'user_id', 'Users', 'user_id');

        // Table: Categories
        $this->createTable('Categories', [
            'category_id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->unique(),
        ]);

        // Table: Products
        $this->createTable('Products', [
            'product_id' => $this->primaryKey(),
            'producer_id' => $this->integer(),
            'category_id' => $this->integer(),
            'name' => $this->string(100),
            'description' => $this->text(),
            'price' => $this->decimal(10, 2),
            'stock' => $this->integer(),
            'image_url' => $this->string(255),
        ]);
        $this->addForeignKey('fk_products_producer_id', 'Products', 'producer_id', 'Producers', 'producer_id');
        $this->addForeignKey('fk_products_category_id', 'Products', 'category_id', 'Categories', 'category_id');

        // Table: Promotions
        $this->createTable('Promotions', [
            'promotion_id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'discount_percentage' => $this->decimal(5, 2),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
        ]);
        $this->addForeignKey('fk_promotions_product_id', 'Promotions', 'product_id', 'Products', 'product_id');

        // Table: Orders
        $this->createTable('Orders', [
            'order_id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'order_date' => $this->date(),
            'status' => $this->string(50),
            'total_price' => $this->decimal(10, 2),
        ]);
        $this->addForeignKey('fk_orders_user_id', 'Orders', 'user_id', 'Users', 'user_id');

        // Table: Order_Items
        $this->createTable('Order_Items', [
            'order_item_id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'quantity' => $this->integer(),
            'unit_price' => $this->decimal(10, 2),
        ]);
        $this->addForeignKey('fk_order_items_order_id', 'Order_Items', 'order_id', 'Orders', 'order_id');
        $this->addForeignKey('fk_order_items_product_id', 'Order_Items', 'product_id', 'Products', 'product_id');

        // Table: Contests
        $this->createTable('Contests', [
            'contest_id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string(100),
            'description' => $this->text(),
            'registration_start_date' => $this->date(),
            'registration_end_date' => $this->date(),
            'contest_start_date' => $this->date(),
            'contest_end_date' => $this->date(),
            'image_path' => $this->string(255),
        ]);
        $this->addForeignKey('fk_contests_category_id', 'Contests', 'category_id', 'Categories', 'category_id');

        // Table: Contest_Participations
        $this->createTable('Contest_Participations', [
            'participation_id' => $this->primaryKey(),
            'contest_id' => $this->integer(),
            'producer_id' => $this->integer(),
            'product_id' => $this->integer(),
            'score' => $this->decimal(5, 2),
        ]);
        $this->addForeignKey('fk_contest_participations_contest_id', 'Contest_Participations', 'contest_id', 'Contests', 'contest_id');
        $this->addForeignKey('fk_contest_participations_producer_id', 'Contest_Participations', 'producer_id', 'Producers', 'producer_id');
        $this->addForeignKey('fk_contest_participations_product_id', 'Contest_Participations', 'product_id', 'Products', 'product_id');

        // Table: Reviews
        $this->createTable('Reviews', [
            'review_id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'product_id' => $this->integer(),
            'rating' => $this->integer()->check('rating >= 1 AND rating <= 5'),
            'comment' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_reviews_user_id', 'Reviews', 'user_id', 'Users', 'user_id');
        $this->addForeignKey('fk_reviews_product_id', 'Reviews', 'product_id', 'Products', 'product_id');

        // Table: Blog_Posts
        $this->createTable('Blog_Posts', [
            'post_id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string(255),
            'content' => $this->text(),
            'image_url' => $this->string(255),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_blog_posts_user_id', 'Blog_Posts', 'user_id', 'Users', 'user_id');

        // Table: Comments
        $this->createTable('Comments', [
            'comment_id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'user_id' => $this->integer(),
            'comment' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_comments_post_id', 'Comments', 'post_id', 'Blog_Posts', 'post_id');
        $this->addForeignKey('fk_comments_user_id', 'Comments', 'user_id', 'Users', 'user_id');

        // Table: Tags
        $this->createTable('Tags', [
            'tag_id' => $this->primaryKey(),
            'name' => $this->string(100)->unique(),
        ]);

        // Table: Blog_Tags
        $this->createTable('Blog_Tags', [
            'blog_tag_id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);
        $this->addForeignKey('fk_blog_tags_post_id', 'Blog_Tags', 'post_id', 'Blog_Posts', 'post_id');
        $this->addForeignKey('fk_blog_tags_tag_id', 'Blog_Tags', 'tag_id', 'Tags', 'tag_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Código para remover tabelas na ordem inversa da criação
        $this->dropTable('Blog_Tags');
        $this->dropTable('Tags');
        $this->dropTable('Comments');
        $this->dropTable('Blog_Posts');
        $this->dropTable('Reviews');
        $this->dropTable('Contest_Participations');
        $this->dropTable('Contests');
        $this->dropTable('Order_Items');
        $this->dropTable('Orders');
        $this->dropTable('Promotions');
        $this->dropTable('Products');
        $this->dropTable('Categories');
        $this->dropTable('Producers');
        $this->dropTable('Users');
    }
}