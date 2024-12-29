<?php

namespace frontend\controllers;

use common\models\Product;
use common\models\Reviews;
use yii\data\ActiveDataProvider;

class ReviewsController extends \yii\web\Controller
{
    public function actionIndex($productId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Reviews::find()->where(['product_id' => $productId])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10, // Número de reviews por página
            ],
        ]);

        $product = Product::findOne(['product_id' => $productId]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'product' => $product
        ]);
    }

    public function actionView()
    {
        return $this->render('view');
    }

}
