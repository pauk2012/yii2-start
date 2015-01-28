<?php

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'bootstrap' => [
        'log'
    ],
    'modules' => [
        'rbac' => [
            'class' => 'vova07\rbac\Module',
            'controllerNamespace' => 'vova07\rbac\commands'
        ],
        'users' => [
            'class' => 'vova07\users\Module',
            'controllerNamespace' => 'vova07\users\commands'
        ],
        'blogs' => [
            'class' => 'vova07\blogs\Module',
            'controllerNamespace' => 'vova07\blogs\commands'
        ],
        'comments' => [
            'class' => 'vova07\comments\Module',
            'controllerNamespace' => 'vova07\comments\commands'
        ],

        'klasses' => [
            'class' => 'pauko\klasses\Module',
            'controllerNamespace' => 'pauko\klasses\commands'
        ],
        'accounts' => [
            'class' => 'pauko\accounts\Module',
            'controllerNamespace' => 'pauko\accounts\commands'
        ],
        'trainers' => [
            'class' => 'pauko\trainers\Module',
            'controllerNamespace' => 'pauko\trainers\commands'
        ],
        'halls' => [
            'class' => 'pauko\halls\Module',
            'controllerNamespace' => 'pauko\halls\commands'
        ],
        'taxonomy' => [
            'class' => 'pauko\taxonomy\Module',
            'controllerNamespace' => 'pauko\taxonomy\commands'
        ],
        'geo' => [
            'class' => 'pauko\geo\Module',
            'controllerNamespace' => 'pauko\geo\commands'
        ]



    ],
    'components' => [
        'log' => [
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
