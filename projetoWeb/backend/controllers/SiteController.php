<?php

namespace backend\controllers;

use backend\models\Producers;
use common\models\LoginForm;
use common\models\ProducerDetails;
use common\models\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(){
    return [

        'access' => [
            'class' => AccessControl::class,
            'only' => ['logout','index'],
            'rules' => [
                [
                    'actions' => ['index'],
                    'allow'=>true,
                    'roles'=>['admin'],
                ],
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['producer'],

                ],
                [
                    'actions' => ['logout'],
                    'allow' => true,
                    'roles' =>['@'],// Apenas usuários autenticados

                ],
                // Permitir acesso para login e erro para visitantes
                [
                    'actions' => ['login', 'error'],
                    'allow' => true,
                    'roles' => ['?'], // Visitantes
                ],
                // Permitir acesso para admin e produtor
                [
                    'allow' => true,
                    'roles' => ['admin', 'producer'], // Apenas admin e produtor
                ],
                // Negar acesso para consumidores logados
                [
                    'actions' => ['login'],
                    'allow' => false,
                    'roles' => ['consumer'], // Usuários logados

                ],
            ],
            'denyCallback' => function ($rule, $action) {
                if (Yii::$app->user->isGuest) {
                    return Yii::$app->response->redirect(['site/login']);
                }
                //Exibir a página de erro personalizada
                return Yii::$app->response->statusCode = 403;
            },
        ],
        'verbs' => [
            'class' => VerbFilter::class,
            'actions' => [
                'logout' => ['post'], // Logout via POST
            ],
        ],
    ];


}
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

       $searchModel = new UserSearch();
       $dataProvider = $searchModel->search($this->request->queryParams);

       return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
       ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (! Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Yii::$app->user->identity;

            // Verificar status do produtor após login
            if ($user->producerDetails && $user->producerDetails->status !== 1) {
                Yii::$app->user->logout(); // Faz logout
                Yii::$app->session->setFlash('error', 'Seu acesso foi desativado. Entre em contato com o administrador.');
                return $this->goHome();
            }


            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout(false);
        return $this->goHome();
    }
    /**
     * Developing action.
     *
     * @return Response
     */
    public function actionDeveloping()
    {
        return $this->render('developing');
    }

    /**
     * Relatório de Clientes action.
     *
     * @return Response
     */

    public function actionRelatorioCliente()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $clientes = Users::find()->asArray()->all();
        return  $clientes;// Retorna a lista de clientes em JSON
    }

    /**
     * Relatório de Produtores action.
     *
     * @return Response
     */
    public function actionRelatorioProdutores()
    {
        // Recupera todos os produtores do banco de dados
        $produtores = Producer::find()->asArray()->all(); // Ou ajuste conforme necessário
        // Passa os dados para a view
        /*return $this->render('relatorio_produtores', [
            'produtores' => $produtores,
        ]);*/
        return$produtores;
    }

    /**
     * Check DB Connection action.
     *
     * @return Response
     */
    public function actionCheckDbConnection(){
        try{
            Yii::$app->db->open();
            $message = "Conexão com a base de dados executada!";
            $status = "success";
        }catch(\Exception $e){
            $message = "Erro ao conectar a base de dados : " .$e->getMessage();
            $status = "error";
        }
    }
}
