<?php

namespace backend\controllers;

use backend\models\Producers;
use common\models\LoginForm;
use http\Client;
use Psy\Util\Json;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use backend\models\Users;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()//Aqui defininos as regras e o RBAC
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // Acesso permitido para login e erro
                    [
                        'actions' => ['login', 'error', 'register'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    // Acesso completo para Altamir, João, Lucas e admin
                    [
                        'allow' => true,
                        'roles' => ['admin','produtor'],
                        /*'matchCallback' => function($rule, $action) {
                            return in_array(Yii::$app->user->identity->username, ['Altamir', 'João', 'Lucas', 'admin']); // Inclui admin temporariamente
                        }*/
                    ],
                    // Permitir acesso a 'index', 'developing' e 'logout' para qualquer usuário autenticado
                    [
                        'actions' => ['index', 'developing', 'logout'],
                        'allow' => true,
                        'roles' => ['admim','produtor'],//se tiver @ é para todos os logados.
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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

        $clientes = Users::find()->all();
       // dd('fsfdfdsfsdfdsfdsf');
        $produtores = Producers::find()->all();

        return $this->render('index',[
            'clientes'=>$clientes,
            'produtores'=>$produtores,
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

        $this->layout = 'blank';
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
