<?php
return [

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        //Configuração do authManager para poder gerir as Roles(Consumidor, Produtor e Administrador)
        'authManager' =>[
            'class'=>'yii\rbac\DbManager',// Utiliza o RBAC com base em banco de dados
        ],

    ],
];
