<?php

use yii\db\Migration;

/**
 * Class m241225_220518_add_invoice_number_to_invoices
 */
class m241225_220518_add_invoice_number_to_invoices extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%invoices}}', 'invoice_number', $this->string(255)->notNull()->after('order_id'));

        // Opcional: adicionar índice único para garantir números de fatura únicos
        $this->createIndex(
            'idx-unique-invoice_number',
            '{{%invoices}}',
            'invoice_number',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-unique-invoice_number', '{{%invoices}}');
        $this->dropColumn('{{%invoices}}', 'invoice_number');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241225_220518_add_invoice_number_to_invoices cannot be reverted.\n";

        return false;
    }
    */
}
