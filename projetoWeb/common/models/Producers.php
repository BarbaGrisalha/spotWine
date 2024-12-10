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
        return 'producers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['winery_name'], 'string', 'max' => 100],
            [['location', 'document_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'user_id']],
            [['producer_id'], 'required', 'when' => function ($model) {
                return Yii::$app->user->can(' admin');
            }, 'whenClient' => "function (attribute, value){
            return $('#user-role').val() === 'admin';
    }"],
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
            'document_id' => 'Document ID',
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
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
