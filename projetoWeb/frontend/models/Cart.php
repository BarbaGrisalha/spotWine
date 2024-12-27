<?php

namespace frontend\models;

use common\models\User;
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

    public static function findOrCreateCart($userId = null)
    {
        if ($userId) {
            // Buscar carrinho pelo user_id
            $cart = self::findOne(['user_id' => $userId]);
            if (!$cart) {
                $cart = new self([
                    'user_id' => $userId,
                    'session_id' => null, // Não precisa de session_id para usuários logados
                    'created_at' => time(),
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
                    'created_at' => time(),
                ]);
                $cart->save();
            }
        }
        return $cart;
    }



}
