<?php
namespace backend\controllers;

use common\models\User;
use common\models\UserDetails;
use common\models\UserSearch;
use Yii;
use yii\web\Controller;
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
        $model = new User();
        $userDetails = new UserDetails();

        if ($model->load($this->request->post()) && $userDetails->load(Yii::$app->request->post())) {
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

    public function actionDeactivate($id)
    {
        $userDetails = UserDetails::findOne(['user_id' => $id]);

        if ($userDetails) {
            $userDetails->status = 0; // Desativa
            if ($userDetails->save(false)) {
                Yii::$app->session->setFlash('success', 'Usuário desativado com sucesso.');
            } else {
                Yii::$app->session->setFlash('error', 'Falha ao desativar o usuário.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Detalhes do usuário não encontrados.');
        }

        return $this->redirect(['index']);
    }

    public function actionActivate($id)
    {
        $userDetails = UserDetails::findOne(['user_id' => $id]);

        if ($userDetails) {
            $userDetails->status = 1; // Ativa
            if ($userDetails->save(false)) {
                Yii::$app->session->setFlash('success', 'Usuário ativado com sucesso.');
            } else {
                Yii::$app->session->setFlash('error', 'Falha ao ativar o usuário.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Detalhes do usuário não encontrados.');
        }

        return $this->redirect(['index']);
    }


    public function actionUpdate($id)
    {
        // Carrega o modelo User pelo ID
        $model = $this->findModel($id);

        // Carrega o modelo UserDetails relacionado
        $userDetails = UserDetails::findOne(['user_id' => $id]) ?? new UserDetails(['user_id' => $id]);

        if (!$model) {
            throw new NotFoundHttpException('Usuário não encontrado.');
        }

        if ($model->load(Yii::$app->request->post()) && $userDetails->load(Yii::$app->request->post())) {

            // Se o campo de senha foi preenchido, atualize a senha
            if (!empty($model->password)) {
                $model->setPassword($model->password); // Define o hash
            }

            // Salva os dados de ambos os modelos
            if ($model->save() && $userDetails->save()) {
                Yii::$app->session->setFlash('success', 'Usuário atualizado com sucesso.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao salvar os dados.');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'userDetails' => $userDetails,
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

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested user does not exist.');
    }



}
