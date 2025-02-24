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
            [['name', 'start_date', 'end_date', 'discount_type', 'promotion_type', 'discount_value'], 'required'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
            [['discount_value', 'condition_value'], 'number', 'min' => 0],
            [['producer_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['promotion_type'], 'in', 'range' => ['direct', 'conditional']],
            [['discount_type'], 'in', 'range' => ['percent', 'fixed']],
            [['condition_type'], 'in', 'range' => ['min_purchase', 'quantity', 'none']],
            [['end_date'], 'compare', 'compareAttribute' => 'start_date', 'operator' => '>'],
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
            'name' => 'Nome da Promoção',
            'start_date' => 'Data de Início',
            'end_date' => 'Data de Término',
            'discount_type' => 'Tipo de Desconto',
            'discount_value' => 'Valor do Desconto',
            'promotion_type' => 'Tipo de Promoção',
            'condition_type' => 'Tipo de Condição',
            'condition_value' => 'Valor da Condição',
            'producer_id' => 'Produtor',
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
    public function getProducers()
    {
        return $this->hasOne(ProducerDetails::class, ['id' => 'producer_id']);
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

    public static function getProdutosEmPromocao($limit = null)
    {
        return Product::find()
            ->joinWith('promotions') // Certifique-se de que a relação com promotions existe no modelo Product
            ->where(['<=', 'promotions.start_date', date('Y-m-d')])
            ->andWhere(['>=', 'promotions.end_date', date('Y-m-d')])
            ->with(['producers', 'categories']) // Relacionamentos que você deseja carregar
            ->limit($limit)
            ->all();
    }


    public static function getProdutosEmPromocaoIds($limit = null)
    {
        return self::find()
            ->joinWith('products')
            ->where(['<=', 'start_date', date('Y-m-d')])
            ->andWhere(['>=', 'end_date', date('Y-m-d')])
            ->select('promotion_product.product_id')
            ->column(); // Retorna apenas os IDs dos produtos
    }

    public function linkProducts($productIds)
    {
        // Verifica se há produtos para associar
        if (empty($productIds)) {
            return;
        }

        // Usa transação para garantir integridade
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            // Exclui associações anteriores
            \Yii::$app->db->createCommand()
                ->delete('{{%promotion_product}}', ['promotion_id' => $this->promotion_id])
                ->execute();

            // Adiciona novos produtos
            foreach ($productIds as $productId) {
                \Yii::$app->db->createCommand()
                    ->insert('{{%promotion_product}}', [
                        'promotion_id' => $this->promotion_id,
                        'product_id' => $productId,
                    ])
                    ->execute();
            }

            // Confirma a transação
            $transaction->commit();
        } catch (\Throwable $e) {
            // Reverte a transação em caso de erro
            $transaction->rollBack();
            throw $e; // Relança a exceção para tratamento posterior
        }
    }

    public function savePromotion()
    {
        // 1️⃣ Validação para promoções diretas: deve ter pelo menos um produto selecionado
        if ($this->promotion_type === 'direct') {
            if (empty($this->productsIds)) {
                $this->addError('productsIds', 'Selecione ao menos um produto para a promoção direta.');
                return false;
            }

            // Define condition_type e condition_value como NULL para evitar erros no banco
            $this->condition_type = null;
            $this->condition_value = null;
        }

        // 2️⃣ Validação para promoções condicionais: deve ter tipo e valor da condição
        if ($this->promotion_type === 'conditional') {
            if (empty($this->condition_type) || empty($this->condition_value)) {
                $this->addError('condition_type', 'Tipo e valor da condição são obrigatórios para promoções condicionais.');
                return false;
            }
        }

        // 3️⃣ Tenta salvar o modelo
        if ($this->save()) {
            // 4️⃣ Se for promoção direta, associa os produtos selecionados
            if ($this->promotion_type === 'direct') {
                $this->linkProducts($this->productsIds);
            }
            return true;
        }

        return false;
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

