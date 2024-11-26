<?php

namespace backend\models;


use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "Users".
 *
 * @property int $user_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 * @property string $role
 *
 * @property BlogPosts[] $blogPosts
 * @property Comments[] $comments
 * @property Orders[] $orders
 * @property Producers[] $producers
 * @property Reviews[] $reviews
 */
class Users extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'required'],
            [['role'], 'string'],
            [['name', 'email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}s
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
        ];
    }

    public static function tableName()
    {
        return 'user'; // Certifique-se de usar a tabela correta
    }

    // Relação com a tabela user_detail
    public function getUserDetails()
    {
        return $this->hasOne(UserDetail::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[BlogPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPosts()
    {
        return $this->hasMany(BlogPosts::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Producers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducers()
    {
        return $this->hasMany(Producers::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['user_id' => 'user_id']);
    }
    //TODO - ACREDITO QUE AQUI HÁ UM ERRO POIS O getCodigo() não consgui perceber
    public function getCodigo(){
        return $this->id;
    }

    
}
