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
        //Deletei os utilizadores que lá estão.
        $this->delete('{{%user}}');

        // Gerar valores necessários
        $password = '#378959@Az';
        $passwordHash = Yii::$app->security->generatePasswordHash($password);
        $authKey = Yii::$app->security->generateRandomString();
        $currentTime = time();

        // Inserir o novo administrador
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => $authKey,
            'password_hash' => $passwordHash,
            'password_reset_token' => null,
            'email' => 'box.altamir@gmail.com',  // Atualize o email se necessário
            'status' => 10,
            'created_at' => $currentTime,
            'updated_at' => $currentTime,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove o usuário administrador inserido
        $this->delete('{{%user}}', ['id' => 1]);
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
