<?php

namespace backend\modules\api\controllers;

use common\models\BlogPosts;
use common\models\Comments;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class CommentController extends ActiveController
{
    public $modelClass = 'common\models\Comments';

    public function behaviors(){
        parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => ['index', 'view', 'post-comments'],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'],$actions['delete'], $actions['update']);

        return $actions;
    }

    public function actionPostComments($id)
    {
        $postExists = BlogPosts::findOne($id);

        if (!$postExists) {
            throw new NotFoundHttpException('Post não encontrado.');
        }

        $comments = new ActiveDataProvider([
            'query' => Comments::find()->where(['blog_post_id' => $id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $comments;
    }


    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        $data = Yii::$app->request->post();

        $comment = new Comments();
        $comment->user_id = $user->id;
        $comment->blog_post_id = $data['blog_post_id'] ?? null;
        $comment->comment_text = $data['comment_text'] ?? null;

        if (!$comment->blog_post_id || !$comment->comment_text) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Os campos post_id e content são obrigatórios.'];
        }

        if ($comment->save()) {
            return [
                'message' => 'Comentário criado com sucesso.',
                'comment' => $comment
            ];
        }

        Yii::$app->response->statusCode = 422;
        return ['error' => $comment->errors];
    }

    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        $comment = Comments::findOne($id);

        if (!$comment) {
            throw new NotFoundHttpException('Comentário não encontrado.');
        }

        if ($comment->user_id !== $user->id && !Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para atualizar este comentário.');
        }

        $data = Yii::$app->request->post();
        $comment->comment_text = $data['comment_text'] ?? $comment->comment_text;

        if ($comment->save()) {
            return [
                'message' => 'Comentário atualizado com sucesso.',
                'comment' => $comment
            ];
        }

        Yii::$app->response->statusCode = 422;
        return ['error' => $comment->errors];
    }

    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        $comment = Comments::findOne($id);

        if (!$comment) {
            throw new NotFoundHttpException('Comentário não encontrado.');
        }

        if ($comment->user_id !== $user->id && !Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para excluir este comentário.');
        }

        if ($comment->delete()) {
            return ['message' => 'Comentário deletado com sucesso.'];
        }

        Yii::$app->response->statusCode = 422;
        return ['error' => 'Erro ao deletar o comentário.'];
    }

}