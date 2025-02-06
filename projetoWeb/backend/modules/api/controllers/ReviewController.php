<?php

namespace backend\modules\api\controllers;

use common\models\Reviews;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use function PHPUnit\Framework\throwException;

class ReviewController extends ActiveController
{
    public $modelClass = 'common\models\Reviews';


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Configura o QueryParamAuth para autenticar usando o token
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => ['all', 'product-reviews'], // Exclui essas actions da necessidade de autenticação
        ];

        return $behaviors;
    }
    public function actions()
    {
        $actions = parent::actions();

        // Remover ações que serão sobrescritas
        unset($actions['view'], $actions['delete'], $actions['create'], $actions['update']);

        return $actions;
    }

    // Mostrar todas as reviews (somente admin)
    public function actionAll()
    {
        return Reviews::find()->all();
    }

    // Mostrar todas as reviews de um determinado produto
    public function actionProductReviews($id)
    {
        return Reviews::find()->where(['product_id' => $id])->all();
    }

    // Criar um review e associar a um produto
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        $data = Yii::$app->request->post();

        $review = new Reviews();
        $review->product_id = $data['product_id'] ?? null;
        $review->user_id = $user->id;
        $review->rating = $data['rating'] ?? null;
        $review->comment = $data['comment'] ?? null;

        if ($review->save()) {
            return [
                'message' => 'Review criado com sucesso.',
                'review' => $review,
            ];
        }

        Yii::$app->response->statusCode = 422; // Unprocessable Entity
        return $review->errors;
    }

    // Atualizar um review (somente dono ou admin)
    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;

        if(!$user){
            throw new \yii\web\UnauthorizedHttpException('Usuário não autenticado.');
        }
        $review = Reviews::findOne(['id' => $id, 'user_id' => $user->id]);

        if (!$review) {
            throw new \yii\web\NotFoundHttpException('Review não encontrado ou usuário proibido.');
        }

        $data = Yii::$app->request->post();
        $review->rating = $data['rating'] ?? $review->rating;
        $review->comment = $data['comment'] ?? $review->comment;

        if ($review->save()) {
            return [
                'message' => 'Review atualizado com sucesso.',
                'review' => $review,
            ];
        }

        Yii::$app->response->statusCode = 422; // Unprocessable Entity
        return $review->errors;
    }

    // Deletar um review (somente dono ou admin)
    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;

        if(!$user){
            throw new \yii\web\UnauthorizedHttpException('Usuário não autenticado.');
        }

        $review = Reviews::findOne($id);

        if (!$review) {
            throw new \yii\web\NotFoundHttpException('Review não encontrado.');
        }

        if ($review->delete()) {
            return ['message' => 'Review deletado com sucesso.'];
        }

        Yii::$app->response->statusCode = 500;
        return ['error' => 'Erro ao deletar review.'];
    }
}
