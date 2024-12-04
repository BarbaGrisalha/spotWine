<?php

namespace frontend\controllers;

use common\models\Categories;
use common\models\Product;
use frontend\models\Book;
use frontend\models\ProductFrontSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ProductController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new ProductFrontSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Gerar lista de categorias
        $categoriesList = ArrayHelper::map(Categories::find()->all(), 'category_id', 'name'); // id e name devem ser os campos corretos do seu modelo

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoriesList' => $categoriesList, // Passa para a view
        ]);
    }

    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
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
