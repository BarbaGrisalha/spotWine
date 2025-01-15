<?php

namespace backend\modules\api\controllers;

use common\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ProductController extends ActiveController
{
    public $modelClass = 'common\models\Product';

    public function behaviors(){
        parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => ['index', 'view'],
        ];
        return $behaviors;
    }

    public function actions(){
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        $actions['index']['prepareDataProvider'] = function ($action) {
            return new ActiveDataProvider([
                'query' => Product::find(),
                'pagination' => false, // Aqui desativa a paginação

            ]);
        };

//        $actions['index']['prepareDataProvider'] = function ($action) {
//            $pageSize = Yii::$app->request->get('per-page', 20); // Parâmetro dinâmico
//
//            return new \yii\data\ActiveDataProvider([
//                'query' => \common\models\Product::find(),
//                'pagination' => [
//                    'pageSize' => $pageSize,
//                ],
//            ]);
//        };



        return $actions;
    }

    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        if (!$user->isProducer()) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para criar produtos.');
        }

        $product = new Product();

        // Definir o producer_id ANTES de validar
        $product->producer_id = $user->producerDetails->id;

        // Carregar e validar os dados
        if ($product->load(Yii::$app->request->post(), '') && $product->validate()) {

            // Validações adicionais
            if ($product->price <= 0) {
                Yii::$app->response->statusCode = 400;
                return ['error' => 'O preço deve ser maior que zero.'];
            }

            if ($product->stock < 0) {
                Yii::$app->response->statusCode = 400;
                return ['error' => 'O estoque não pode ser negativo.'];
            }

            // Salvar o produto
            if ($product->save()) {
                Yii::$app->response->statusCode = 201;
                return [
                    'message' => 'Produto criado com sucesso.',
                    'product' => $product,
                ];
            }

            Yii::$app->response->statusCode = 422;
            return ['error' => $product->errors];
        }

        Yii::$app->response->statusCode = 422;
        return ['error' => $product->errors];
    }


    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        $product = Product::findOne($id);

        if (!$product) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        // Verificar se o usuário é o produtor do produto ou admin
        if ($product->producer_id !== $user->producerDetails->id && !Yii::$app->user->can('admin')) {
            throw new ForbiddenHttpException('Você não tem permissão para atualizar este produto.');
        }

        $data = Yii::$app->request->post();

        // Atualiza os campos se foram enviados
        $product->category_id = $data['category_id'] ?? $product->category_id;
        $product->name = $data['name'] ?? $product->name;
        $product->description = $data['description'] ?? $product->description;
        $product->price = $data['price'] ?? $product->price;
        $product->stock = $data['stock'] ?? $product->stock;

        if ($product->save()) {
            return [
                'message' => 'Produto atualizado com sucesso.',
                'product' => $product,
            ];
        }

        Yii::$app->response->statusCode = 422;
        return ['error' => $product->errors];
    }


    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        $product = Product::findOne($id);

        if (!$product) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        // Verificar se o usuário é o produtor do produto ou admin
        if ($product->producer_id !== $user->producerDetails->id && !Yii::$app->user->can('admin')) {
            throw new ForbiddenHttpException('Você não tem permissão para excluir este produto.');
        }

        if ($product->delete()) {
            return ['message' => 'Produto excluído com sucesso.'];
        }

        Yii::$app->response->statusCode = 500;
        return ['error' => 'Erro ao excluir o produto.'];
    }



}