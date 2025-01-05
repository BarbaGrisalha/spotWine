<?php

namespace common\models;

/**
 * This is the model class for table "cart_items".
 *
 * @property int $id
 * @property int $cart_id
 * @property int $product_id
 * @property int $quantity
 * @property float $price
 * @property string|null $created_at
 *
 * @property Cart $cart
 */
class CartItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id', 'price'], 'required'],
            [['cart_id', 'product_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['created_at'], 'safe'],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::class, 'targetAttribute' => ['cart_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cart_id' => 'Cart ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Cart]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Cart::class, ['id' => 'cart_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['product_id' => 'product_id']);
    }


    public static function addToCart($productId, $quantity, $userId = null, $sessionId = null)
    {
        $cart = Cart::findOrCreateCart($userId, $sessionId);

        // Verificar se o item já está no carrinho
        $cartItem = self::find()
            ->where(['cart_id' => $cart->id, 'product_id' => $productId])
            ->one();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
        } else {
            $cartItem = new self();
            $cartItem->cart_id = $cart->id;
            $cartItem->product_id = $productId;
            $cartItem->quantity = $quantity;
            $cartItem->price = self::getProductPrice($productId);
            $cartItem->created_at = date('Y-m-d H:i:s');
        }

        return $cartItem->save();
    }

    public static function getProductPrice($productId)
    {
        $product = Product::findOne($productId);
        return $product->price ?? 0.00;
    }
}
