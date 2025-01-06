<?php

namespace backend\modules\api\controllers;

use common\models\Orders;
use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;

class OrderController extends ActiveController
{
    public $modelClass = 'common\models\Orders';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Autenticação com QueryParamAuth
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => [],
        ];

        // Controle de acesso
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'ruleConfig' => [
                'class' => \yii\filters\AccessRule::class,
            ],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['admin'], // Apenas admin
                    'actions' => ['all', 'delete', 'update'],
                ],
                [
                    'allow' => true,
                    'roles' => ['@'], // Usuário autenticado
                    'actions' => ['my-orders', 'view'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // Remover ações que serão sobrescritas
        unset($actions['index'], $actions['delete'], $actions['update'], $actions['view']);

        return $actions;
    }

    // Listar todas as ordens (Apenas admin)
    public function actionAll()
    {
        if (!Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta ação.');
        }

        return Orders::find()->all();
    }

    // Listar as ordens do usuário logado
    public function actionMyOrders()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new \yii\web\UnauthorizedHttpException('Usuário não autenticado.');
        }

        $orders = Orders::find()
            ->where(['user_id' => $user->id])
            ->all();

        if (empty($orders)) {
            return [
                'message' => 'Nenhuma ordem encontrada para o usuário logado.',
            ];
        }

        return $orders;
    }


    // Ver uma ordem específica (Admin ou se for do usuário logado)
    public function actionView($id)
    {
        $order = Orders::findOne($id);

        if (!$order) {
            throw new \yii\web\NotFoundHttpException('Ordem não encontrada.');
        }

        // Verificar se o usuário é o dono da ordem ou admin
        if ($order->user_id !== Yii::$app->user->id && !Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta ordem.');
        }

        return $order;
    }

    // Atualizar uma ordem (Apenas admin)
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta ação.');
        }

        $order = Orders::findOne($id);

        if (!$order) {
            throw new \yii\web\NotFoundHttpException('Ordem não encontrada.');
        }

        $data = Yii::$app->request->post();
        $order->load($data, '');

        if ($order->save()) {
            return [
                'success' => true,
                'order' => $order,
            ];
        }

        return [
            'success' => false,
            'errors' => $order->errors,
        ];
    }

    // Deletar uma ordem (Apenas admin)
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta ação.');
        }

        $order = Orders::findOne($id);

        if (!$order) {
            throw new \yii\web\NotFoundHttpException('Ordem não encontrada.');
        }

        if ($order->delete()) {
            return [
                'success' => true,
                'message' => 'Ordem deletada com sucesso.',
            ];
        }

        return [
            'success' => false,
            'message' => 'Erro ao deletar a ordem.',
        ];
    }
}
