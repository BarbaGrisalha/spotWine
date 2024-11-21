<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    // Configuração de restrição de acesso
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'roles' => ['admin'], // Apenas usuários com a role 'admin' podem acessar
            ],
            [
                'allow' => false, // Bloquear todos os outros
            ],
        ],
        'denyCallback' => function ($rule, $action) {
            if (Yii::$app->user->isGuest) {
                return Yii::$app->response->redirect(['/site/login']); // Redireciona para login
            }
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta página.');
        },
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

            ],
        ],

    ],
    'params' => $params,
];
