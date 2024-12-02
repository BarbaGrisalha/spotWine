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
        // Adicionando as colunas solicitadas na tabela producers
        $this->addColumn('{{%producers}}', 'address', $this->string(255)->notNull()->comment('Endereço'));
        $this->addColumn('{{%producers}}', 'number', $this->string(10)->comment('Número'));
        $this->addColumn('{{%producers}}', 'complement', $this->string(255)->comment('Complemento'));
        $this->addColumn('{{%producers}}', 'postal_code', $this->string(20)->comment('Código Postal'));
        $this->addColumn('{{%producers}}', 'region', $this->string(100)->comment('Região'));
        $this->addColumn('{{%producers}}', 'city', $this->string(100)->notNull()->comment('Cidade'));
        $this->addColumn('{{%producers}}', 'phone', $this->string(20)->comment('Telefone'));
        $this->addColumn('{{%producers}}', 'mobile', $this->string(20)->comment('Telemóvel'));
        $this->addColumn('{{%producers}}', 'notes', $this->text()->comment('Anotações sobre o produtor'));
        $this->addColumn('{{%producers}}', 'role', $this->string(20)->notNull()->defaultValue('producer')->comment('Role do produtor'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Removendo as colunas em caso de rollback
        $this->dropColumn('{{%producers}}', 'address');
        $this->dropColumn('{{%producers}}', 'number');
        $this->dropColumn('{{%producers}}', 'complement');
        $this->dropColumn('{{%producers}}', 'postal_code');
        $this->dropColumn('{{%producers}}', 'region');
        $this->dropColumn('{{%producers}}', 'city');
        $this->dropColumn('{{%producers}}', 'phone');
        $this->dropColumn('{{%producers}}', 'mobile');
        $this->dropColumn('{{%producers}}', 'notes');
        $this->dropColumn('{{%producers}}', 'role');

    }
}
