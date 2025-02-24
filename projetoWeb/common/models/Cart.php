<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $session_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property CartItems[] $cartItems
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['session_id'], 'string', 'max' => 255],
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
            'session_id' => 'Session ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItems::class, ['cart_id' => 'id']);
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

    public static function findOrCreateCart($userId)
    {
        if ($userId) {
            // Buscar carrinho pelo user_id
            $cart = self::findOne(['user_id' => $userId]);

            if (!$cart) {
                $cart = new self([
                    'user_id' => $userId,
                    'session_id' => null, // Não precisa de session_id para usuários logados
                    'created_at' => date('Y-m-d H:i:s',time()),
                ]);
                $cart->save();
            }
        } else {
            // Buscar carrinho pelo session_id
            $sessionId = Yii::$app->session->id;
            $cart = self::findOne(['session_id' => $sessionId]);
            if (!$cart) {
                $cart = new self([
                    'user_id' => null,
                    'session_id' => $sessionId,
                    'created_at' =>date('Y-m-d H:i:s',time()),
                ]);
                $cart->save();
            }
        }
        return $cart;
    }

    public function addItem($productId, $quantity)
    {
        $product = Product::findOne($productId);
        if (!$product) {
            throw new \yii\web\NotFoundHttpException('Produto não encontrado.');
        }

        // Verificar se o item já existe no carrinho
        $cartItem = CartItems::findOne(['cart_id' => $this->id, 'product_id' => $productId]);

        if ($cartItem) {
            $cartItem->quantity += $quantity; // Atualizar a quantidade
        } else {
            $cartItem = new CartItems([
                'cart_id' => $this->id,
                'product_id' => $productId,
                'quantity' => $quantity, // Adicionar nova quantidade
                'price' => $product->price, // Buscar preço do produto
            ]);
        }

        if (!$cartItem->save()) {
            throw new \yii\web\ServerErrorHttpException('Erro ao adicionar produto ao carrinho.');
        }

        return $cartItem;
    }

    public static function migrateCartForUser($sessionId, $userId)
    {
        $guestCart = self::findOne(['session_id' => $sessionId]);
        if ($guestCart) {
            // Verificar se já existe um carrinho associado ao usuário logado
            $userCart = self::findOne(['user_id' => $userId]);
            if ($userCart) {
                // Migrar os itens do carrinho de guest para o carrinho logado
                foreach ($guestCart->cartItems as $item) {
                    $existingItem = CartItems::findOne([
                        'cart_id' => $userCart->id,
                        'product_id' => $item->product_id,
                    ]);
                    if ($existingItem) {
                        // Atualiza a quantidade do produto
                        $existingItem->quantity += $item->quantity;
                        $existingItem->save();
                    } else {
                        // Move o item para o carrinho do usuário
                        $item->cart_id = $userCart->id;
                        $item->save();
                    }
                }
                // Remove o carrinho de guest
                $guestCart->delete();
            } else {
                // Se não existe um carrinho para o usuário, vincula o carrinho do guest
                $guestCart->user_id = $userId;
                $guestCart->session_id = null; // Remove o vínculo com session_id
                $guestCart->save();
            }
        }
    }




}
