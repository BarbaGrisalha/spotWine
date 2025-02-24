<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\CartItems;
use common\models\Product;
use common\services\MqttServices;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionAdd()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $data = $request->post();
            $productId = $data['CartItems']['product_id'] ?? null;
            $quantity = $data['CartItems']['quantity'] ?? 1;

            if (!$productId) {
                Yii::$app->session->setFlash('error', 'Produto inválido.');
                return $this->redirect(['site/index']);
            }

            try {
                // Identificar o carrinho do usuário ou da sessão
                $cart = Cart::findOrCreateCart(Yii::$app->user->id);
                $cart->addItem($productId, $quantity);

                // Obter detalhes do produto
                $product = Product::findOne($productId);

                // Obter informações do usuário ou visitante
                $user = Yii::$app->user->isGuest ? null : Yii::$app->user->identity;

                if ($product) {
                    // Notificar via MQTT
                    $mensagem = [
                        'titulo' => mb_convert_encoding('Produto Adicionado ao Carrinho!', 'UTF-8', 'auto'),
                        'descricao' => mb_convert_encoding(
                            $user
                                ? "{$user->username} adicionou o produto '{$product->name}' ao carrinho."
                                : "Um visitante adicionou o produto '{$product->name}' ao carrinho.",
                            'UTF-8',
                            'auto'
                        ),
                        'produto_id' => mb_convert_encoding($product->product_id, 'UTF-8', 'auto'),
                        'quantidade' => mb_convert_encoding($quantity, 'UTF-8', 'auto'),
                        'preco_unitario' => mb_convert_encoding('€' . number_format($product->price, 2), 'UTF-8', 'auto'),
                        'data' => mb_convert_encoding(date('Y-m-d H:i:s'), 'UTF-8', 'auto'),
                    ];

                    MqttServices::FazPublishNoMosquitto('spotwine/carrinho', json_encode($mensagem, JSON_UNESCAPED_UNICODE));
                }

                Yii::$app->session->setFlash('success', 'Produto adicionado ao carrinho.');
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

            return $this->redirect(['site/index']);
        }

        throw new BadRequestHttpException('Requisição inválida.');
    }




    public function actionDelete($id)
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $cart = Cart::findOrCreateCart(Yii::$app->user->id);

            // Encontrar o item no carrinho
            $cartItem = CartItems::findOne(['cart_id' => $cart->id, 'product_id' => $id]);
            if ($cartItem) {
                if ($cartItem->delete()) {
                    Yii::$app->session->setFlash('success', 'Item removido do carrinho.');
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao remover item do carrinho.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Item não encontrado no carrinho.');
            }

            return $this->redirect(['site/index']); // Ajuste conforme necessário
        }

        throw new BadRequestHttpException('Requisição inválida.');
    }




    public function actionIndex()
    {
        $cart = Cart::findOrCreateCart(Yii::$app->user->id);
        $cartItems = $cart->cartItems;
        $totalAmount = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item->price * $item->quantity);
        }, 0);

        return $this->render('index', [
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
        ]);
    }


    /**
     * Displays a single Cart model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $session = Yii::$app->session;
        $session->open();

        $cart = Cart::findOne(['session_id' => $session->id]);

        $items = $cart ? $cart->cartItems : [];

        return $this->asJson([
            'items' => $items,
            'total' => array_sum(array_map(function ($item) {
                return $item->product->price * $item->quantity;
            }, $items)),
        ]);
    }


    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Cart();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
