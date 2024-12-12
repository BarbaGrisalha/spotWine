<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%producers}}`.
 */
class m241202_194659_add_columns_to_producers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->getDb()->getTableSchema('{{%producers}}');

        if (!isset($tableSchema->columns['address'])) {
            $this->addColumn(
                '{{%producers}}',
                'address',
                $this->string(255)->notNull()->comment('Endereço')
            );
        } else {
            echo "Coluna 'address' já existe na tabela 'producers'. Nenhuma alteração foi feita.\n";
        }

        if (!isset($tableSchema->columns['contact_number'])) {
            $this->addColumn(
                '{{%producers}}',
                'contact_number',
                $this->string(15)->null()->comment('Número de Contato')
            );
        } else {
            echo "Coluna 'contact_number' já existe na tabela 'producers'. Nenhuma alteração foi feita.\n";
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->getDb()->getTableSchema('{{%producers}}');

        if (isset($tableSchema->columns['address'])) {
            $this->dropColumn('{{%producers}}', 'address');
        }

        if (isset($tableSchema->columns['contact_number'])) {
            $this->dropColumn('{{%producers}}', 'contact_number');
        }

    }
}
