<?php

namespace backend\models;

//use common\models\Producers;
use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $product_id
 * @property int|null $producer_id
 * @property int|null $category_id
 * @property string|null $name
 * @property string|null $description
 * @property float|null $price
 * @property int|null $stock
 * @property string|null $image_url
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producer_id', 'category_id', 'stock'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['image_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'producer_id' => 'Producer ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'stock' => 'Stock',
            'image_url' => 'Image Url',
        ];
    }
    public function getProducer(){
        return $this->hasOne(Products::class,['id'=>'producer_id']);
    }
}
