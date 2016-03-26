<?php
/**
 * Application configuration shared by all applications and test types
 */
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=test_klasses_pro',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
