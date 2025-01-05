<?php

namespace backend\modules\api\controllers;

use common\models\AuthAssignment;
use common\models\ConsumerDetails;
use common\models\LoginForm;
use common\models\User;
use frontend\models\SignupForm;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Configura o QueryParamAuth para autenticar usando o token
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => ['login', 'signup'], // Exclui essas actions da necessidade de autenticação
        ];

        return $behaviors;
    }


//    public function actions()
//    {
//        $actions = parent::actions();
//        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
//        return $actions;
//    }

    public function actionListAll()
    {
        // Garantir que apenas administradores ou usuários autorizados acessem
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new \yii\web\UnauthorizedHttpException('Usuário não autenticado.');
        }

        // Verifica se o usuário tem permissão (Exemplo: apenas admin pode listar)
        $authAssignment = \common\models\AuthAssignment::findOne(['user_id' => $user->id]);
        if (!$authAssignment || $authAssignment->item_name !== 'admin') {
            throw new \yii\web\ForbiddenHttpException('Acesso negado.');
        }

        // Recuperar todos os usuários
        $users = User::find()->all();

        // Estruturar a resposta
        return array_map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,

            ];
        }, $users);
    }

    public function actionView($id)
    {
        // Localizar o usuário pelo ID
        $user = User::findOne($id);

        if (!$user) {
            throw new \yii\web\NotFoundHttpException('Usuário não encontrado.');
        }

        // Verificar se o usuário é um consumidor
        if ($user->isConsumer()) {
            $consumerDetails = $user->consumerDetails;

            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => 'consumer',
                'details' => [
                    'nif' => $consumerDetails->nif,
                    'phone_number' => $consumerDetails->phone_number,
                    'status' => $consumerDetails->status,
                ],
            ];
        }

        // Verificar se o usuário é um produtor
        if ($user->isProducer()) {
            $producerDetails = $user->producerDetails;

            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => 'producer',
                'details' => [
                    'nif' => $producerDetails->nif,
                    'status' => $producerDetails->status,
                    'winery_name' => $producerDetails->winery_name,
                    'location' => $producerDetails->location,
                    'address' => $producerDetails->address,
                    'postal_code' => $producerDetails->postal_code,
                    'city' => $producerDetails->city,
                    'phone' => $producerDetails->phone,
                    'mobile' => $producerDetails->mobile,
                ],
            ];
        }

        // Caso o usuário não tenha um papel definido
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => 'undefined',
        ];
    }



    public function actionLogin()
    {
        $form = new LoginForm();
        $form->load(Yii::$app->request->post(), '');

        if (!$form->validate()) {
            Yii::$app->response->statusCode = 400;
            return $form->getErrors(); // Retorna erros de validação do formulário
        }

        $user = User::findByUsername($form->username);
        if ($user && $user->validatePassword($form->password)) {
            $authAssignment = AuthAssignment::findOne(['user_id' => $user->id]);

            if (!$authAssignment || $authAssignment->item_name !== "consumer") {
                Yii::$app->response->statusCode = 403; // Acesso negado
                return "Acesso Negado";
            }

            $consumer = ConsumerDetails::findOne(['user_id' => $user->id]);
            if (!$consumer) {
                Yii::$app->response->statusCode = 404;
                return "Detalhes do consumidor não encontrados.";
            }

            // Garantir que o token esteja definido
            if (!$user->auth_key) {
                $user->generateAuthKey();
                $user->save(false); // Salvar sem validação
            }

            Yii::$app->response->statusCode = 200;
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'telefone' => $consumer->phone_number,
                'nif' => $consumer->nif,
                'token' => $user->auth_key,
            ];
        }

        Yii::$app->response->statusCode = 401; // Credenciais inválidas
        return 'Username e/ou password incorreto.';
    }

    public function actionRegisto()
    {
        $model = new SignupForm(); // Use o caminho correto para o modelo de signup

        // Carregar os dados do POST no modelo
        $model->load(Yii::$app->request->post(), '');

        if ($model->validate() && $user = $model->signup()) {
            // Resposta de sucesso
            return [
                "response" => "Registro realizado com sucesso!",
                "user" => [
                    "id" => $user->id,
                    "username" => $user->username,
                    "email" => $user->email,
                    "nif" => $model->nif,
                    "phone_number" => $model->phone_number,
                    "token" => $user->auth_key,
                ],
            ];
        } else {
            // Captura os erros e retorna em um formato amigável
            $errorMessages = [];
            foreach ($model->errors as $field => $errors) {
                $errorMessages[$field] = $errors;
            }
            Yii::$app->response->statusCode = 422; // Unprocessable Entity
            return ["errors" => $errorMessages];
        }
    }


    public function actionEditar()
    {
        // Verificar se o usuário está autenticado
        $user = Yii::$app->user->identity;
        if (!$user) {
            throw new \yii\web\UnauthorizedHttpException('Usuário não autenticado.');
        }

        // Obter os parâmetros enviados
        $params = Yii::$app->request->getBodyParams();

        // Localizar os detalhes do consumidor (ou perfil)
        $consumerDetails = \common\models\ConsumerDetails::findOne(['user_id' => $user->id]);
        if (!$consumerDetails) {
            throw new \yii\web\NotFoundHttpException('Detalhes do consumidor não encontrados.');
        }

        // Atualizar os campos
        $consumerDetails->phone_number = $params['phone_number'] ?? $consumerDetails->phone_number;
        $consumerDetails->nif = $params['nif'] ?? $consumerDetails->nif;

        if ($consumerDetails->save()) {
            return [
                'message' => 'Perfil atualizado com sucesso.',
                'details' => [
                    'phone_number' => $consumerDetails->phone_number,
                    'nif' => $consumerDetails->nif,
                ],
            ];
        }

        Yii::$app->response->statusCode = 422;
        return [
            'message' => 'Erro ao atualizar perfil.',
            'errors' => $consumerDetails->errors,
        ];
    }


}
