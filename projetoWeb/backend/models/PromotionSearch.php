<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Promotions;

/**
 * PromotionSearch represents the model behind the search form of `common\models\Promotions`.
 */
class PromotionSearch extends Promotions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promotion_id'], 'integer'],
            [['discount_value', 'condition_value'], 'number'],
            [['name','start_date', 'end_date', 'discount_type', 'condition_type'], 'safe'],
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
        $query = Promotions::find();

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
            'promotion_id' => $this->promotion_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'discount_value' => $this->discount_value,
            'condition_value' => $this->condition_value,
        ]);

        $query->andFilterWhere(['like', 'discount_type', $this->discount_type])
            ->andFilterWhere(['like', 'condition_type', $this->condition_type])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['>=', 'start_date', $this->start_date])
            ->andFilterWhere(['<=', 'end_date', $this->end_date]);



        return $dataProvider;
    }
}
