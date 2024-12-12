<?php

use yii\db\Migration;

/**
 * Class m241207_005340_add_name_to_promotions
 */
class m241207_005340_add_name_to_promotions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Adiciona a coluna 'name' à tabela 'promotions' logo após 'promotion_id'
        $this->addColumn('{{%promotions}}', 'name', $this->string(255)->notNull()->after('promotion_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove a coluna 'name' da tabela 'promotions'
        $this->dropColumn('{{%promotions}}', 'name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241207_005340_add_name_to_promotions cannot be reverted.\n";

        return false;
    }
    */
}
