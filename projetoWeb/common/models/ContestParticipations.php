<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contest_participations".
 *
 * @property int $id
 * @property int|null $contest_id
 * @property int|null $producer_id
 * @property int|null $product_id
 * @property int|null $vote_count
 *
 * @property Contests $contest
 * @property ProducerDetails $producer
 * @property Products $product
 */
class ContestParticipations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contest_participations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contest_id', 'producer_id', 'product_id', 'vote_count'], 'integer'],
            [['contest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contests::class, 'targetAttribute' => ['contest_id' => 'id']],
            [['producer_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProducerDetails::class, 'targetAttribute' => ['producer_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'product_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contest_id' => 'Contest ID',
            'producer_id' => 'Producer ID',
            'product_id' => 'Product ID',
            'vote_count' => 'Vote Count',
        ];
    }

    /**
     * Gets query for [[Contest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContest()
    {
        return $this->hasOne(Contests::class, ['id' => 'contest_id']);
    }

    /**
     * Gets query for [[Producer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducer()
    {
        return $this->hasOne(ProducerDetails::class, ['id' => 'producer_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['product_id' => 'product_id']);
    }
}
