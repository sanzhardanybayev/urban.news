<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'Urban News!',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableAccountDelete' => true,
            'modelMap' => [
                'User' => 'app\models\User',
                'RegistrationForm' => 'app\models\RegistrationForm',
                'Mailer' => 'app\models\Mailer',
                'ResendForm' => 'app\models\ResendForm',
                'SettingsForm' => 'app\models\user\SettingsForm',
                'Token' => 'app\models\Token',
            ],
            'controllerMap' => [
                'news' => 'app\controllers\NewsController',
                'admin' => 'app\controllers\user\AdminController',
                'profile' => 'app\controllers\user\ProfileController',
                'recovery' => 'app\controllers\user\RecoveryController',
                'registration' => 'app\controllers\user\RegistrationController',
                'security' => 'app\controllers\user\SecurityController',
                'settings' => 'app\controllers\user\SettingsController',
                'users' => 'app\controllers\user\UsersController',
            ],
            'confirmWithin' => 21600,
            'cost' => 12,
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
        'mailer' => [
            'sender' => 'php.mailer.excelsior@gmail.com', // or ['no-reply@myhost.com' => 'Sender name']
            'welcomeSubject' => 'Welcome subject',
            'confirmationSubject' => 'Confirmation subject',
            'reconfirmationSubject' => 'Email change subject',
            'recoverySubject' => 'Recovery subject',
        ],
    ],
    'components' => [
        'errorHandler' => [
            'maxSourceLines' => 20,
        ],
        'pusher' => [
            'class' => 'app\components\PusherCreator',
          //Mandatory parameters
            'appId' => '300337',
            'appKey' => '34dc4395b1458c85b3ef',
            'appSecret' => '7e36ccd9e01a69e38a2b',
          //Optional parameter
            'options' => ['encrypted' => true,
                'cluster' => 'ap2']
        ],
        'utility' => [
            'class' => 'app\components\utility'
        ],
        'request' => [
          // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-54_EHuCJHZLaTiOyy3owc3BqcayyBes',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        // No need to use presets
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => []
                ],
                'yii\validators\ValidationAsset' =>[
                    'js' => []
                ],
                'yii\web\YiiAsset' => [
                    'js' => [],
                    'css' => []
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],

            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user',
                    '@dektrium/user/views/mail' => '@app/views/user/mail',
                    '@dektrium/rbac/views' => '@app/views/rbac',
                ],
            ],
        ],
//        'user' => [
//            'identityClass' => 'app\models\User',
//            'enableAutoLogin' => true,
//        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'php.mailer.excelsior@gmail.com',
                'password' => 'qwe123#@!',
                'port' => '587',
                'encryption' => 'tls',
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '/',
            'rules' => [
                '/news/update/<id:\d+>/' => 'news/updateone',
                'news/delete/<id:\d+>/' => 'news/delete',
                'news/publish/<id:\d+>/' => 'news/publish',
                'news/<id:\d+>/' => 'news/view',
                'user/login/<test:\w+>/' => 'user/security/testlogin',
                'user/settings/id/<id:\d+>' => 'user/settings/id',
                'user/settings/saveprofile/<id:\d+>' => 'user/settings/saveidprofile',
                '/user/profile/show/<id:\d+>' => 'user/profile/show',
                '/user/profile/show/<id:\d+>' => 'user/profile/show',
                'user/register/<role:\w+>' => 'user/registration/register',
                '/user/profile/' => 'user/profile/',
                '/user/settings/saveprofile/' => '/user/settings/saveprofile',
                '/user/pusher/' => 'user/settings/pusher',
                'user/<username:\w+>' => 'user/profile/showit',
                'page/<page:\d+>/' => '/site/index',
                'notify/' => 'site/notify',
                'test/' => 'site/test',
                'news/page/<page:\d+>/' => 'news/index',
                'news/update/user/<user_id:\d+>/article/<post_id:\d+>' => 'news/update',
                'news/update/<post_id:\d+>' => 'news/update',
                'users/' => 'user/users/',
                '/user/ban/<id:\d+>/' => 'user/users/block',
                '/event/add/' => '/events/addevent',
                '/user/delete/<id:\d+>/' => '/user/settings/delete',
                '/user/change/role/<id:\d+>/<role:\w+>/' => '/user/settings/setrole'

            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
//     configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.3', 'news.portal'] // adjust this to your needs
//    ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
      'class' => 'yii\gii\Module',
      'allowedIPs' => ['127.0.0.1', '::1', 'news.fixie.kz', '5.101.120.35', 'news.portal'] // adjust this to your needs
  ];



}

return $config;
