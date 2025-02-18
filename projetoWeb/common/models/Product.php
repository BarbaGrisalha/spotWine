<?php

namespace common\models;

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
 *
 * @property Categories $category
 * @property ContestParticipations[] $contestParticipations
 * @property OrderItems[] $orderItems
 * @property ProducerDetails $producer
 * @property Promotions[] $promotions
 * @property Reviews[] $reviews
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFile;

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
            [['producer_id'],'required'],
            [['producer_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProducerDetails::class, 'targetAttribute' => ['producer_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'category_id']],
            [['description'], 'string'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['image_url'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 10 * 1024 * 1024, 'tooBig' => 'O arquivo não pode exceder 10 MB.'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {//aqui ficam os atributos da grid, esses nomes está no topo da tabela.

        return [
            'product_id' => 'Product ID',
            'winery_name'=> 'Nome da Vinha',
            'producer_id' => 'Produtor',
            'category_id' => 'Categoria',
            'name' => 'Nome do Vinho',
            'description' => 'Descrição',
            'price' => 'Preço',
            'stock' => 'Stock',
            'image_url' => 'Image Url',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasOne(Categories::class, ['category_id' => 'category_id']);
    }

    public function getContests()
    {
        return $this->hasOne(Contests::class, ['winner_product_id' => 'product_id']);
    }

    /**
     * Gets query for [[ContestParticipations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContestParticipations()
    {
        return $this->hasMany(ContestParticipations::class, ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[Producer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducers()
    {
        return $this->hasOne(ProducerDetails::class, ['id' => 'producer_id']);
    }
    
    /**
     * Gets query for [[Promotions]].
     *s
     * @return \yii\db\ActiveQuery
     */
    public function getPromotions()
    {
        return $this->hasMany(Promotions::class, ['promotion_id' => 'promotion_id'])
            ->viaTable('promotion_product', ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[User]] through [[Producers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->via('producer');//user_id
    }

    public function getFavorites()
    {
        return $this->hasMany(Favorites::class, ['product_id' => 'product_id']);
    }

    public function isFavorited()
    {
       return Favorites::find()->where(['user_id' => Yii::$app->user->identity->id, 'product_id' => $this->product_id])->exists();
    }

    public static function findByProducer($producerId)
    {
        return static::find()->where(['producer_id' => $producerId]);
    }

}