<?php

Yii::setAlias('backend', dirname(__DIR__));

return [
    'id' => 'app-backend',
    'name' => 'Classes.MD',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'admin/default/index',
    'modules' => [
        'admin' => [
            'class' => 'vova07\admin\Module'
        ],
        'users' => [
            'controllerNamespace' => 'vova07\users\controllers\backend'
        ],
        'blogs' => [
            'controllerNamespace' => 'vova07\blogs\controllers\backend'
        ],
        'klasses' => [
            'controllerNamespace' => 'pauko\klasses\controllers\backend'
        ],
        'accounts' => [
            'controllerNamespace' => 'pauko\accounts\controllers\backend'
        ],
        'trainers' => [
            'controllerNamespace' => 'pauko\trainers\controllers\backend'
        ],
        'halls' => [
            'controllerNamespace' => 'pauko\halls\controllers\backend'
        ],
        'taxonomy' => [
            'controllerNamespace' => 'pauko\taxonomy\controllers\backend'
        ],
        'comments' => [
            'isBackend' => true
        ],
        'rbac' => [
            'class' => 'vova07\rbac\Module',
            'isBackend' => true
        ],
        'i18n' => Zelenin\yii\modules\I18n\Module::className(),

        'gii' => [
        'class' => 'yii\gii\Module',
        ],



    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '7fdsf%dbYd&djsb#sn0mlsfo(kj^kf98dfh',
            'baseUrl' => '/backend'
        ],
        'urlManager' => [
            'rules' => [
                '' => 'admin/default/index',
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>'
            ]
        ],
        'view' => [
            'theme' => 'vova07\themes\admin\Theme'
        ],
        'errorHandler' => [
            'errorAction' => 'admin/default/error'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ]
    ],
    'params' => require(__DIR__ . '/params.php')
];
