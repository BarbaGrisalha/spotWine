<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\CartItems;
use common\models\Invoices;
use common\models\OrderItems;
use common\models\Orders;
use common\services\MqttServices;
use frontend\models\promocoesViewModel;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'payment', 'confirmation'],
                'rules' => [

                    [
                        'actions' => ['index', 'payment', 'confirmation'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        $cartItems = CartItems::find()
            ->with('product')
            ->where(['cart_id' => Cart::findOrCreateCart($userId)->id])
            ->all();

        $cartViewModels = array_map(function ($item) {
            return new promocoesViewModel($item->product, $item->quantity);
        }, $cartItems);

        $totalAmount = array_reduce($cartViewModels, function ($sum, $model) {
            return $sum + $model->getTotalPrice();
        }, 0);

        if (Yii::$app->request->isPost) {
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

                $invoice = new Invoices([
                    'order_id' => $order->id,
                    'invoice_number' => uniqid('INV-'),
                    'invoice_date' => date('Y-m-d'),
                    'total_amount' => $order->total_price,
                    'status' => 'pending',
                ]);

                if ($invoice->save()) {
                    // Notificar sobre a criação da fatura
                    $mensagem = [
                        'titulo' => mb_convert_encoding('Nova Fatura Criada!', 'UTF-8', 'auto'),
                        'descricao' => mb_convert_encoding("Fatura número {$invoice->invoice_number} criada para o pedido #{$order->id}.", 'UTF-8', 'auto'),
                        'valor_total' => mb_convert_encoding('€' . number_format($invoice->total_amount, 2), 'UTF-8', 'auto'),
                        'status' => mb_convert_encoding($invoice->status, 'UTF-8', 'auto'),
                        'data_criacao' => mb_convert_encoding($invoice->invoice_date, 'UTF-8', 'auto'),
                    ];

                    MqttServices::FazPublishNoMosquitto('spotwine/faturas', json_encode($mensagem, JSON_UNESCAPED_UNICODE));

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
            throw new NotFoundHttpException('Pedido não encontrado.');
        }

        if (Yii::$app->request->isPost) {
            $order->status = 'completed';

            $invoice = $order->invoice;
            if ($invoice) {
                $invoice->status = 'paid';
                if ($invoice->save(false)) {
                    // Notificar sobre o pagamento da fatura
                    $mensagem = [
                        'titulo' => mb_convert_encoding('Fatura Paga!', 'UTF-8', 'auto'),
                        'descricao' => mb_convert_encoding("Fatura número {$invoice->invoice_number} foi paga.", 'UTF-8', 'auto'),
                        'pedido_id' => mb_convert_encoding($order->id, 'UTF-8', 'auto'),
                        'valor_total' => mb_convert_encoding('€' . number_format($invoice->total_amount, 2), 'UTF-8', 'auto'),
                        'status' => mb_convert_encoding($invoice->status, 'UTF-8', 'auto'),
                        'data_pagamento' => mb_convert_encoding(date('Y-m-d H:i:s'), 'UTF-8', 'auto'),
                    ];

                    MqttServices::FazPublishNoMosquitto('spotwine/faturas/pagamento', json_encode($mensagem, JSON_UNESCAPED_UNICODE));
                } else {
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
            throw new NotFoundHttpException('Pedido não encontrado.');
        }

        return $this->render('confirmation', [
            'order' => $order,
        ]);
    }
}
