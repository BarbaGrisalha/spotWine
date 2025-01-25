<?php

namespace backend\controllers;

use common\helpers\FileUploadHelper;
use common\models\ContestParticipations;
use common\models\Contests;
use common\models\ContestsSearch;
use common\models\ProducerDetails;
use common\models\Product;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ContestsController implements the CRUD actions for Contests model.
 */
class ContestsController extends Controller
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
     * Lists all Contests models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ContestsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProducerIndex()
    {
        $searchModel = new ContestsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('producer-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contests model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Contests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Contests();

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'imageFile');

            if($file){
                $imageUrl = FileUploadHelper::upload($file, 'contests');
                if($imageUrl){
                    $model->image_url = $imageUrl;
                }else{
                    Yii::$app->session->setFlash('error', 'Erro ao fazer upload da imagem.');
                    return $this->render('create', ['model' => $model]);
                }
            }
            // Define o status inicial como 'pending'
            $model->status = 'pending';

            // Se salvar com sucesso, redireciona para a página de visualização
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Concurso criado com sucesso!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao criar concurso.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $file = UploadedFile::getInstance($model, 'imageFile');

            if($file){
                $imageUrl = FileUploadHelper::upload($file, 'contests');
                if($imageUrl){
                    $model->image_url = $imageUrl;
                }else{
                    Yii::$app->session->setFlash('error', 'Erro ao fazer upload da imagem.');
                    return $this->render('create', ['model' => $model]);
                }
            }

            // Se salvar com sucesso, redireciona para a página de visualização
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Concurso atualizado com sucesso!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao atualizar concurso.');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Contests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionRegisterProducer($id)
    {
        // Busca o concurso pelo ID
        $contest = Contests::findOne($id);

        if (!$contest) {
            throw new \yii\web\NotFoundHttpException('Concurso não encontrado.');
        }

        // Obtem o ID do produtor logado
        $producerId = ProducerDetails::findOne(['user_id' => Yii::$app->user->id])->id;

        // Verifica se já está inscrito
        $registrationExists = ContestParticipations::find()
            ->where(['contest_id' => $contest->id, 'producer_id' => $producerId])
            ->exists();

        if ($registrationExists) {
            Yii::$app->session->setFlash('error', 'Você já está registrado neste concurso.');
            return $this->redirect(['producer-index']);
        }

        // Busca os produtos do produtor relacionados à categoria do concurso
        $products = Product::find()
            ->where(['producer_id' => $producerId, 'category_id' => $contest->category_id])
            ->all();

        if (empty($products)) {
            Yii::$app->session->setFlash('error', 'Você não tem produtos compatíveis com a categoria deste concurso.');
            return $this->redirect(['producer-index']);
        }

        $participation = new ContestParticipations();

        if ($this->request->isPost) {
            $participation->load($this->request->post());
            $participation->contest_id = $contest->id;
            $participation->producer_id = $producerId;

            if ($participation->save()) {
                Yii::$app->session->setFlash('success', 'Inscrição realizada com sucesso!');
                return $this->redirect(['contests/confirmation', 'id' => $contest->id]);

            } else {
                Yii::$app->session->setFlash('error', 'Erro ao salvar a inscrição.');
            }
        }

        return $this->render('register-producer', [
            'contest' => $contest,
            'products' => $products,
            'participation' => $participation,
        ]);
    }

    public function actionDetails($id){
        $contest = Contests::findOne($id);

        return $this->render('details', [
            'contest' => $contest]);
    }

    public function actionConfirmation($id)
    {
        $contest = Contests::findOne($id);

        if (!$contest) {
            throw new NotFoundHttpException('O concurso solicitado não foi encontrado.');
        }

        return $this->render('confirmation', [
            'contest' => $contest,
        ]);
    }


    /**
     * Finds the Contests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Contests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contests::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
