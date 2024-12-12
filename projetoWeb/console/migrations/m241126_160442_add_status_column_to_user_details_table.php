<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_details}}`.
 */
class m241126_160442_add_status_column_to_user_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->getDb()->getTableSchema('{{%user_details}}');
        if (!isset($tableSchema->columns['status'])) {
            $this->addColumn(
                '{{%user_details}}',
                'status',
                $this->tinyInteger(1)->notNull()->defaultValue(1)->comment('0=Desativado, 1=Ativado')
            );
        } else {
            echo "Coluna 'status' já existe na tabela 'user_details'. Nenhuma alteração foi feita.\n";
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->getDb()->getTableSchema('{{%user_details}}');
        if (isset($tableSchema->columns['status'])) {
            $this->dropColumn('{{%user_details}}', 'status');
        }
    }
}
