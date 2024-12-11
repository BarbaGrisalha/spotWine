<?php

use yii\db\Migration;

/**
 * Class m241029_231118_reset_and_insert_admin_user
 */
class m241029_231118_reset_and_insert_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $adminExists = (new \yii\db\Query())
            ->from('{{%user}}')
            ->where(['username' => 'admin'])
            ->exists();

        if (!$adminExists) {
            $this->insert('{{%user}}', [
                'username' => 'admin',
                'auth_key' => \Yii::$app->security->generateRandomString(),
                'password_hash' => \Yii::$app->security->generatePasswordHash('admin123'),
                'email' => 'admin@example.com',
                'status' => 10,
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        } else {
            echo "Usuário administrador já existe. Nenhuma alteração foi feita.\n";
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove apenas o administrador inserido por esta migração
        $this->delete('{{%user}}', ['username' => 'admin']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241029_231118_reset_and_insert_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
