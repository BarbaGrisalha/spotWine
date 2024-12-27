<?php
namespace backend\controllers;

use common\models\ProducerDetails;
use common\models\Producers;
use common\models\Product;
use common\models\User;
use common\models\UserDetails;
use common\models\UserSearch;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams); // Utilize o método search()

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        // Verifica se o usuário tem permissão para criar
        if (!Yii::$app->user->can('createUsers')) {
            throw new ForbiddenHttpException('Você não tem permissão para criar produtores.');
        }

        $model = new User();
        $producerDetails = new ProducerDetails();

        if ($model->load(Yii::$app->request->post()) && $producerDetails->load(Yii::$app->request->post())) {
            // Delega lógica de criação ao modelo
            if ($producerDetails->createProducer($model)) {
                Yii::$app->session->setFlash('success', 'Produtor criado com sucesso.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'producerDetails' => $producerDetails,
        ]);
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
    public function actionActivate($id)
    {
        $model = $this->findModel($id);

        if ($model->activate()) {
            Yii::$app->session->setFlash('success', 'Usuário ativado com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Não foi possível ativar o usuário.');
        }

        return $this->redirect(['index']);
    }

    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);

        if ($model->deactivate()) {
            Yii::$app->session->setFlash('success', 'Usuário desativado com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Não foi possível desativar o usuário.');
        }

        return $this->redirect(['index']);
    }



    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $producerDetails = $model->getDetails();

        if (!$producerDetails) {
            throw new NotFoundHttpException('Detalhes do usuário não encontrados.');
        }

        if ($model->load(Yii::$app->request->post()) && $producerDetails->load(Yii::$app->request->post())) {
            // Salva o usuário e os detalhes
            if ($model->saveWithDetails($producerDetails)) {
                Yii::$app->session->setFlash('success', 'Usuário atualizado com sucesso.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao salvar os dados.');
            }
        }

        return $this->render('update',[
            'model' => $model,
            'userDetails' => $producerDetails,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested user does not exist.');
    }


}
