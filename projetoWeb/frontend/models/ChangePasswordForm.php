<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class ChangePasswordForm extends Model
{
    public $atualPassword;
    public $novaPassword;
    public $confirmarPassword;

    public function rules()
    {
        return [
            [['atualPassword', 'novaPassword', 'confirmarPassword'], 'required'],
            ['atualPassword', 'validateCurrentPassword'],
            ['confirmarPassword', 'compare', 'compareAttribute' => 'novaPassword', 'message' => 'As senhas não coincidem.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'atualPassword' => 'Password Atual',
            'novaPassword' => 'Nova Password',
            'confirmarPassword' => 'Confirmar Nova Password',
        ];
    }

    public function validateCurrentPassword($attribute, $params)
    {
        $user = User::findOne(Yii::$app->user->id);

        if (!$user || !$user->validatePassword($this->atualPassword)) {
            $this->addError($attribute, 'A password atual está incorreta.');
        }
    }

    public function changePassword()
    {
        if ($this->validate()) {
            $user = User::findOne(Yii::$app->user->id);
            $user->setPassword($this->novaPassword);
            return $user->save();
        }
        return false;
    }
}