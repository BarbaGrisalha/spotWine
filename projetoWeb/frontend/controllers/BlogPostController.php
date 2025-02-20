<?php

namespace frontend\controllers;

use common\models\BlogPosts;
use common\models\BlogPostSearch;
use common\models\Comments;
use common\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class BlogPostController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [

                    [
                        'actions' => ['create', 'update', 'delete'],
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

    public function actionIndex()
    {
        $searchModel = new BlogPostSearch();

        // Controle via GET para exibir todos ou apenas os próprios posts
        $showAll = Yii::$app->request->get('showAll', true);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $showAll);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'showAll' => $showAll,
        ]);
    }


    public function actionCreate()
    {
        $model = new BlogPosts();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile'); // Captura o arquivo enviado

            if ($model->upload() && $model->save()) {
                Yii::$app->session->setFlash('success', 'Post criado com sucesso!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao salvar o post.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Verifica se o usuário tem permissão
        if (Yii::$app->user->id !== $model->user_id && !Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para atualizar este post.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Verifica se o usuário tem permissão
        if (Yii::$app->user->id !== $model->user_id && !Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para deletar este post.');
        }

        $model->delete();

        return $this->redirect(['index']);
    }


    public function actionView($id)
    {
        $model = BlogPosts::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('O post solicitado não foi encontrado.');
        }

        $commentsDataProvider = new ActiveDataProvider([
            'query' => $model->getComments()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $newComment = new Comments();

        return $this->render('view', [
            'model' => $model,
            'newComment' => $newComment,
            'commentsDataProvider' => $commentsDataProvider,
        ]);
    }



    protected function findModel($id)
    {
        if (($model = BlogPosts::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('O post solicitado não existe.');
    }

}
