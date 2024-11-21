<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_details".
 *
 * @property int $id
 * @property int $user_id
 * @property string $nif
 * @property string|null $phone_number
 *
 * @property User $user
 */
class UserDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'nif'], 'required'],
            [['user_id'], 'integer'],
            [['nif'], 'string', 'max' => 20],
            [['phone_number'], 'string', 'max' => 15],
            [['user_id'], 'unique'],
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
            'nif' => 'Nif',
            'phone_number' => 'Phone Number',
        ];
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
}
