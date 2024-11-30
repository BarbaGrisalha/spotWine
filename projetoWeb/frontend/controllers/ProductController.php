<?php

namespace frontend\controllers;

use frontend\models\ProductFrontSearch;
use Yii;

class ProductController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new ProductFrontSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
