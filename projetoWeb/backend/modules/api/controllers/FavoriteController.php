<?php

namespace backend\modules\api\controllers;

use common\models\Favorites;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class FavoriteController extends ActiveController
{
    public $modelClass = 'common\models\Favorites';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => [], // Exclua ações públicas, como login
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }


    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return ['error' => 'Usuário não autenticado'];
        }

        // Retorna apenas os IDs dos produtos favoritos do usuário
        $favoriteProductIds = Favorites::find()
            ->select('product_id')
            ->where(['user_id' => $user->id])
            ->column();

        return ['favorite_ids' => $favoriteProductIds];
    }

    // Adiciona um produto aos favoritos
    public function actionAdd($id)
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return ['error' => 'Usuário não autenticado'];
        }

        // Verifica se já está nos favoritos
        if (Favorites::findOne(['user_id' => $user->id, 'product_id' => $id])) {
            return ['message' => 'Produto já está nos favoritos'];
        }

        // Adiciona o favorito
        $favorite = new Favorites();
        $favorite->user_id = $user->id;
        $favorite->product_id = $id;
        $favorite->created_at = date('Y-m-d H:i:s');

        if ($favorite->save()) {
            return ['message' => 'Produto adicionado aos favoritos'];
        }

        return ['error' => 'Erro ao adicionar aos favoritos'];
    }

    // Remove um produto dos favoritos
    public function actionRemove($id)
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return ['error' => 'Usuário não autenticado'];
        }

        $favorite = Favorites::findOne(['user_id' => $user->id, 'product_id' => $id]);

        if (!$favorite) {
            return ['message' => 'Produto não está nos favoritos'];
        }

        if ($favorite->delete()) {
            return ['message' => 'Produto removido dos favoritos'];
        }

        return ['error' => 'Erro ao remover dos favoritos'];
    }

}