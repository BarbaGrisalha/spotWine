<?php

use yii\db\Migration;

/**
 * Class m241224_003041_alter_orders_and_order_items
 */
class m241224_003041_alter_orders_and_order_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%orders}}';

        // Verifique se a coluna já existe antes de adicioná-la
        if (!$this->db->getTableSchema($table)->getColumn('invoice_id')) {
            $this->addColumn($table, 'invoice_id', $this->integer()->defaultValue(null));
        }

        if (!$this->db->getTableSchema($table)->getColumn('created_at')) {
            $this->addColumn($table, 'created_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
        }

        if (!$this->db->getTableSchema($table)->getColumn('updated_at')) {
            $this->addColumn($table, 'updated_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        }

        // Renomear a chave primária apenas se necessário
        if ($this->db->getTableSchema($table)->getColumn('order_id')) {
            $this->renameColumn($table, 'order_id', 'id');
        }

        // Para a tabela order_items
        $orderItemsTable = '{{%order_items}}';

        if ($this->db->getTableSchema($orderItemsTable)->getColumn('order_item_id')) {
            $this->renameColumn($orderItemsTable, 'order_item_id', 'id');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = '{{%orders}}';

        if ($this->db->getTableSchema($table)->getColumn('id')) {
            $this->renameColumn($table, 'id', 'order_id');
        }

        $this->dropColumn($table, 'invoice_id');
        $this->dropColumn($table, 'created_at');
        $this->dropColumn($table, 'updated_at');

        $orderItemsTable = '{{%order_items}}';

        if ($this->db->getTableSchema($orderItemsTable)->getColumn('id')) {
            $this->renameColumn($orderItemsTable, 'id', 'order_item_id');
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241224_003041_alter_orders_and_order_items cannot be reverted.\n";

        return false;
    }
    */


}
