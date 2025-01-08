<?php

namespace backend\controllers;

use common\models\BlogPostSearch;
use common\models\Comments;
use Yii;
use common\models\BlogPosts;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class BlogPostController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // Regra para ações públicas (apenas visualização)
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@'], // Ações visíveis para todos (não autenticados e autenticados)
                    ],
                    // Regra para criar post (somente produtores e admins)
                    [
                        'actions' => ['create', 'comment'],
                        'allow' => true,
                        'roles' => ['createPosts', 'commentsOnPosts'], // Permissões associadas às roles
                    ],
                    // Regra para deletar/atualizar posts próprios
                    [
                        'actions' => ['delete', 'update'],
                        'allow' => true,
                        'roles' => ['@'], // Apenas usuários autenticados
                        'matchCallback' => function ($rule, $action) {
                            $postId = Yii::$app->request->get('id');
                            $post = BlogPosts::findOne($postId);
                            return $post && Yii::$app->user->can($action->id . 'OwnPost', ['post' => $post]);
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'], // Delete só pode ser realizado por POST
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new BlogPostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        // ActiveDataProvider para os comentários
        $commentsDataProvider = new ActiveDataProvider([
            'query' => $model->getComments()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10, // Ajuste o número de comentários por página, se necessário
            ],
        ]);

        // Modelo para um novo comentário
        $newComment = new \common\models\Comments();
        $newComment->blog_post_id = $model->id;

        return $this->render('view', [
            'model' => $model,
            'commentsDataProvider' => $commentsDataProvider,
            'newComment' => $newComment,
        ]);
    }

    public function actionCreate()
    {
        $model = new BlogPosts();
        $model->user_id = Yii::$app->user->id; // Define o ID do produtor logado

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Verificar permissão para atualizar o post
        if (!Yii::$app->user->can('updateOwnPost', ['post' => $model]) && !Yii::$app->user->can('admin')) {
            throw new ForbiddenHttpException('Você não tem permissão para editar este post.');
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

        // Verificar permissão para deletar o post
        if (!Yii::$app->user->can('deleteOwnPost', ['post' => $model]) && !Yii::$app->user->can('admin')) {
            throw new ForbiddenHttpException('Você não tem permissão para deletar este post.');
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Post deletado com sucesso.');
        return $this->redirect(['index']);
    }



    //TODO: Fix produtor nao está tendo permissao para comentar
    public function actionComment($id)
    {
        $model = BlogPosts::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('O post não foi encontrado.');
        }

        $newComment = new Comments();
        $newComment->blog_post_id = $id;
        $newComment->user_id = Yii::$app->user->id;

        if ($newComment->load(Yii::$app->request->post()) && $newComment->save()) {
            Yii::$app->session->setFlash('success', 'Comentário adicionado com sucesso.');
            return $this->redirect(['view', 'id' => $id]);
        }

        Yii::$app->session->setFlash('error', 'Não foi possível adicionar o comentário.');
        return $this->redirect(['view', 'id' => $id]);
    }



    protected function findModel($id)
    {
        if (($model = BlogPosts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
