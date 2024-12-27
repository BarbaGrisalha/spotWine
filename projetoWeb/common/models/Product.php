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
 * @property Producers $producer
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
            [['description'], 'string'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['image_url'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'category_id']],
            [['producer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producers::class, 'targetAttribute' => ['producer_id' => 'producer_id']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2], // Validação do upload

        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $fileName = uniqid('product_', true) . '.' . $this->imageFile->extension;
            $filePath = 'uploads/products/' . $fileName;
            $this->imageFile->saveAs(\Yii::getAlias('@webroot') . '/' . $filePath);
            $this->image_url = $filePath; // Salva o caminho no campo do banco
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'producer_id' => 'Produtor',
            'category_id' => 'Categoria',
            'name' => 'Nome',
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
        return $this->hasOne(User::class, ['id' => 'user_id'])->via('producer');
    }

    public static function findByProducer($producerId)
    {
        return static::find()->where(['producer_id' => $producerId]);
    }
}