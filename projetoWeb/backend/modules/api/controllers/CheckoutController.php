<?php

namespace backend\modules\api\controllers;

use common\models\Product;
use Yii;
use common\models\Orders;
use common\models\OrderItems;
use common\models\Invoices;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\web\NotFoundHttpException;

class CheckoutController extends ActiveController
{
    public $modelClass = 'common\models\Invoices';

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
        unset($actions['create']);
        return $actions;
    }

    // Criar ordem e fatura
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        $body = Yii::$app->request->post();

        $order = new Orders();
        $order->user_id = $user->id;
        $order->status = 'pending';
        $order->total_price = 0;

        if (!$order->save()) {
            return ['error' => $order->errors];
        }

        $totalPrice = 0;
        foreach ($body['items'] as $itemData) {
            $product = Product::findOne($itemData['product_id']);
            if (!$product) {
                return ['error' => 'Produto não encontrado.'];
            }

            $orderItem = new OrderItems();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product->product_id;
            $orderItem->quantity = $itemData['quantity'];
            $orderItem->unit_price = $product->price;
            $totalPrice += $product->price * $itemData['quantity'];

            if (!$orderItem->save()) {
                return ['error' => $orderItem->errors];
            }
        }

        $invoice = new Invoices();
        $invoice->order_id = $order->id;
        $invoice->total_amount = $totalPrice;
        $invoice->status = 'pending';
        $invoice->invoice_number = uniqid('INV-');
        $invoice->invoice_date = date('Y-m-d');

        if (!$invoice->save()) {
            return ['error' => $invoice->errors];
        }

        return ['message' => 'Pedido criado.', 'order' => $order, 'invoice' => $invoice];
    }

    // Pagar fatura
    public function actionCheckout($id)
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return ['error' => 'Usuário não autenticado.'];
        }

        $invoice = Invoices::findOne($id);
        if (!$invoice) {
            return ['error' => 'Fatura não encontrada.'];
        }

        if ($invoice->orders->user_id !== $user->id) {
            return ['error' => 'Fatura não pertence ao usuário autenticado.'];
        }

        $invoice->status = 'paid';
        if ($invoice->save()) {
            $order = $invoice->orders;
            $order->status = 'completed';
            $order->save();

            return ['message' => 'Pagamento realizado.', 'invoice' => $invoice];
        }

        return ['error' => 'Erro ao processar pagamento.'];
    }
}
