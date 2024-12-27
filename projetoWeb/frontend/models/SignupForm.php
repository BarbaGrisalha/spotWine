<?php

namespace frontend\models;

use common\models\ConsumerDetails;
use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserDetails;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    // Novos campos para user_details
    public $nif;
    public $phone_number;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username', 'email', 'password', 'nif', 'phone_number'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['nif', 'string', 'max' => 20],
            ['phone_number', 'string', 'max' => 15],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generatePasswordResetToken();

        if ($user->save()) {
            $consumerDetails = new ConsumerDetails();
            $consumerDetails->user_id = $user->id;
            $consumerDetails->nif = $this->nif;
            $consumerDetails->phone_number = $this->phone_number;
            $consumerDetails->save();

            // Atribuir um role padrão (Ex.: consumer)
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole('consumer'); // Role padrão
            $auth->assign($role, $user->id);

            return $user;
        }
        return null;
        // return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
