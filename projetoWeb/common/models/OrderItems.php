<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property int $order_item_id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property int|null $quantity
 * @property float|null $unit_price
 *
 * @property Orders $order
 * @property Product $product
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['unit_price'], 'number'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'order_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'product_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_item_id' => 'Order Item ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['order_id' => 'order_id']);
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

    // Método para buscar os produtos mais vendidos
    public static function getProdutosMaisVendidos($limit = null)
    {
        return self::find()
            ->select(['product_id', 'unit_price', 'SUM(quantity) as total_vendidos'])
            ->groupBy(['product_id', 'unit_price'])
            ->orderBy(['total_vendidos' => SORT_DESC])
            ->with(['product.producers']) // Carrega as relações necessárias
            ->limit($limit)
            ->all(); // Retorna os objetos completos
    }


    public static function getProdutosMaisVendidosIds($limit = null)
    {
        return self::find()
            ->select(['product_id'])
            ->groupBy(['product_id'])
            ->orderBy(['SUM(quantity)' => SORT_DESC])
            ->limit($limit)
            ->column(); // Retorna apenas os IDs
    }



}
