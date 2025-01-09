<?php

namespace frontend\controllers;

use common\models\BlogPosts;
use common\models\Comments;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class CommentPostController extends Controller
{
    //TODO: AO criar mandar para a view do post
    public function actionCreate($id)
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

        return $this->redirect(['/blog-post/view', 'id' => $id]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->id !== $model->user_id && !Yii::$app->user->can('admin')) {
            throw new ForbiddenHttpException('Você não tem permissão para deletar este post.');
        }

        $model->delete();

        return $this->redirect(['/blog-post/index']);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->id !== $model->user_id && !Yii::$app->user->can('admin')) {
            throw new ForbiddenHttpException('Você não tem permissão para atualizar este post.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/blog-post/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }



    protected function findModel($id)
    {
        if (($model = Comments::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('O comentário solicitado não existe.');
    }
}
