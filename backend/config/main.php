<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl' => $params['frontendHostInfo'],
                    'basePath' => '@frontend/web',
                    'path' => 'upload',
                    'name' => 'Global'
                ],
                [
                    'class' => 'mihaildev\elfinder\volume\UserPath',
                    'path'  => 'files/user_{id}',
                    'name'  => 'My Documents'
                ],
                /*
                [
                    'path' => 'files/some',
                    'name' => ['category' => 'my','message' => 'Some Name'] //перевод Yii::t($category, $message)
                ],
                [
                    'path'   => 'files/some',
                    'name'   => ['category' => 'my','message' => 'Some Name'], // Yii::t($category, $message)
                    'access' => ['read' => '*', 'write' => 'UserFilesAccess'] // * - для всех с правами UserFilesAccess
                ]
                */
            ],
            /*
            'watermark' => [
                'source'         => __DIR__.'/logo.png', // Path to Water mark image
                'marginRight'    => 5,          // Margin right pixel
                'marginBottom'   => 5,          // Margin bottom pixel
                'quality'        => 95,         // JPEG image save quality
                'transparency'   => 70,         // Water mark image transparency ( other than PNG )
                'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
                'targetMinPixel' => 200         // Target image minimum pixel size
            ]
            */
        ]
    ],
    'bootstrap' => ['log'],
    'modules' => [],
    /*
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'controllers' => ['site'],
                'actions' => ['auth', 'access-denied'],
            ],
            [
                'allow' => false,
                'roles' => ['user'],
            ],
            [
                'allow' => true,
                'roles' => ['admin']
            ]
        ],
        'denyCallback' => function () {
            if( ! Yii::$app->user->isGuest ) {
                Yii::$app->user->logout();
            }
            return Yii::$app->response->redirect(['site/access-denied']);
        },
    ],
    */
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
        'user' => [
            'identityClass' => 'core\entities\User\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true, 'domain' => $params['cookieDomain']],
            'loginUrl' => 'site/auth',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced',
            'cookieParams' => [
                'httpOnly' => true,
                'domain' => $params['cookieDomain'],
            ],
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'backendUrlManager' => require __DIR__ . '/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/../../frontend/config/urlManager.php',
        'cabinetUrlManager' => require __DIR__ . '/../../cabinet/config/urlManager.php',
        'urlManager' => function() {
            return Yii::$app->get('backendUrlManager');
        },

    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['site/auth', 'site/error'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['admin'],
            ],
        ],
        'denyCallback' => function () {
            if( ! Yii::$app->user->isGuest ) {
                Yii::$app->user->logout();
            }
            //Yii::$app->session->setFlash('error', 'You don`t have permission to this section');
            return Yii::$app->response->redirect(['site/auth']);
        },
    ],
    'params' => $params,
];
