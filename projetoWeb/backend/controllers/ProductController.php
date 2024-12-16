<?php

namespace backend\controllers;

use Yii;
use common\models\Producers;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        // Obtém o usuário logado
        $producer = Yii::$app->user->identity->producers;


        $searchModel = new ProductSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['producer_id'=>$producer->producer_id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);

        /*
        // Obtém o usuário logado
        $user = Yii::$app->user->identity;

        // Se não for admin, filtrar apenas os produtos do produtor logado
        $query = Product::find();
        if ($user->role !== 'admin') {
            $query->where(['producer_id' => $user->id]);
        }

        // Filtro por produtor (apenas para admins)
        $producerId = Yii::$app->request->get('producer_id');
        if ($user->role === 'admin' && $producerId) {
            $query->andWhere(['producer_id' => $producerId]);
        }

        // Configurar paginação
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $produtos = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // Lista de produtores para o dropdown (apenas para admins)
        $produtores = [];
        if ($user->role === 'admin') {
            $produtores = User::find()->where(['role' => 'producer'])->all();
        }

        return $this->render('index', [
            'produtos' => $produtos,
            'pagination' => $pagination,
            'produtores' => $produtores,
            'producerId' => $producerId,
        ]);
        */

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
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model = new Product();
        // obter o utilizador logado
        $user = Yii::$app->user;//aqui busco o utilizador logado.

        if ($model->load(Yii::$app->request->post())) {

            // $model->product_id = Yii::$app->user->identity->producers->producer_id;
            //Validamos se é um produtor logado

            if (\Yii::$app->user->can('producer')) {
                $model->producer_id = $user->id;
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
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($product_id)
    {
        $model = $this->findModel($product_id);//troquei $id por $product_id

        // Obtenha o usuário logado
        $user = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id]);
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
     * @return \yii\web\Response
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
    protected function findModel($product_id)
    {
        /*if (($model = Product::findOne(['product_id' => $product_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }*/
        $model = Product::findOne(['product_id' => $product_id]);

        if (!$model || $model->producer_id !== Yii::$app->user->id && Yii::$app->user->identity->role !== 'admin') {
            throw new NotFoundHttpException('Você não tem permissão para acessar esse produto!');
        }
        return $model;
    }
}
