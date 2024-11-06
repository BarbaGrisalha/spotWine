<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
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
                    ],
                    // Acesso completo para Altamir, João, Lucas e admin
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action) {
                            return in_array(Yii::$app->user->identity->username, ['Altamir', 'João', 'Lucas', 'admin']); // Inclui admin temporariamente
                        }
                    ],
                    // Permitir acesso a 'index', 'developing' e 'logout' para qualquer usuário autenticado
                    [
                        'actions' => ['index', 'developing', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
        return $this->render('index');
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

}
