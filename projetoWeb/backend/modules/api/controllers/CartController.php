<?php

namespace backend\modules\api\controllers;

use common\models\Cart;
use common\models\CartItems;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class CartController extends ActiveController
{
    public $modelClass = 'common\models\Cart';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => [], // Exclua ações públicas, como login
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete'], $actions['update']);
        return $actions;
    }

    /**
     * Retorna o carrinho do usuário autenticado.
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            throw new \yii\web\UnauthorizedHttpException('Usuário não autenticado.');
        }

        $cart = Cart::findOne(['user_id' => $user->id]);
        if (!$cart) {
            return ['error' => 'Carrinho não encontrado.'];
        }

        $items = $cart->getCartItems()->with('product')->all();

        return [
            'cart' => [
                'id' => $cart->id,
                'user_id' => $cart->user_id,
                'session_id' => $cart->session_id,
                'created_at' => $cart->created_at,
                'updated_at' => $cart->updated_at,
            ],
            'items' => array_map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product ? $item->product->name : null,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ];
            }, $items),
        ];
    }

    /**
     * Adiciona um item ao carrinho.
     */
    public function actionAdd()
    {
        $user = Yii::$app->user->identity;
        $data = Yii::$app->request->post();
        $productId = $data['product_id'] ?? null;
        $quantity = $data['quantity'] ?? 1;

        if (!$productId) {
            return ['error' => 'Produto inválido.'];
        }

        try {
            $cart = Cart::findOrCreateCart($user->id);
            $item = $cart->addItem($productId, $quantity);
            return ['success' => true, 'item' => $item];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Atualiza a quantidade de um item no carrinho.
     */
    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        $data = Yii::$app->request->post();
        $quantity = $data['quantity'] ?? null;

        if (!$quantity || $quantity < 1) {
            return ['error' => 'Quantidade inválida.'];
        }

        $cart = Cart::findOne(['user_id' => $user->id]);
        if (!$cart) {
            return ['error' => 'Carrinho não encontrado.'];
        }

        $item = CartItems::findOne(['id' => $id, 'cart_id' => $cart->id]);
        if (!$item) {
            return ['error' => 'Item não encontrado no carrinho.'];
        }

        $item->quantity = $quantity;
        if ($item->save()) {
            return ['success' => true, 'message' => 'Quantidade atualizada.', 'quantity' => $item->quantity];
        }

        return ['error' => 'Erro ao atualizar a quantidade.'];
    }

    /**
     * Remove um item do carrinho.
     */
    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        $cart = Cart::findOne(['user_id' => $user->id]);

        if (!$cart) {
            return ['error' => 'Carrinho não encontrado.'];
        }

        $item = CartItems::findOne(['id' => $id, 'cart_id' => $cart->id]);

        if (!$item) {
            return ['error' => 'Item não encontrado no carrinho.'];
        }

        if ($item->delete()) {
            return ['success' => true, 'message' => 'Item removido com sucesso.'];
        }

        return ['error' => 'Erro ao remover item do carrinho.'];
    }

    /**
     * Esvazia o carrinho do usuário.
     */
    public function actionClearCart()
    {
        $user = Yii::$app->user->identity;
        $cart = Cart::findOne(['user_id' => $user->id]);

        if (!$cart) {
            return ['error' => 'Carrinho não encontrado.'];
        }

        CartItems::deleteAll(['cart_id' => $cart->id]);

        return ['success' => true, 'message' => 'Carrinho esvaziado com sucesso.'];
    }
}
