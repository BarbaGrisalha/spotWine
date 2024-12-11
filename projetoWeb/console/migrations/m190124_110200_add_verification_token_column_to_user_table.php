<?php

use \yii\db\Migration;

class m190124_110200_add_verification_token_column_to_user_table extends Migration
{
    public function up()
    {
        if (!$this->getDb()->getTableSchema('{{%user}}')->getColumn('verification_token')) {
            $this->addColumn('{{%user}}', 'verification_token', $this->string()->defaultValue(null));
        } else {
            echo "Coluna 'verification_token' já existe. Nenhuma alteração foi feita.\n";
        }
    }

    public function down()
    {
        if ($this->getDb()->getTableSchema('{{%user}}')->getColumn('verification_token')) {
            $this->dropColumn('{{%user}}', 'verification_token');
        }

    }
}
