<?php

namespace backend\controllers;

use backend\models\Producers;
use backend\models\ProducersSearch;
use common\models\User;

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


        $model = new User();
        $producer = new Producers();

        if ($model->load(Yii::$app->request->post()) && $producer->load(Yii::$app->request->post())) {
            // Transação para garantir que ambas as tabelas sejam salvas corretamente
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Configurando campos específicos do User
                $model->role = 'producer'; // Configura o campo role
                $model->status = 9; // Status padrão. Falta configurar o email para validação
                if ($model->save()) {
                    // Relacionando o user_id com producer
                    $producer->user_id = $model->id;
                    $producer->role = 'producer'; // Configura o campo role em producers
                    if ($producer->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Produtor criado com sucesso.');
                        return $this->redirect(['view', 'producer_id' => $producer->producer_id]);
                    }
                    if (!$model->save()) {
                        Yii::$app->session->setFlash('error', 'Erro ao salvar o usuário: ' . implode(', ', $model->getFirstErrors()));
                        $transaction->rollBack();
                        return $this->render('create', [
                            'model' => $model,
                            'producer' => $producer,
                        ]);
                    }

                    if (!$producer->save()) {
                        Yii::$app->session->setFlash('error', 'Erro ao salvar o produtor: ' . implode(', ', $producer->getFirstErrors()));
                        $transaction->rollBack();
                        return $this->render('create', [
                            'model' => $model,
                            'producer' => $producer,
                        ]);
                    }
                }
                $transaction->rollBack();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('create', [
            'model' => $model,
            'producer' => $producer,
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
        /*
        $model = $this->findModel($producer_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'producer_id' => $model->producer_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
        */
        $producer = $this->findModel($producer_id);
        $user = User::findOne($producer->user_id);

        if ($this->request->isPost && $producer->load($this->request->post()) && $user->load($this->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($user->save() && $producer->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Produtor atualizado com sucesso.');
                    return $this->redirect(['view', 'producer_id' => $producer->producer_id]);
                }
                $transaction->rollBack();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('update', [
            'model' => $user,
            'producer' => $producer,

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
