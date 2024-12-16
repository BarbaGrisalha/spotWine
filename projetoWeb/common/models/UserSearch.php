<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

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
    public $status;
    public $role;

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'], // Substitua 'user_id' por 'id', se necessário
            [['username', 'email','nif','phone_number','role'], 'safe'],
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
        $query = User::find()
            ->joinWith([
                'consumerDetails', // Relacionamento com consumer_details
                'producerDetails', // Relacionamento com producer_details
                'authAssignment' => function ($query) {
                    $query->alias('auth_assignment'); // Alias para a tabela auth_assignment
                }
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5, // Define o tamanho da página
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'consumer_details.nif', $this->nif])
            ->andFilterWhere(['like', 'producer_details.nif', $this->nif])
            ->andFilterWhere(['like', 'consumer_details.phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'producer_details.phone_number', $this->phone_number])
            ->andFilterWhere(['consumer_details.status' => $this->status])
            ->orFilterWhere(['producer_details.status' => $this->status]);

        // Filtro de Role (auth_assignment)
        if (!empty($this->role)) {
            $query->andFilterWhere(['auth_assignment.item_name' => $this->role]);
        }

        return $dataProvider;
    }
}
