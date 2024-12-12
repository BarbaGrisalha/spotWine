<?php

namespace frontend\controllers;

use common\models\Categories;
use common\models\Product;
use common\models\Promotions;
use frontend\models\ProductFrontSearch;
use frontend\models\ProductViewModel;
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

        // Convertendo cada produto para uma instância de ProductViewModel
        $products = array_map(fn($product) => new ProductViewModel($product), $dataProvider->getModels());

        // Atualizar o dataProvider para usar os ProductViewModel
        $dataProvider->setModels($products);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoriesList' => $categoriesList,
        ]);
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (!$model) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        $productViewModel = new ProductViewModel($model);

        return $this->render('view', [
            'productView' => $productViewModel,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Product::findOne(['product_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
