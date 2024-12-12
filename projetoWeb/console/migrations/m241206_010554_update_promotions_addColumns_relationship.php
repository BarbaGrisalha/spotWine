<?php

use yii\db\Migration;

/**
 * Class m241206_010554_update_promotions_addColumns_relationship
 */
class m241206_010554_update_promotions_addColumns_relationship extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%promotions}}';

        // Adicionar coluna discount_type se não existir
        if ($this->db->getTableSchema($table)->getColumn('discount_type') === null) {
            $this->addColumn($table, 'discount_type', "ENUM('percent', 'fixed') NOT NULL DEFAULT 'percent'");
        }

        // Adicionar coluna discount_value se não existir
        if ($this->db->getTableSchema($table)->getColumn('discount_value') === null) {
            $this->addColumn($table, 'discount_value', $this->decimal(10, 2)->notNull());
        }

        // Adicionar coluna condition_type se não existir
        if ($this->db->getTableSchema($table)->getColumn('condition_type') === null) {
            $this->addColumn($table, 'condition_type', "ENUM('none', 'min_purchase', 'quantity') NOT NULL DEFAULT 'none'");
        }

        // Adicionar coluna condition_value se não existir
        if ($this->db->getTableSchema($table)->getColumn('condition_value') === null) {
            $this->addColumn($table, 'condition_value', $this->decimal(10, 2)->null());
        }

        // Remover chave estrangeira e coluna product_id, se existirem
        $fkName = 'fk_promotions_product_id';
        if (isset($this->db->getTableSchema($table)->foreignKeys[$fkName])) {
            $this->dropForeignKey($fkName, $table);
        }

        if ($this->db->getTableSchema($table)->getColumn('product_id') !== null) {
            $this->dropColumn($table, 'product_id');
        }

        // Criar tabela de relacionamento muitos-para-muitos
        if ($this->db->getTableSchema('{{%promotion_product}}') === null) {
            $this->createTable('{{%promotion_product}}', [
                'promotion_id' => $this->integer()->notNull(),
                'product_id' => $this->integer()->notNull(),
                'PRIMARY KEY(promotion_id, product_id)',
            ]);

            $this->addForeignKey(
                'fk_promotion_product_promotion_id',
                '{{%promotion_product}}',
                'promotion_id',
                '{{%promotions}}',
                'promotion_id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk_promotion_product_product_id',
                '{{%promotion_product}}',
                'product_id',
                '{{%products}}',
                'product_id',
                'CASCADE'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remover tabela de relação muitos-para-muitos
        $this->dropForeignKey('fk_promotion_product_promotion_id', '{{%promotion_product}}');
        $this->dropForeignKey('fk_promotion_product_product_id', '{{%promotion_product}}');
        $this->dropTable('{{%promotion_product}}');

        // Adicionar novamente a coluna product_id
        $this->addColumn('{{%promotions}}', 'product_id', $this->integer());

        // Restaurar chave estrangeira
        $this->addForeignKey(
            'fk_promotions_product_id',
            '{{%promotions}}',
            'product_id',
            '{{%products}}',
            'product_id',
            'CASCADE'
        );

        // Remover novos campos da tabela promotions
        $this->dropColumn('{{%promotions}}', 'discount_type');
        $this->dropColumn('{{%promotions}}', 'discount_value');
        $this->dropColumn('{{%promotions}}', 'condition_type');
        $this->dropColumn('{{%promotions}}', 'condition_value');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241206_010554_update_promotions_addColumns_relationship cannot be reverted.\n";

        return false;
    }
    */
}
