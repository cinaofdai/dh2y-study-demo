<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'index',
    'language' => 'zh-CN',
    'charset' => 'utf-8',
    'components' => [
        'assetManager'=>[//前端资源压缩管理
            'class'=>'yii\web\AssetManager',
            'bundles'=>[
                'yii\web\JqueryAsset'=>[
                    'js'=>[
                        YII_ENV_DEV?'jquery.js':'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset'=>[
                    'css'=>[
                        YII_ENV_DEV?'css/bootstrap.css':'css/bootstrap.min.css'
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset'=>[
                    'js'=>[
                        YII_ENV_DEV?'js/bootstrap.js':'js/bootstrap.min.js'
                    ]
                ]
            ]
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'q6ga0ArPuP1iWsey2H6aoeWsP7G98FnL',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [ //登录组件
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'idParam' => '__user', //session分开标识
            'identityCookie' => ['name'=>'_user_identity','httpOnly' => true],//cookie实例分开标识
            'loginUrl' => ['member/auth'] //登录页面
        ],
        'admin' =>[ //配置后台登录组件
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\models\Admin',
            'enableAutoLogin' => true,
            'idParam' => '__admin',
            'identityCookie' => ['name'=>'_admin_identity','httpOnly' => true],
            'loginUrl' => ['admin/public/login'] //登录页面
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.qq.com',
                'username' => '913992589@qq.com',
                'password' => 'niwkqqvwqpudbdaj',
                'port' => '465',
                'encryption' => 'ssl',
            ]

        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1'],
    ];
    $config['modules']['admin'] = [
        'class' => 'app\modules\admin',
    ];
}

return $config;
