<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Producers;

/**
 * ProducersSearch represents the model behind the search form of `common\models\Producers`.
 */
class ProducersSearch extends Producers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producer_id', 'user_id'], 'integer'],
            [['winery_name', 'location', 'document_id'], 'safe'],
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
        $query = Producers::find();

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
            'producer_id' => $this->producer_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'winery_name', $this->winery_name])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'document_id', $this->document_id]);

        return $dataProvider;
    }
}
