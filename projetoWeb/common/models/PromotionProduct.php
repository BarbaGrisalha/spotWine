<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promotion_product".
 *
 * @property int $promotion_id
 * @property int $product_id
 *
 * @property Product $product
 * @property Promotions $promotion
 */
class PromotionProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promotion_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promotion_id', 'product_id'], 'required'],
            [['promotion_id', 'product_id'], 'integer'],
            [['promotion_id', 'product_id'], 'unique', 'targetAttribute' => ['promotion_id', 'product_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'product_id']],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promotions::class, 'targetAttribute' => ['promotion_id' => 'promotion_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'promotion_id' => 'Promotion ID',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[Promotion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromotion()
    {
        return $this->hasOne(Promotions::class, ['promotion_id' => 'promotion_id']);
    }
}
