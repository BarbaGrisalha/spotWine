<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'producer_id', 'category_id', 'stock'], 'integer'],

            [['name', 'description', 'image_url'], 'safe'],
            [['price'], 'number'],
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
    public function search($params)
    {
        //Aqui eu busco a identidade do utilizador logado
        $loggedInProducerId = Yii::$app->user->id;
        $query = Product::find()->joinWith(['producers', 'categories']);

        //Aqui eu garanto que os produtos filtrados sejam do produtor logado
        $query->andWhere(['producers_details.producer_id'=>$loggedInProducerId]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([

            'product_id' => $this->product_id,
            'products.producer_id' => $this->producer_id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'stock' => $this->stock,
        ]);

        $query->andFilterWhere(['like', 'products.name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image_url', $this->image_url]);

        return $dataProvider;
    }
}
