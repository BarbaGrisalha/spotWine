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

    'components' => [
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    
    'request' =>[
        'enableCsrfValidation' => false,
        'csrfParam' => '_csrf-backend',
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ],
    ],
    'user' => [
        'identityClass' => 'common\models\User',
        'enableAutoLogin' => true,
        'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
    ],
    'session' => [
        'name' => 'advanced-backend',
    ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list-all' => 'list-all',
                        'GET view/{id}' => 'view',
                        'POST login' => 'login',
                        'POST registo' => 'registo',
                        'PUT editar' => 'editar',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/cart'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}' => 'index',
                        'GET {id}/items' => 'items',
                        'POST add' => 'add',
                        'PUT update/{id}' => 'update',
                        'DELETE delete/{id}' => 'delete',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/invoice'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST' => 'create',
                        'PUT update-status/{id}' => 'update-status',
                        'GET all' => 'all',
                        'GET my-invoices' => 'my-invoices',
                        'GET {id}' => 'view',
                        'PUT {id}' => 'update',
                        'DELETE {id}' => 'delete',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/checkout'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST {invoiceId}' => 'checkout',
                        'POST payment/{invoiceId}' => 'payment',
                        'GET confirmation/{orderId}' => 'confirmation',
                    ],
                ],

            ],
        ],




    ],



    'params' => $params,
];
