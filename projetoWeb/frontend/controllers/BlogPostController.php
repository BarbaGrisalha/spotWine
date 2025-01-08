<?php

namespace frontend\controllers;

use common\models\BlogPosts;
use common\models\BlogPostSearch;
use common\models\Comments;
use common\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class BlogPostController extends \yii\web\Controller
{
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
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Você precisa estar logado para criar um post.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Define o ID do usuário logado no modelo

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Não foi possível criar o post. Verifique e tente novamente.');
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

    public function actionComment($id)
    {
        $model = BlogPosts::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('O post solicitado não foi encontrado.');
        }

        $comment = new Comments();
        $comment->blog_post_id = $id;
        $comment->user_id = Yii::$app->user->id;

        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            Yii::$app->session->setFlash('success', 'Comentário adicionado com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Não foi possível adicionar o comentário. Verifique os dados e tente novamente.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }



    protected function findModel($id)
    {
        if (($model = BlogPosts::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('O post solicitado não existe.');
    }

}
