<?php

namespace app\controllers;

use Yii;
use yii\rbac\DbManager;
/*class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}*/

public function actionRegister(){
    $model = new User();

    if($model->load(Yii::$app->request->post()) && $model->save()){
        //Verifica o tipo do usuário e atribui a role correspondente
        $auth = Yii::$app->authManager;

        if($model->tipo ==='produtor'){
            $role = $auth->getRole('produtor');
        }else{
            $role = $auth->getRole('consumidor');
        }

        //atribui a role aos usuarios recém-cadastrados
        $auth->assign($role,$model->id);

        //Redireciona ou retorna uma responta de sucesso
        return $this->redirect(['login']);
    }
    return $this->render('register',[
        'model'=>$model,
    ]);
}
