<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property int $id
 * @property int $order_id
 * @property string $invoice_date
 * @property string $status
 * @property float $total_amount
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Orders $order
 */
class Invoices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'invoice_number', 'invoice_date', 'total_amount'], 'required'],
            [['order_id'], 'integer'],
            [['invoice_date', 'created_at', 'updated_at'], 'safe'],
            [['invoice_number'], 'string', 'max' => 255],
            [['invoice_number'], 'unique'],
            [['status'], 'string'],
            [['total_amount'], 'number'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'invoice_number' => 'Número da Fatura',
            'invoice_date' => 'Invoice Date',
            'status' => 'Status',
            'total_amount' => 'Total Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public function getStatusLabel()
    {
        $labels = [
            'pending' => 'Pendente',
            'paid' => 'Paga',
            'cancelled' => 'Cancelada',
        ];

        return $labels[$this->status] ?? $this->status;
    }


    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'invoice_id']);
    }

}
