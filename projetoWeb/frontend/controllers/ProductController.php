<?php

namespace frontend\controllers;

use common\models\Categories;
use common\models\Product;
use common\models\Promotions;
use common\models\Reviews;
use frontend\models\CartItems;
use frontend\models\ProductFrontSearch;
use frontend\models\promocoesViewModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ProductController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new ProductFrontSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $categoriesList = ArrayHelper::map(Categories::find()->all(), 'category_id', 'name');

        // Convertendo cada produto para uma instância de promocoesViewModel
        $products = array_map(fn($product) => new promocoesViewModel($product), $dataProvider->getModels());

        // Atualizar o dataProvider para usar os promocoesViewModel
        $dataProvider->setModels($products);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoriesList' => $categoriesList,
            'cartItemModel' => new CartItems()
        ]);
    }


    public function actionView($id)
    {
        $model = Product::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Produto não encontrado.');
        }

        $reviews = \common\models\Reviews::find()
            ->where(['product_id' => $id])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        $cartItemModel = new CartItems();

        $reviewModel = new \common\models\Reviews();

        $productViewModel = new \frontend\models\promocoesViewModel($model);

        return $this->render('view', [
            'productView' => $productViewModel,
            'reviews' => $reviews,
            'reviewModel' => $reviewModel,
            'cartItemModel' => $cartItemModel,
        ]);
    }



    public function actionReview($id)
    {
        $product = Product::findOne($id);

        if (!$product) {
            throw new \yii\web\NotFoundHttpException('Produto não encontrado.');
        }

        $review = new Reviews();
        $review->product_id = $id;
        $review->user_id = Yii::$app->user->id; // Assume que o usuário está logado

        if ($review->load(Yii::$app->request->post()) && $review->save()) {
            Yii::$app->session->setFlash('success', 'Sua avaliação foi salva com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao salvar sua avaliação.');
        }

        return $this->redirect(['product/view', 'id' => $id]);
    }


    protected function findModel($id)
    {
        if (($model = Product::findOne(['product_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
