<?php

namespace backend\modules\api\controllers;

use common\models\Invoices;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

class InvoiceController extends ActiveController
{
    public $modelClass = 'common\models\Invoice';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Autenticação com QueryParamAuth
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => ['login', 'registo'], // Exclua ações públicas
        ];

        // Controle de Acesso
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'ruleConfig' => [
                'class' => \yii\filters\AccessRule::class,
            ],
            'rules' => [
                // Ações para admin
                [
                    'allow' => true,
                    'actions' => ['all', 'delete', 'update', 'update-status'],
                    'roles' => ['admin'],
                ],
                // Ações para usuários autenticados
                [
                    'allow' => true,
                    'actions' => ['my-invoices', 'view', 'create', 'update-status'],
                    'roles' => ['@'], // Apenas usuários autenticados
                ],
            ],
        ];

        return $behaviors;
    }


    public function actions()
    {
        $actions = parent::actions();

        // Remover ações que serão sobrescritas
        unset($actions['view'], $actions['delete'], $actions['update'], $actions['create'], $actions['index'], $actions['updateStatus']);

        return $actions;
    }

    public function actionCreate()
    {
        $data = Yii::$app->request->post();

        $invoice = new Invoices();

        // Relacionar com uma ordem, se fornecido
        if (isset($data['order_id'])) {
            $invoice->order_id = $data['order_id'];
        } else {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'O campo "order_id" é obrigatório.'];
        }

        // Definir valores automáticos, se não fornecidos
        $invoice->invoice_number = $data['invoice_number'] ?? uniqid('INV-');
        $invoice->invoice_date = $data['invoice_date'] ?? date('Y-m-d');
        $invoice->total_amount = $data['total_amount'] ?? 0;
        $invoice->status = $data['status'] ?? 'pending';

        if ($invoice->save()) {
            return [
                'message' => 'Fatura criada com sucesso.',
                'invoice' => $invoice,
            ];
        }

        Yii::$app->response->statusCode = 422; // Unprocessable Entity
        return $invoice->errors;
    }


    public function actionUpdateStatus($id)
    {
        $invoice = Invoices::findOne($id);

        if (!$invoice) {
            throw new \yii\web\NotFoundHttpException('Fatura não encontrada.');
        }

        $user = Yii::$app->user->identity;

        // Verificar permissão: dono da fatura ou admin
        $isOwner = $invoice->orders->user_id === $user->id;
        $isAdmin = Yii::$app->user->can('admin');

        if (!$isOwner && !$isAdmin) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para atualizar esta fatura.');
        }

        // Obter os dados enviados
        $data = Yii::$app->request->post();
        if (empty($data['status'])) {
            Yii::$app->response->statusCode = 400; // Bad Request
            return ['error' => 'O campo "status" é obrigatório.'];
        }

        // Permitir que o dono altere apenas para "paid"
        if ($isOwner && $data['status'] !== 'paid') {
            Yii::$app->response->statusCode = 403; // Forbidden
            return ['error' => 'Você só pode alterar o status para "paid".'];
        }

        // Atualizar o status
        $invoice->status = $data['status'];

        if ($invoice->save()) {
            // Atualizar o status do pedido para "completed" se a fatura for paga
            if ($data['status'] === 'paid') {
                $order = $invoice->orders;
                $order->status = 'completed';
                $order->save();
            }

            return [
                'message' => 'Status da fatura atualizado com sucesso.',
                'invoice' => $invoice,
            ];
        }

        Yii::$app->response->statusCode = 422; // Unprocessable Entity
        return ['error' => $invoice->errors];
    }



    // Mostrar todas as faturas (Apenas admin)
    public function actionAll()
    {
        if (!Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta ação.');
        }

        return Invoices::find()->all();
    }

    // Mostrar faturas do usuário logado
    public function actionMyInvoices()
    {
        $userId = Yii::$app->user->id;

        // Busca as faturas relacionadas às ordens do usuário autenticado
        $invoices = Invoices::find()
            ->joinWith('orders') // Assume que a relação 'order' está definida no modelo Invoice
            ->where(['orders.user_id' => $userId])
            ->all();

        if (empty($invoices)) {
            return [
                'message' => 'Nenhuma fatura encontrada para o usuário logado.',
            ];
        }

        return $invoices;
    }


    public function actionView($id)
    {
        $invoice = Invoices::find()
            ->joinWith('orders') // Define o alias para acessar a tabela orders
            ->where(['invoices.id' => $id])
            ->one();

        if (!$invoice) {
            throw new \yii\web\NotFoundHttpException('Fatura não encontrada.');
        }

        // Verifica se o usuário é o dono da fatura ou admin
        $userId = $invoice->orders->user_id ?? null; // Pega o user_id através da relação com Order
        if ($userId !== Yii::$app->user->id && !Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta fatura.');
        }

        return $invoice;
    }


    // Atualizar uma fatura (Apenas admin)
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta ação.');
        }

        $invoice = Invoices::findOne($id);

        if (!$invoice) {
            throw new \yii\web\NotFoundHttpException('Fatura não encontrada.');
        }

        $data = Yii::$app->request->post();
        $invoice->load($data, '');

        if ($invoice->save()) {
            return [
                'success' => true,
                'invoice' => $invoice,
            ];
        }

        return [
            'success' => false,
            'errors' => $invoice->errors,
        ];
    }

    // Deletar uma fatura (Apenas admin)
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta ação.');
        }

        $invoice = Invoices::findOne($id);

        if (!$invoice) {
            throw new \yii\web\NotFoundHttpException('Fatura não encontrada.');
        }

        if ($invoice->delete()) {
            return [
                'success' => true,
                'message' => 'Fatura deletada com sucesso.',
            ];
        }

        return [
            'success' => false,
            'message' => 'Erro ao deletar fatura.',
        ];
    }
}
