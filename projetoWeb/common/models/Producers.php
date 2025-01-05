<?php

namespace common\models;

use backend\models\Users;
use Yii;

/**
 * This is the model class for table "producers".
 *
 * @property int $producer_id
 * @property int|null $user_id
 * @property string|null $winery_name
 * @property string|null $location
 * @property string|null $document_id
 *
 * @property ContestParticipations[] $contestParticipations
 * @property Products[] $products
 * @property Subscriptions[] $subscriptions
 * @property Users $user
 */
class Producers extends \yii\db\ActiveRecord
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
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['winery_name', 'location', 'nif', 'address','number','complement', 'postal_code', 'region', 'city','phone','notes'], 'required'],
            [['winery_name', 'location', 'region', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['notes'], 'string'],
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
            'postal_code' => 'Postal Code',
            'region' => 'Region',
            'city' => 'City',
            'phone' => 'Phone',
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
        return $this->hasMany(ContestParticipations::class, ['producer_id' => 'producer_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['producer_id' => 'producer_id']);
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

    public function getProducersDetails(){
        return $this->hasOne(Producers::class,['producer_id'=>'id']);
    }
}
