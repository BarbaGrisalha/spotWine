<?php

namespace backend\controllers;

use common\models\ProducerDetails;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'only' => ['login', 'index', 'create', 'read', 'update', 'delete', 'logout'], //Ações protegidas.
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'read', 'update', 'delete'],
                            'roles' => ['@'], //Significa que somente os usuários autenticados.
                            'matchCallback' => function ($rule, $action) {
                                $user = Yii::$app->user->identity;

                                return $user && $user->role === 'producer' &&
                                    Yii::$app->authManager->checkAccess($user->id, $action->id . 'Product');
                            },
                        ],
                        [//As páginas que podem ser vistas.
                            'allow' => true,
                            'actions' => ['index', 'view', 'create', 'logout','update','delete'],
                            'roles' => ['@'],
                        ]
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $product_id Product ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($product_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($product_id),
           // dd($product_id)
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {

        $model = new Product();
        // obter o utilizador logado
        $user = Yii::$app->user;//aqui busco o utilizador logado.
        $producer = ProducerDetails::findOne(['user_id' => $user->id]);

        if ($model->load(Yii::$app->request->post())) {

            // $model->product_id = Yii::$app->user->identity->producers->producer_id;
            //Validamos se é um produtor logado

            if (\Yii::$app->user->can('producer')) {
                $model->producer_id = $producer->id;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'product_id' => $model->product_id]);
            } else {
               // dd($model);
                Yii::$app->session->setFlash('error', 'Não foi possível guardar o produto criado. Verifique 
                e tente novamente.');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'user' => $user,
        ]);

    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $product_id Product ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($product_id)
    {

        $model = $this->findModel($product_id);//troquei $id por $product_id

        // Obtenha o usuário logado
        $user = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id]);//mudei de id para product_id
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $user, // Passe o usuário para a view
        ]);

    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $product_id Product ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($product_id)
    {

        $this->findModel($product_id)->delete();

        return $this->redirect(['index']);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $product_id Product ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id)//aqui eu mudei para id para acompanhar o update
    {

        $model = Product::findOne(['product_id' => $product_id]);

        if (!$model || $model->producer_id !== Yii::$app->user->id && Yii::$app->user->identity->role !== 'admin') {
            throw new NotFoundHttpException('Você não tem permissão para acessar esse produto!');
        }
        return $model;
    }
}
