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
                        'GET ' => 'index',                         // Retorna o carrinho
                        'POST items' => 'add',                     // Adiciona um item
                        'PATCH items/{id}' => 'update',            // Atualiza a quantidade de um item
                        'DELETE items/{id}' => 'delete',           // Remove um item
                        'DELETE ' => 'clear-cart',                 // Esvazia o carrinho
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
                        'POST {id}' => 'checkout',
                        'POST payment/{invoiceId}' => 'payment',
                        'GET confirmation/{orderId}' => 'confirmation',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/order'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET all' => 'all', // Apenas admin
                        'GET my-orders' => 'my-orders', // Apenas usuário logado ou admin
                        'GET {id}' => 'view', // Ordem específica (Admin ou usuário dono)
                        'PUT {id}' => 'update', // Apenas admin
                        'DELETE {id}' => 'delete', // Apenas admin
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/review'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET all' => 'all', // Mostrar todas as reviews (admin)
                        'GET {id}' => 'product-reviews', // Reviews de um produto
                        'POST ' => 'create', // Criar review
                        'PUT {id}' => 'update', // Atualizar review
                        'DELETE {id}' => 'delete', // Deletar review
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' =>  ['api/blog-post'],
                    'pluralize' => false,

                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' =>  ['api/comment'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET post-comments/{id}' => 'post-comments',
                        ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' =>  ['api/product'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET view/{product_id}' => 'view',
                        'GET' => 'all-products'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' =>  ['api/favorite'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET ' => 'index',
                        'POST {id}' => 'add',
                        'DELETE {id}' => 'remove',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];


