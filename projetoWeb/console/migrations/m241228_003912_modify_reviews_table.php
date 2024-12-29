<?php

use yii\db\Migration;

/**
 * Class m241228_003912_modify_reviews_table
 */
class m241228_003912_modify_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('reviews', 'review_id', 'id');
        $this->alterColumn('reviews', 'rating', $this->tinyInteger()->notNull()->unsigned()->check('rating >= 1 AND rating <= 5'));
        $this->alterColumn('reviews', 'created_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('reviews', 'rating', $this->integer());
        $this->alterColumn('reviews', 'created_at', $this->timestamp()->defaultValue(null));

        $this->renameColumn('reviews', 'id', 'review_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241228_003912_modify_reviews_table cannot be reverted.\n";

        return false;
    }
    */
}
