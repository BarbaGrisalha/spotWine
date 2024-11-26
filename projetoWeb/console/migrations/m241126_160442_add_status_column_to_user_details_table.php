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
        $this->addColumn('{{%user_details}}', 'status', $this->tinyInteger(1)->notNull()->defaultValue(1)->comment('0=Desativado, 1=Ativado'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_details}}', 'status');
    }
}
