<?php

namespace frontend\controllers;

use common\models\CartItems;
use common\models\ProducerDetails;
use frontend\models\ProducerSearch;
use frontend\models\ProductFrontSearch;
use frontend\models\promocoesViewModel;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProducersController implements the CRUD actions for Producers model.
 */
class ProducersController extends Controller
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
     * Lists all Producers models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProducerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Producers model.
     * @param int $producer_id Producer ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($producer_id)
    {
        $searchModel = new ProductFrontSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $producer_id);

        $products = array_map(fn($product) => new promocoesViewModel($product), $dataProvider->getModels());
        $dataProvider->setModels($products);

        return $this->render('view', [
            'model' => $this->findModel($producer_id),
            'dataProvider' => $dataProvider,
            'cartItemModel' => new CartItems(),
        ]);
    }


    /**
     * Creates a new Producers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProducerDetails();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'producer_id' => $model->producer_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Producers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $producer_id Producer ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($producer_id)
    {
        $model = $this->findModel($producer_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'producer_id' => $model->producer_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Producers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $producer_id Producer ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($producer_id)
    {
        $this->findModel($producer_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Producers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $producer_id Producer ID
     * @return ProducerDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($producer_id)
    {
        if (($model = ProducerDetails::findOne(['id' => $producer_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
