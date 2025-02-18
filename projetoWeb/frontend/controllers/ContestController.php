<?php

namespace frontend\controllers;

use common\models\ContestParticipations;
use common\models\Contests;
use common\models\ContestsSearch;
use common\models\ContestVotes;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContestController implements the CRUD actions for Contests model.
 */
class ContestController extends Controller
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

        // Atualiza o status de todos os concursos
        foreach ($dataProvider->getModels() as $contest) {
            $contest->updateStatus();
        }


        return $this->render('index', [
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
        $contest = Contests::findOne($id);

        if (!$contest) {
            throw new NotFoundHttpException('Concurso não encontrado.');
        }

        $contest->updateStatus();

        return $this->render('view', [
            'contest' => $contest,
        ]);
    }





    public function actionVote($id)
    {
        $contest = Contests::findOne($id);
        $userId = Yii::$app->user->id;

        if (!$contest || $contest->status !== 'voting') {
            throw new NotFoundHttpException('Este concurso não está aberto para votação.');
        }

        $products = ContestParticipations::find()
            ->where(['contest_id' => $id])
            ->joinWith('product') // Obtém os produtos associados
            ->all();

        $hasVoted = ContestVotes::find()
            ->where(['contest_id' => $id, 'user_id' => $userId])
            ->exists();


        return $this->render('vote', [
            'contest' => $contest,
            'products' => $products,
            'hasVoted' => $hasVoted,
        ]);
    }


    public function actionSubmitVote($contest_id, $product_id)
    {
        $userId = Yii::$app->user->id;

        // Verifica se o usuário já votou nesse concurso
        $existingVote = ContestVotes::find()
            ->where(['contest_id' => $contest_id, 'user_id' => $userId])
            ->exists();

        if ($existingVote) {
            Yii::$app->session->setFlash('error', 'Você já votou neste concurso.');
            return $this->redirect(['vote', 'id' => $contest_id]);
        }

        // Salvar o voto no banco de dados
        $vote = new ContestVotes();
        $vote->contest_id = $contest_id;
        $vote->product_id = $product_id;
        $vote->user_id = $userId;

        if ($vote->save()) {
            Yii::$app->session->setFlash('success', 'Seu voto foi registrado com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao registrar o voto.');
        }

        return $this->redirect(['vote', 'id' => $contest_id]);
    }

    protected function findModel($id)
    {
        if (($model = Contests::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
