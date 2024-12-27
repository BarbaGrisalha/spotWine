<?php

namespace frontend\controllers;

use frontend\models\Cart;
use Yii;
use yii\web\Controller;
use frontend\models\CartItems;
use common\models\Orders;
use common\models\OrderItems;
use common\models\Invoices;

class CheckoutController extends Controller
{
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        // Buscar itens do carrinho do usuário logado
        $cartItems = CartItems::find()
            ->with('product')
            ->where(['cart_id' => Cart::findOrCreateCart($userId)->id])
            ->all();

        $cartViewModels = array_map(function ($item) {
            return new \frontend\models\promocoesViewModel($item->product, $item->quantity);
        }, $cartItems);

        $totalAmount = array_reduce($cartViewModels, function ($sum, $model) {
            return $sum + $model->getTotalPrice();
        }, 0);

        if (Yii::$app->request->isPost) {
            // Criar o pedido
            $order = new Orders([
                'user_id' => $userId,
                'total_price' => $totalAmount,
                'status' => 'pending',
            ]);

            if ($order->save()) {
                foreach ($cartViewModels as $model) {
                    $orderItem = new OrderItems([
                        'order_id' => $order->id,
                        'product_id' => $model->product->product_id,
                        'quantity' => $model->quantity,
                        'unit_price' => $model->getFinalPrice(),
                    ]);
                    if (!$orderItem->save()) {
                        Yii::$app->session->setFlash('error', 'Erro ao salvar item do pedido.');
                        return $this->redirect(['index']);
                    }
                }

                // Gerar a fatura e associar ao pedido
                $invoice = new Invoices([
                    'order_id' => $order->id, // Associando a fatura ao pedido
                    'invoice_number' => uniqid('INV-'),
                    'invoice_date' => date('Y-m-d'),
                    'total_amount' => $order->total_price,
                    'status' => 'pending',
                ]);

                if ($invoice->save()) {
                    return $this->redirect(['payment', 'orderId' => $order->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao gerar a fatura.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao criar o pedido.');
            }
        }

        return $this->render('index', [
            'cartViewModels' => $cartViewModels,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function actionPayment($orderId)
    {
        $order = Orders::findOne($orderId);

        if (!$order) {
            throw new \yii\web\NotFoundHttpException('Pedido não encontrado.');
        }

        if (Yii::$app->request->isPost) {
            $order->status = 'completed';

            $invoice = $order->invoice; // Obter a fatura associada ao pedido
            if ($invoice) {
                $invoice->status = 'paid';
                if (!$invoice->save(false)) {
                    Yii::$app->session->setFlash('error', 'Erro ao atualizar a fatura.');
                }
            }

            if ($order->save(false)) {
                return $this->redirect(['confirmation', 'orderId' => $order->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao atualizar o pedido.');
            }
        }

        return $this->render('payment', [
            'order' => $order,
        ]);
    }

    public function actionConfirmation($orderId)
    {
        $order = Orders::findOne($orderId);

        if (!$order) {
            throw new \yii\web\NotFoundHttpException('Pedido não encontrado.');
        }

        return $this->render('confirmation', [
            'order' => $order,
        ]);
    }
}
