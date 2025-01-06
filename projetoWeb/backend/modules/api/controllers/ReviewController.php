<?php

namespace backend\modules\api\controllers;

use common\models\Reviews;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

class ReviewController extends ActiveController
{
    public $modelClass = 'common\models\Reviews';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Autenticação via token para actions protegidas
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => ['product-reviews'], // Nenhum token necessário para esta ação
        ];

        // Controle de Acesso
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'ruleConfig' => [
                'class' => \yii\filters\AccessRule::class,
            ],
            'rules' => [
                // Regra específica para donos do review ou admin
                [
                    'allow' => true,
                    'roles' => ['@'], // Usuário autenticado
                    'actions' => ['update', 'delete'],
                    'matchCallback' => function ($rule, $action) {
                        $reviewId = Yii::$app->request->get('id');
                        $review = Reviews::findOne($reviewId);
                        return $review && ($review->user_id === Yii::$app->user->id || Yii::$app->user->can('admin'));
                    },
                ],
                // Regra para admin acessar 'all'
                [
                    'allow' => true,
                    'roles' => ['admin'], // Apenas admin
                    'actions' => ['all'],
                ],
                // Regra geral para usuários autenticados
                [
                    'allow' => true,
                    'roles' => ['@'], // Apenas usuários autenticados
                    'actions' => ['create'],
                ],
            ],
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
    public function actionProductReviews($productId)
    {
        return Reviews::find()->where(['product_id' => $productId])->all();
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
        $review = Reviews::findOne($id);

        if (!$review) {
            throw new \yii\web\NotFoundHttpException('Review não encontrado.');
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
