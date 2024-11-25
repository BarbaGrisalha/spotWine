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
        'errorAction' => 'site/error', // Define qual ação será chamada para erros
    ],
    
    'request' => [
        #'baseUrl' => '/backend/web', // Ajuste o baseUrl conforme sua estrutura de diretórios
        'csrfParam' => '_csrf-backend',
    ],
    'user' => [
        'identityClass' => 'common\models\User',
        'enableAutoLogin' => true,
        'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
    ],
'session' => [
    'name' => 'advanced-backend', // Diferente do frontend
],


    'session' => [
        'name' => 'PHPBACKSESSID',
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            // Regras de URL
        ],
    ],
],



    'params' => $params,
];
