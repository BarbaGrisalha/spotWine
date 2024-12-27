<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProducerDetails;

/**
 * ProducerSearch represents the model behind the search form of `common\models\ProducerDetails`.
 */
class ProducerSearch extends ProducerDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status'], 'integer'],
            [['nif', 'winery_name', 'location', 'document_id', 'address', 'number', 'complement', 'postal_code', 'region', 'city', 'phone', 'mobile', 'notes'], 'safe'],
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
        $query = ProducerDetails::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'nif', $this->nif])
            ->andFilterWhere(['like', 'winery_name', $this->winery_name])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'document_id', $this->document_id])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'complement', $this->complement])
            ->andFilterWhere(['like', 'postal_code', $this->postal_code])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
