<?php

namespace backend\controllers;

use common\models\User;
use common\models\UserDetails;
use common\models\UserSearch;
use Yii;
use yii\web\NotFoundHttpException;

class UserController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $model = new User();
        $userDetails = new UserDetails();

        if ($model->load(Yii::$app->request->post()) && $userDetails->load(Yii::$app->request->post())) {
            // Salva o usuário e gera o hash da senha
            if ($model->save()) {
                // Associa o user_id do novo usuário ao user_details
                $userDetails->user_id = $model->id;

                // Salva os detalhes do usuário
                if ($userDetails->save()) {
                    // Atribuir o role de 'producer' automaticamente
                    $auth = Yii::$app->authManager;
                    $producerRole = $auth->getRole('producer');
                    $auth->assign($producerRole, $model->id);

                    // Redireciona para a view do usuário criado
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'userDetails' => $userDetails,
        ]);
    }



    public function actionDeactivate()
    {
        return $this->render('deactivate');
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionView($id)
    {
        $model = User::findOne($id); // Busca o modelo principal User pelo ID

        if (!$model) {
            throw new NotFoundHttpException('O usuário solicitado não foi encontrado.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }


}
