<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\Orders;
use common\models\OrderItems;
use common\models\Invoices;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\QueryParamAuth;

class CheckoutController extends ActiveController
{
    public $modelClass = 'common\models\Orders';
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // Remover ações que serão sobrescritas
        unset($actions['create'], $actions['delete'], $actions['update']);

        return $actions;
    }

    // Action para criar ordem e fatura
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        // Obter os parâmetros enviados no corpo da requisição
        $body = Yii::$app->request->post();

        // Criar a ordem
        $order = new Orders();
        $order->user_id = $user->id;
        $order->status = 'pending'; // status inicial
        $order->total_price = 0; // Será calculado
        if (!$order->save()) {
            Yii::$app->response->statusCode = 422; // Unprocessable Entity
            return ['error' => $order->errors];
        }

        // Adicionar itens à ordem
        $totalPrice = 0;
        foreach ($body['items'] as $itemData) {
            $productId = $itemData['product_id'] ?? null;
            $quantity = $itemData['quantity'] ?? 1;

            if (!$productId || $quantity <= 0) {
                Yii::$app->response->statusCode = 400; // Bad Request
                return ['error' => 'Produto inválido ou quantidade inválida.'];
            }

            // Criar o item da ordem
            $orderItem = new OrderItems();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $productId;
            $orderItem->quantity = $quantity;

            // Obter o preço do produto
            $product = \common\models\Product::findOne($productId);
            if (!$product) {
                Yii::$app->response->statusCode = 404; // Not Found
                return ['error' => 'Produto não encontrado.'];
            }

            $orderItem->unit_price = $product->price;
            $totalPrice += $product->price * $quantity;

            if (!$orderItem->save()) {
                Yii::$app->response->statusCode = 422; // Unprocessable Entity
                return ['error' => $orderItem->errors];
            }
        }

        // Atualizar o total da ordem
        $invoice = new Invoices();
        $invoice->order_id = $order->id;
        $invoice->total_amount = $totalPrice;
        $invoice->status = 'pending'; // status inicial
        $invoice->invoice_number = uniqid('INV-');
        $invoice->invoice_date = date('Y-m-d'); // Data atual (ou use a data apropriada)

        if (!$invoice->save()) {
            Yii::$app->response->statusCode = 422; // Unprocessable Entity
            return ['error' => $invoice->errors];
        }


        // Resposta final
        return [
            'message' => 'Checkout concluído com sucesso.',
            'order' => $order,
            'invoice' => $invoice,
        ];
    }

    // Action para efetuar o pagamento da fatura
    public function actionCheckout($invoiceId)
    {
        $user = Yii::$app->user->identity;

        // Busca a fatura
        $invoice = Invoices::findOne($invoiceId);
        if (!$invoice) {
            throw new \yii\web\NotFoundHttpException('Fatura não encontrada.');
        }

        // Verificar se o usuário tem permissão para pagar esta fatura
        $order = $invoice->order; // Obtém a ordem associada à fatura
        if ($order->user_id !== $user->id) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para pagar esta fatura.');
        }

        // Atualizar status para "paid"
        $invoice->status = 'paid';
        if ($invoice->save()) {
            // Atualiza a ordem associada
            $order->status = 'completed';
            $order->save();

            return [
                'message' => 'Pagamento realizado com sucesso.',
                'invoice' => $invoice,
                'order' => $order,
            ];
        }

        Yii::$app->response->statusCode = 422;
        return ['error' => 'Erro ao processar o pagamento.'];
    }


    // Action para confirmar e retornar o resumo da ordem e fatura
    public function actionConfirmation($orderId)
    {
        $user = Yii::$app->user->identity;

        $order = Orders::findOne($orderId);
        if (!$order) {
            throw new \yii\web\NotFoundHttpException('Ordem não encontrada.');
        }

        // Verificar se o usuário tem permissão para acessar esta ordem
        if ($order->user_id !== $user->id) {
            throw new ForbiddenHttpException('Você não tem permissão para acessar esta ordem.');
        }

        $invoice = Invoices::findOne(['order_id' => $order->id]);

        return [
            'order' => $order,
            'invoice' => $invoice,
            'items' => $order->orderItems,
        ];
    }
}
