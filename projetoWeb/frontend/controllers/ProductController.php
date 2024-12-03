<?php

namespace frontend\controllers;

use common\models\Categories;
use frontend\models\ProductFrontSearch;
use Yii;
use yii\helpers\ArrayHelper;

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

}
