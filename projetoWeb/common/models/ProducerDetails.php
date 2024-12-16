<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "producer_details".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $nif
 * @property int $status 0=Desativado, 1=Ativado
 * @property string|null $winery_name
 * @property string|null $location
 * @property string|null $document_id
 * @property string $address Endereço
 * @property string|null $number Número
 * @property string|null $complement Complemento
 * @property string|null $postal_code Código Postal
 * @property string|null $region Região
 * @property string $city Cidade
 * @property string|null $phone Telefone
 * @property string|null $mobile Telemóvel
 * @property string|null $notes Anotações sobre o produtor
 *
 * @property ContestParticipations[] $contestParticipations
 * @property Products[] $products
 * @property Promotions[] $promotions
 * @property Subscriptions[] $subscriptions
 * @property User $user
 */
class ProducerDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producer_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['nif', 'address', 'city'], 'required'],
            [['notes'], 'string'],
            [['nif'], 'string', 'max' => 15],
            [['winery_name', 'region', 'city'], 'string', 'max' => 100],
            [['location', 'document_id', 'address', 'complement'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 10],
            [['postal_code', 'phone', 'mobile'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'nif' => 'Nif',
            'status' => 'Status',
            'winery_name' => 'Winery Name',
            'location' => 'Location',
            'document_id' => 'Document ID',
            'address' => 'Address',
            'number' => 'Number',
            'complement' => 'Complement',
            'postal_code' => 'Postal Code',
            'region' => 'Region',
            'city' => 'City',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'notes' => 'Notes',
        ];
    }

    /**
     * Gets query for [[ContestParticipations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContestParticipations()
    {
        return $this->hasMany(ContestParticipations::class, ['producer_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['producer_id' => 'id']);
    }

    /**
     * Gets query for [[Promotions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromotions()
    {
        return $this->hasMany(Promotions::class, ['producer_id' => 'id']);
    }

    /**
     * Gets query for [[Subscriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscriptions::class, ['producer_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function createProducer(User $user)
    {
        // Define atributos obrigatórios do usuário
        $user->setPassword($user->password); // Hash da senha
        $user->generatePasswordResetToken();
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if ($user->save()) {
            // Associa o usuário ao produtor
            $this->user_id = $user->id;

            // Define o status padrão como ativo
            if ($this->save()) {
                // Atribui o role 'producer' ao usuário
                $auth = Yii::$app->authManager;
                $producerRole = $auth->getRole('producer');
                $auth->assign($producerRole, $user->id);

                return true;
            }
        }

        return false;
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->status = 1; // Define como Ativo ao criar
        }
        return parent::beforeValidate();
    }

}
