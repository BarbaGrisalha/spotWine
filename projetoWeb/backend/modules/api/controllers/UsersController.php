<?php

namespace backend\modules\api\controllers;

use http\Client;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `api` module
 */
class UsersController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        //Obtém todos os clientes da base de dados
        $clientes = \app\models\Users::find()->all();
        //Retorna a lista de clientes
        return ArrayHelper::toArray($clientes,[
            'common\models\Client'=>[//Atento para ajustar corretamente o namespace com o projeto
                'id',
                'nome',
                'email',
            ],
        ]);

       /*Teste funcionou
        return "Lista de clientes disponível!";
        */
    }

}
