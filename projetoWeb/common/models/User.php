<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [
            TimestampBehavior::class,[
                'class' => \yii\behaviors\TimestampBehavior::class,
                //'createdAt'=>'created_at',
                //'updatedAt'=>'updated_at',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */


 public $password; // Campo temporário para o formulário

    public function rules()
    {
        return [
            [['username', 'email'],'required'], // Inclua password
            [['password'],'required', 'on' =>'create'],
            [['password'],'safe'],
            [['email'], 'email'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['role','safe'],
        ];
    }


//descomentei abaixo para poder alterar a password do produtor
    public function beforeSave($insert)
    {
        /*if (parent::beforeSave($insert)) {
            if (!empty($this->password)) {
                $this->setPassword($this->password); // Gera o hash antes de salvar
                $this->generateAuthKey(); // Gera a chave de autenticação
            }*/
        if (parent::beforeSave($insert)) {
            // Se a senha foi fornecida, criptografá-la
            if (!empty($this->password)) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            } else {
                // Se for uma atualização e a senha estiver vazia, manter a senha atual
                if (!$this->isNewRecord) {
                    unset($this->password); // Evita alterar o valor da senha
                }
            }
            return true;
        }
        return false;
    }


    /**
     * Relacionamento com UserDetails
     */
    public function getUserDetails()
    {
        return $this->hasOne(UserDetails::class, ['user_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Relacionamento com auth_assignment
     */
    public function getAuthAssignment()
    {

        return $this->hasOne(AuthAssignment::class, ['user_id' => 'id']);

        return $this->hasOne(\yii\rbac\Assignment::class, ['user_id' => 'id'])
            ->viaTable('auth_assignment', ['user_id' => 'id']);

    }



    /**
     * Obter o nome do role
     */
    public function getRoleName()
    {
        $auth = Yii::$app->authManager;
        $assignment = $auth->getAssignments($this->id);

        return $assignment ? array_keys($assignment)[0] : 'Sem Role';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }
    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['username', 'email', 'password', 'status'];
        $scenarios['update'] = ['username', 'email', 'status']; // password não é obrigatório no update
        return $scenarios;
    }

    public function getProducer(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Producers::class,['user_id'=> 'id']);
    }

    public function getRole(){
        //return $this->hasOne(Producers::class,['user_id'=> 'id'])->role;

        //return $this->hasOne(User::class, ['user_id' => 'id'])->role;
    }

}
