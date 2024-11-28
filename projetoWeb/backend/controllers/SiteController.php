<?php

namespace backend\controllers;

use backend\models\Producers;
use common\models\LoginForm;
use common\models\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
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
            'rules' => [
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
                throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta página.');
                return render('site/login');
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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
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
        Yii::$app->user->logout();

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
