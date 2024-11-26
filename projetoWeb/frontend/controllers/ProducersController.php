<?php

namespace frontend\controllers;

use common\models\Producers;
use frontend\models\ProducersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $searchModel = new ProducersSearch();
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
        return $this->render('view', [
            'model' => $this->findModel($producer_id),
        ]);
    }

    /**
     * Creates a new Producers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Producers();

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
     * @return Producers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($producer_id)
    {
        if (($model = Producers::findOne(['producer_id' => $producer_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
