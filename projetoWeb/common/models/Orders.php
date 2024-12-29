<?php

namespace common\models;

use backend\models\Users;
use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $order_id
 * @property int|null $user_id
 * @property string|null $order_date
 * @property string|null $status
 * @property float|null $total_price
 *
 * @property OrderItems[] $orderItems
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['order_date'], 'safe'],
            [['total_price'], 'number'],
            [['status'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => user::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Order ID',
            'user_id' => 'User ID',
            'order_date' => 'Order Date',
            'status' => 'Status',
            'total_price' => 'Total Price',
        ];
    }

    public static function getStatusMap()
    {
        return [
            'Pending' => 'Pendente',
            'Completed' => 'Concluído',
            'Cancelled' => 'Cancelado',
            'Shipped' => 'Enviado',
        ];
    }

    public function getStatusLabel()
    {
        $map = self::getStatusMap();
        return $map[$this->status] ?? $this->status;
    }


    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']); // Tabela correta
    }

    public function getInvoice()
    {
        return $this->hasOne(Invoices::class, ['order_id' => 'id']);
    }

}
