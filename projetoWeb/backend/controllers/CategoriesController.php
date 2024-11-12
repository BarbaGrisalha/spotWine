<?php

namespace app\controllers;

class CategoriesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
