<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class BlogPostController extends ActiveController
{

    public $modelClass = 'common\models\BlogPosts';

    public function behaviors(){
        parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            'except' => ['index', 'view'],
        ];

        return $behaviors;
    }




}