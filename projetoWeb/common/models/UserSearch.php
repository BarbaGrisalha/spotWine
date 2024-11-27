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
    public $status;

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'], // Substitua 'user_id' por 'id', se necessário
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
        $query = User::find()->joinWith('userDetails');

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

        //Filtros de buscas
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'user_details.nif', $this->nif])
            ->andFilterWhere(['like', 'user_details.phone_number', $this->phone_number])
            ->andFilterWhere(['user_details.status' => $this->status]);

        return $dataProvider;
    }

}
