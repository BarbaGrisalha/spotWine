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

        // Desabilitar ações que você deseja sobrescrever
        unset($actions['index'], $actions['create'], $actions['delete'], $actions['update']);

        // Retornar ações restantes (como 'view', 'update', etc.)
        return $actions;
    }


    public function actionAdd()
    {
        $user = Yii::$app->user->id;

        $data = Yii::$app->request->post();
        $productId = $data['product_id'] ?? null;
        $quantity = $data['quantity'] ?? 1;

        if (!$productId) {
            return ['error' => 'Produto inválido.'];
        }

        try {
            $cart = Cart::findOrCreateCart($user);
            $item = $cart->addItem($productId, $quantity);
            return ['success' => true, 'item' => $item];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actionIndex($id)
    {
        // Obtenha o usuário autenticado
        $user = Yii::$app->user->identity;
        if (!$user) {
            throw new \yii\web\UnauthorizedHttpException('Usuário não autenticado.');
        }

        // Verifique se o carrinho pertence ao usuário autenticado
        $cart = Cart::findOne(['id' => $id, 'user_id' => $user->id]);
        if (!$cart) {
            return [
                'error' => 'Carrinho não encontrado ou não pertence ao usuário.',
            ];
        }

        // Carregar os itens do carrinho com os produtos relacionados
        $items = $cart->getCartItems()->with('product')->all();

        // Estruturar a resposta
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



    public function actionDelete($id)
    {
        $userId = Yii::$app->user->id;
        $cart = Cart::findOne(['user_id' => $userId]);

        if (!$cart) {
            return ['error' => 'Carrinho não encontrado.'];
        }

        $item = CartItems::findOne(['id' => $id, 'cart_id' => $cart->id]);

        if (!$item) {
            return ['error' => 'Item não encontrado no carrinho do usuário.'];
        }

        if ($item->delete()) {
            return ['success' => true, 'message' => 'Item removido com sucesso.'];
        }

        return ['error' => 'Erro ao remover o item do carrinho.'];
    }

    public function actionUpdate($id)
    {
        // Obter o ID do usuário autenticado
        $userId = Yii::$app->user->id;

        // Encontrar o carrinho associado ao usuário
        $cart = Cart::findOne(['user_id' => $userId]);
        if (!$cart) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Carrinho não encontrado.'];
        }

        // Encontrar o item no carrinho
        $item = CartItems::findOne(['id' => $id, 'cart_id' => $cart->id]);
        if (!$item) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Item não encontrado no carrinho.'];
        }

        // Obter a nova quantidade do corpo da requisição
        $data = Yii::$app->request->post();
        $quantity = $data['quantity'] ?? null;

        // Validar a nova quantidade
        if ($quantity === null || $quantity <= 0) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Quantidade inválida.'];
        }

        // Atualizar a quantidade do item
        $item->quantity = $quantity;

        // Tentar salvar o item atualizado
        if ($item->save()) {
            return [
                'success' => true,
                'message' => 'Quantidade atualizada com sucesso.',
                'item' => [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ],
            ];
        }

        // Caso o salvamento falhe
        Yii::$app->response->statusCode = 500;
        return ['error' => 'Erro ao atualizar a quantidade.'];
    }

}
