<?php

namespace backend\controllers;

use common\models\BlogPosts;
use common\models\Comments;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class CommentPostController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,

                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@'], // Ações visíveis para todos (não autenticados e autenticados)
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['commentOnPosts'], // Ações visíveis para todos (não autenticados e autenticados)
                    ],
                    [
                        'actions' => ['delete', 'update'],
                        'allow' => true,
                        'roles' => ['@'], // Qualquer usuário autenticado
                        'matchCallback' => function ($rule, $action) {
                            $commentId = Yii::$app->request->get('id');
                            $comment = Comments::findOne($commentId);

                            // Verifica se o usuário é dono do comentário ou se é admin
                            return $comment && (
                                    Yii::$app->user->can($action->id . 'OwnComment', ['comment' => $comment]) ||
                                    Yii::$app->user->can('manageAllComments')
                                );
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionCreate($id)
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
            return $this->redirect(['/blog-post/view', 'id' => $id]);
        }

        Yii::$app->session->setFlash('error', 'Não foi possível adicionar o comentário.');

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionIndex($id)
    {
        $model = BlogPosts::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Post inválido.');
        }

        $comments = $model->getComments()->all();

        return $this->render('index', ['comments' => $comments, 'model' => $model] );
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/blog-post/view', 'id' => $model->blog_post_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionView()
    {
        return $this->render('view');
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->delete();

        Yii::$app->session->setFlash('success', 'Post deletado com sucesso.');
        return $this->redirect(['/blog-post/view', 'id' => $model->blog_post_id]);
    }

    public function findModel($id)
    {
        if (($model = Comments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Comentário não encontrado.');
    }
}
