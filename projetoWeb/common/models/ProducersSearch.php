<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "producers_details".
 *
 * @property int $producer_id
 * @property int|null $user_id
 * @property string|null $winery_name
 * @property string|null $location
 * @property string|null $nif
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
 * @property Subscriptions[] $subscriptions
 * @property User $user
 */
class ProducersSearch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producers_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['address', 'city'], 'required'],
            [['notes'], 'string'],
            [['winery_name', 'region', 'city'], 'string', 'max' => 100],
            [['location', 'nif', 'address', 'complement'], 'string', 'max' => 255],
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
            'producer_id' => 'Producer ID',
            'user_id' => 'User ID',
            'winery_name' => 'Winery Name',
            'location' => 'Location',
            'nif' => 'Nif',
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
     * Gets query for [[Subscriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscriptions::class, ['producer_id' => 'producer_id']);
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
}
