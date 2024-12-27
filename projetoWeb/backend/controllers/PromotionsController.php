<?php

namespace backend\controllers;

use common\models\ProducerDetails;
use common\models\Producers;
use common\models\Product;
use common\models\PromotionProduct;
use common\models\Promotions;
use backend\models\PromotionSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PromotionsController implements the CRUD actions for Promotions model.
 */
class PromotionsController extends Controller
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
                    'class' => \yii\filters\VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin'], // Admin tem acesso total
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'update', 'delete', 'view'],
                            'roles' => ['producer'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create', 'update', 'delete', 'index', 'view'],
                            'roles' => ['manageOwnPromotions'],
                            'matchCallback' => function ($rule, $action) {
                                $promotionId = Yii::$app->request->get('promotion_id');
                                $model = $promotionId ? Promotions::findOne($promotionId) : null;

                                return !$model || Yii::$app->user->can('manageOwnPromotions', ['promotion' => $model]);
                            },
                        ],
                    ],
                ],
            ]
        );
    }



    /**
     * Lists all Promotions models.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Verificar se o usuário logado é um produtor
        $producer = Yii::$app->user->identity->producerDetails;
        if (!$producer) {
            throw new \yii\web\ForbiddenHttpException('Você precisa ser um produtor para acessar esta página.');
        }

        // Cria um modelo de busca
        $searchModel = new PromotionSearch();

        // Recupera os dados de promoções filtrados pelos parâmetros da requisição
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Filtra as promoções para incluir apenas as do produtor logado
        $dataProvider->query->andWhere(['producer_id' => $producer->id]);

        // Renderiza a página com os dados
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Promotions model.
     * @param int $promotion_id Promotion ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($promotion_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($promotion_id),
        ]);
    }

    /**
     * Creates a new Promotions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Promotions();
        $producer = ProducerDetails::findOne(['user_id' => Yii::$app->user->id]);

        if (!$producer) {
            throw new ForbiddenHttpException('Você não é um produtor registrado.');
        }

        $model->producer_id = $producer->id;

        if ($model->load(Yii::$app->request->post()) && $model->savePromotion()) {
            Yii::$app->session->setFlash('success', 'Promoção criada com sucesso.');
            return $this->redirect(['view', 'promotion_id' => $model->promotion_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'availableProducts' => Product::find()->where(['producer_id' => $producer->id])->all(),
        ]);
    }


    /**
     * Updates an existing Promotions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $promotion_id Promotion ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($promotion_id)
    {
        $model = $this->findModel($promotion_id);

        // Verifica se a promoção pertence ao produtor logado
        if ($model->producer_id !== Yii::$app->user->identity->getProducerId()) {
            throw new ForbiddenHttpException('Você não tem permissão para editar esta promoção.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'promotion_id' => $model->promotion_id]);
        }

        $availableProducts = Product::findByProducer(Yii::$app->user->identity->getProducerId())->all();
        return $this->render('update', [
            'model' => $model,
            'availableProducts' => $availableProducts,
        ]);
    }

    /**
     * Deletes an existing Promotions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $promotion_id Promotion ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($promotion_id)
    {
        $model = $this->findModel($promotion_id);

        if ($model->producer_id !== Yii::$app->user->identity->getProducerId()) {
            throw new NotFoundHttpException('Você não tem permissão para deletar esta promoção.');
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Promotions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $promotion_id Promotion ID
     * @return Promotions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($promotion_id)
    {
        if (($model = Promotions::findOne(['promotion_id' => $promotion_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('A promoção solicitada não existe.');
    }
}
