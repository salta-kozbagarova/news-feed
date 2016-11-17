<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'site/default/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '1234',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'cookieParams' => ['domain' => '.rgkproject.kz'],
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/default/auth'],
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true, 'domain' => '.rgkproject.kz'],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => array(//'http://<admin:\w+>.rgkproject.kz/default/sign-in' => 'admin/default/sign-in',
                //'http://<admin:\w+>.rgkproject.kz/post/index' => 'admin/post/index',
                //'http://seven.rgkproject.kz/admin/post/update' => 'admin/post/update?id=7'
                 //'http://<login:[\w\-]+>.rgkproject.kz/site/<action:\w+>' => 'site/default/<action>', 
                 //'site/post/<action>'=>'http://<login:[\w\-]+>.rgkproject.kz/post/<action:\w+>',
                 //'http://rgkproject.kz/site/post/<action>'=>'site/post/index',
                //'http://<username:\w+>.rgkproject.kz/site/posts/<year:\d{4}>/<category>' => 'site/post/index',
                /*[
                    'pattern' => 'http://<subdomain:\w+>.rgkproject.kz/site/post/<action>',
                    'route' => 'site/post/<action>',
                    'defaults' => ['subdomain' => 'www'],
                ],*/
                /*[
                    'pattern' => 'http://<subdomain:\w+>.rgkproject.kz/site/post/<action>',
                    'route' => 'site/post/<action>',
                    'class' => 'app\components\MyUrlRule'
                ],*/
                /*[
                    'pattern' => 'http://<subdomain:\w+>.rgkproject.kz/site/post/<action>',
                    'route' => 'site/post/<action>',
                    'class' => 'app\components\Username2UrlRule'
                ],*/
                'http://<id:\d+>.rgkproject.kz'=>'site/post/view',
                //'http://<id:\d+>.kz'=>'site/post/view',
                //'posts'=>'site/post/index',
                [
                    'pattern' => 'http://www.rgkproject.kz',
                    'route' => 'site/default/index'
                ],
                )
        ],
        'errorHandler' => [
            'errorAction' => 'home/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => [],
        ],
    ],
    'params' => $params,
    'aliases' => [
        '@site' => '@app/modules/site',
        '@administratorHome' => '/admin/post/index',
        '@siteHome' => '/site/default/index'
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
        'site' => [
            'class' => 'app\modules\site\SiteModule',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    /*$config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];*/

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
