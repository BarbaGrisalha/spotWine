<?php

namespace frontend\models;

use common\models\OrderItems;
use common\models\Promotions;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductFrontSearch represents the model behind the search form of `common\models\Product`.
 */

class ProductFrontSearch extends Product
{
    public $price_min;
    public $price_max;
    public $filter;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'producer_id', 'category_id', 'stock'], 'integer'],
            [['name', 'description', 'image_url', 'category_id', 'filter'], 'safe'],
            [['price', 'price_min', 'price_max'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $producerId = null)
    {
        $query = Product::find();

        if ($producerId !== null) {
            $query->andWhere(['producer_id' => $producerId]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'products.product_id' => $this->product_id,
            'products.producer_id' => $this->producer_id,
            'products.category_id' => $this->category_id,
            'price' => $this->price,
            'stock' => $this->stock,
        ]);
        // Se o filtro for 'maisVendido', use os IDs dos produtos mais vendidos
        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image_url', $this->image_url]);

        if ($this->filter === 'mais_vendidos') {
            $maisVendidosIds = OrderItems::getProdutosMaisVendidosIds();
            $query->andWhere(['product_id' => $maisVendidosIds]);
        }

        if ($this->filter === 'promocoes') {
            $produtoIdsEmPromocao = Promotions::getProdutosEmPromocaoIds();
            $query->andWhere(['product_id' => $produtoIdsEmPromocao]);
        }

        // Condições de Filtro
        if (!empty($this->name)) {
            $query->andFilterWhere(['like', 'products.name', $this->name]);
        }

        if (!empty($this->category_id)) {
            $query->andFilterWhere(['products.category_id' => $this->category_id]);
        }

        if (!empty($this->price_min)) {
            $query->andWhere(['>=', 'products.price', $this->price_min]);
        }

        if (!empty($this->price_max)) {
            $query->andWhere(['<=', 'products.price', $this->price_max]);
        }

        return $dataProvider;
    }
}
