<?php

namespace backend\controllers;

use Yii;
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
        $user = Yii::$app->user->identity;//aqui busco o utilizador logado.
       // dd($user);
    /*
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['view','product_id' => $model->product_id]);
        }

    */
        if($model->load(Yii::$app->request->post())){
            //Validamos se é um produtor logado
            if($user->role === 'producer'){
                $model->producer_id = $user->id;
            }
            if($model->save()){
                return $this->redirect(['view','product_id' =>$model->product_id]);
            }
        }
        return $this->render('create',[
            'model' => $model,
            'user'  => $user,
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
            return $this->redirect(['view', 'id' => $model->id]);
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

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $product_id Product ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id)
    {
        if (($model = Product::findOne(['product_id' => $product_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
