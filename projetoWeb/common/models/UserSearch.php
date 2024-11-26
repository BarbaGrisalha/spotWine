<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form of `backend\models\Users`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public $nif; // Atributo relacionado à tabela user_details
    public $phone_number; // Atributo relacionado à tabela user_details

    public function rules()
    {
        return [
            [['id'], 'integer'], // Substitua 'user_id' por 'id', se necessário
            [['username', 'email','nif','phone_number'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // Bypass scenarios() implementation in the parent class
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
        $query = User::find()->joinWith('userDetails'); // Relacione userDetails;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // Filtros na tabela `user`
        $query->andFilterWhere(['id' => $this->id])
        ->andFilterWhere(['like', 'username', $this->username])
        ->andFilterWhere(['like', 'email', $this->email]);

        // Filtros na tabela `user_details`
        $query->andFilterWhere(['like', 'user_details.nif', $this->nif])
        ->andFilterWhere(['like', 'user_details.phone_number', $this->phone_number]);


        return $dataProvider;
    }
}
