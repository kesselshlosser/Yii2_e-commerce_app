<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id'           => 'basic',
    'basePath'     => dirname(__DIR__),
    'bootstrap'    => ['log'],
    'language'     => 'en-En',
    'layout'       => 'main.twig',
    'defaultRoute' => 'category/index',
    'modules' => [
        'admin' => [
            'class'        => 'app\modules\admin\Module',
            'layout'       => 'admin',
            'defaultRoute' => 'site/index',
        ],
        'yii2images' => [
            'class' => 'rico\yii2images\Module',
            //be sure, that permissions ok
            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
            'imagesStorePath' => 'upload/store', //path to origin images
            'imagesCachePath' => 'upload/cache', //path to resized copies
            'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
            'placeHolderPath' => '@webroot/upload/store/no-image.jpg', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
            'imageCompressionQuality' => 100, // Optional. Default value is 85.
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JFTRdOh8n3xhxr6ZWl6iMjw5oeHPZ_yA',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                ],
            ],
            'useMemcached' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            //'loginUrl' => 'cart' happens if we try to log in. Redirecting on cart/index
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport'      => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => '',
                'username'   => '',
                'password'   => '',
                'port'       => '',
                'encryption' => '',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // More important rules must be located earlier
                'category/<id:\d+>/page-<page:\d+>' => 'category/view',
                'category/<id:\d+>'                 => 'category/view',
                'product/<id:\d+>'                  => 'product/view',
                'brand/<id:\d+>'                    => 'brand/view',
                'search'                            => 'category/search',
            ],
        ],
        'view' => [
            // Twig
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class'     => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => YII_DEBUG ? [
                        'debug'       => true,
                        'auto_reload' => true,
                    ] : [],
                    'extensions' => YII_DEBUG ? [
                        '\Twig_Extension_Debug',
                    ] : [],
                    'globals' => [
                       'html' => ['class' => '\yii\helpers\Html'],
                    ],
                    'uses' => ['\yii\bootstrap'],
                ],
            ],

            // AdminLTE
            'theme' => [
                'pathMap' => [
                    '@app/modules/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/testing/app'
                ],
            ],
        ],
        'emailService' => [
            'class' => 'app\components\EmailService'
        ],
    ],
    'controllerMap' => [
        'elfinder'  => [
            'class'  => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root'   => [
                'baseUrl' =>'/web',
                'path'    => 'upload/global',
                'name'    => 'Global'
            ],
        ]
    ],
    'params'  => $params,
    'aliases' => [
        '@uploadDir' => 'upload/store/'
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
