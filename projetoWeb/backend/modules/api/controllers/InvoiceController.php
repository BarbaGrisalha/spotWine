<?php

namespace backend\modules\api\controllers;

use common\models\Invoices;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

class InvoiceController extends ActiveController
{
    public $modelClass = 'common\models\Invoices';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Autenticação
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
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
                    'actions' => ['my-invoices', 'view', 'update-status'],
                    'roles' => ['@'], // Apenas usuários autenticados
                ],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['update']);
        return $actions;
    }

    // Mostrar faturas do usuário autenticado
    public function actionMyInvoices()
    {
        $userId = Yii::$app->user->id;

        // Busca as faturas com os itens do pedido e produtos em uma única consulta
        $invoices = Invoices::find()
            ->joinWith([
                'orders',
                'orders.orderItems',
                'orders.orderItems.product' // Relacionamento com a tabela `products`
            ])
            ->where(['orders.user_id' => $userId])
            ->all();

        if (empty($invoices)) {
            return ['message' => 'Nenhuma fatura encontrada.'];
        }

        // Monta a resposta
        $invoicesWithProducts = [];
        foreach ($invoices as $invoice) {
            $products = [];
            foreach ($invoice->orders->orderItems as $item) {
                $products[] = [
                    'product_id' => $item->product->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->quantity * $item->unit_price,
                ];
            }

            $invoicesWithProducts[] = [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'invoice_date' => $invoice->invoice_date,
                'total_amount' => $invoice->total_amount,
                'status' => $invoice->status,
                'products' => $products,
            ];
        }

        return $invoicesWithProducts;
    }

    // Ver uma fatura específica (somente se for do usuário autenticado)
    public function actionView($id)
    {
        $invoice = Invoices::find()
            ->joinWith('orders')
            ->where(['invoices.id' => $id])
            ->one();

        if (!$invoice || $invoice->orders->user_id !== Yii::$app->user->id) {
            throw new \yii\web\NotFoundHttpException('Fatura não encontrada.');
        }

        return $invoice;
    }

    // Atualizar status da fatura (Somente se for do usuário e apenas para "paid")
    public function actionUpdateStatus($id)
    {
        $invoice = Invoices::findOne($id);
        if (!$invoice) {
            throw new \yii\web\NotFoundHttpException('Fatura não encontrada.');
        }

        if ($invoice->orders->user_id !== Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão.');
        }

        $data = Yii::$app->request->post();
        if (empty($data['status']) || $data['status'] !== 'paid') {
            return ['error' => 'Só é permitido alterar para "paid".'];
        }

        $invoice->status = 'paid';
        if ($invoice->save()) {
            $order = $invoice->orders;
            $order->status = 'completed';
            $order->save();

            return ['message' => 'Pagamento realizado com sucesso.', 'invoice' => $invoice];
        }

        return ['error' => 'Erro ao atualizar fatura.'];
    }
}
