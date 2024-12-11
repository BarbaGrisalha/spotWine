<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "promotions".
 *
 * @property int $promotion_id
 * @property string $name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string $discount_type
 * @property float $discount_value
 * @property string $condition_type
 * @property float|null $condition_value
 *
 * @property PromotionProduct[] $promotionProducts
 * @property Product[] $products
 * @property Producers $producer
 */
class Promotions extends \yii\db\ActiveRecord
{
    private $_productsIds = []; // Propriedade privada para armazenar IDs dos produtos

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promotions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discount_value', 'condition_value'], 'number'],
            [['name', 'start_date', 'end_date'], 'safe'],
            [['discount_type', 'condition_type'], 'string'],
            [['discount_value'], 'required'],
            [['productsIds'], 'each', 'rule' => ['integer']], // Validação para IDs de produtos
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'promotion_id' => 'Promotion ID',
            'name' => 'Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'discount_type' => 'Discount Type',
            'discount_value' => 'Discount Value',
            'condition_type' => 'Condition Type',
            'condition_value' => 'Condition Value',
            'productsIds' => 'Products', // Nome amigável para o formulário
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['product_id' => 'product_id'])
            ->viaTable('promotion_product', ['promotion_id' => 'promotion_id']);
    }

    /**
     * Gets query for [[PromotionProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromotionProducts()
    {
        return $this->hasMany(PromotionProduct::class, ['promotion_id' => 'promotion_id']);
    }

    /**
     * Gets query for [[Producer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducer()
    {
        return $this->hasOne(Producers::class, ['producer_id' => 'producer_id']);
    }

    /**
     * Retorna os IDs dos produtos associados à promoção.
     * Usado como propriedade virtual.
     *
     * @return array
     */
    public function getProductsIds()
    {
        if (empty($this->_productsIds)) {
            $this->_productsIds = ArrayHelper::getColumn(
                $this->getProducts()->asArray()->all(),
                'product_id'
            );
        }
        return $this->_productsIds;
    }

    /**
     * Define os IDs dos produtos associados à promoção.
     * Usado como propriedade virtual.
     *
     * @param array $ids
     */
    public function setProductsIds($ids)
    {
        $this->_productsIds = $ids;
    }

    /**
     * Atualiza os IDs dos produtos na tabela intermediária após salvar.
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Atualizar tabela intermediária
        $currentProducts = ArrayHelper::getColumn(
            PromotionProduct::find()
                ->where(['promotion_id' => $this->promotion_id])
                ->asArray()
                ->all(),
            'product_id'
        );

        $productsToAdd = array_diff($this->_productsIds, $currentProducts);
        $productsToRemove = array_diff($currentProducts, $this->_productsIds);

        // Adicionar produtos
        foreach ($productsToAdd as $productId) {
            $promotionProduct = new PromotionProduct();
            $promotionProduct->promotion_id = $this->promotion_id;
            $promotionProduct->product_id = $productId;
            $promotionProduct->save();
        }

        // Remover produtos
        if (!empty($productsToRemove)) {
            PromotionProduct::deleteAll([
                'promotion_id' => $this->promotion_id,
                'product_id' => $productsToRemove,
            ]);
        }
    }
}
