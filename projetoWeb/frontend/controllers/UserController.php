<?php

namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use common\models\User;
use yii\rbac\DbManager;


class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionRegister(){

    }


}
